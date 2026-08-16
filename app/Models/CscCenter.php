<?php
// app/Models/CscCenter.php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CscCenter extends Model
{
    protected $table = 'csc_centers';

    protected $fillable = [
        'csc_id', 'vle_name', 'kiosk_name', 'mobile', 'email',
        'address', 'sub_district', 'district', 'state', 'pincode',
        'latitude', 'longitude', 'registered_on', 'source',
        'is_verified', 'is_active', 'notes','ip_address',
    ];

    protected $casts = [
        'is_verified'   => 'boolean',
        'is_active'     => 'boolean',
        'registered_on' => 'date',
    ];

    /**
     * Register new agent OR update existing one.
     *
     * Matches by csc_id first, then mobile. The bulk-imported dataset
     * almost never has a mobile number on file, so matching by mobile
     * alone (the old behaviour) never found the real existing record —
     * every self-registration became a duplicate instead of an update.
     * csc_id is present and reliable across the imported data, so it's
     * checked first; mobile remains the fallback for centers that were
     * themselves created via self-registration (no csc_id at all).
     *
     * Returns ['center' => CscCenter, 'action' => 'created'|'updated']
     */
    public static function registerOrUpdate(array $data): array
    {
        $mobile = preg_replace('/\D/', '', $data['mobile'] ?? '');
        $cscId  = trim((string) ($data['csc_id'] ?? ''));

        $existing = null;
        if ($cscId !== '') {
            $existing = static::where('csc_id', $cscId)->first();
        }
        if (!$existing && $mobile !== '') {
            $existing = static::where('mobile', $mobile)->first();
        }

        if ($existing) {
            // Update — never overwrite admin-only fields
            $update = array_filter($data, fn($v) => $v !== null && $v !== '');
            unset($update['is_verified'], $update['is_active'], $update['notes']);
            $update['mobile'] = $mobile;
            $existing->update($update);
            return ['center' => $existing->fresh(), 'action' => 'updated'];
        }

        $data['mobile'] = $mobile;
        $center = static::create($data);
        return ['center' => $center, 'action' => 'created'];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified', true);
    }

    /**
     * What the public directory should show: active centers, and —
     * critically — only gated by admin verification when the record
     * came from public self-registration. The bulk-imported government
     * dataset (source = locator.csccloud.in) is trustworthy on its own
     * and shouldn't be hidden just because nobody's clicked "Verify" on
     * 36,000 records in psk-admin; a citizen's own self-submitted entry
     * DOES need that review before it's shown as real.
     */
    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function (Builder $q) {
                $q->where('source', '!=', 'self-registered')
                  ->orWhere('is_verified', true);
            });
    }

    /**
     * Nearest-first distance search using the Haversine formula, with a
     * bounding-box pre-filter so MySQL can use the (latitude, longitude)
     * index to cut the candidate set before computing exact distance —
     * this is what keeps it fast at 36k+ rows without needing spatial
     * column types. Also excludes the small slice of imported rows with
     * garbage near-(0,0) coordinates so they can't pollute results.
     */
    public function scopeNearby(Builder $query, float $lat, float $lng, float $radiusKm = 50): Builder
    {
        // ~1 degree latitude ≈ 111km; pad the bounding box generously.
        $latDelta = $radiusKm / 111;
        $lngDelta = $radiusKm / (111 * max(cos(deg2rad($lat)), 0.1));

        $haversine = '(6371 * acos(least(1, greatest(-1,
            cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?))
            + sin(radians(?)) * sin(radians(latitude))
        ))))';

        // The radius filter uses its own whereRaw (not a HAVING on the
        // selected alias below) — Eloquent's paginate() builds its count
        // query by stripping the SELECT columns, which would drop the
        // "distance_km" alias a HAVING clause depends on and break
        // pagination. WHERE clauses survive that stripping, so filtering
        // here keeps ->paginate() working on this scope.
        return $query
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', 0)
            ->where('longitude', '!=', 0)
            ->whereBetween('latitude', [$lat - $latDelta, $lat + $latDelta])
            ->whereBetween('longitude', [$lng - $lngDelta, $lng + $lngDelta])
            ->whereRaw("{$haversine} <= ?", [$lat, $lng, $lat, $radiusKm])
            ->selectRaw("*, {$haversine} AS distance_km", [$lat, $lng, $lat])
            ->orderBy('distance_km');
    }
}