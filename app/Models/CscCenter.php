<?php
// app/Models/CscCenter.php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CscCenter extends Model
{
    protected $table = 'csc_centers';

    protected $fillable = [
        'csc_id', 'vle_name', 'kiosk_name', 'mobile', 'email',
        'address', 'sub_district', 'district', 'state', 'pincode',
        'latitude', 'longitude', 'registered_on', 'source',
        'is_verified', 'is_active', 'notes', 'ip_address',
        'meta_title', 'meta_description',
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

    public function faqs(): HasMany
    {
        return $this->hasMany(CscCenterFaq::class)->orderBy('sort_order');
    }

    // ── SEO helpers ─────────────────────────────────────────
    // Centralised here (rather than computed inline in the Blade view)
    // so the same display name / location line / meta text feed both
    // the page <title>/<meta> tags and the JSON-LD schema below,
    // instead of two copies drifting apart.

    public function getDisplayNameAttribute(): string
    {
        return $this->kiosk_name ?: $this->vle_name ?: 'CSC Center';
    }

    public function getLocationLineAttribute(): string
    {
        return trim(collect([$this->sub_district, $this->district, 'Punjab'])->filter()->implode(', '));
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title
            ?: "{$this->display_name} - CSC Center in {$this->district} | Punjab Saathi";
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description
            ?: "CSC Center {$this->display_name} in {$this->location_line}"
                . ($this->pincode ? " — Pincode {$this->pincode}" : '')
                . '. Contact details, address, and nearby CSC centers on Punjab Saathi.';
    }

    /**
     * JSON-LD LocalBusiness schema for the center's own show page — a VLE
     * kiosk is privately operated (not a government office itself), so
     * LocalBusiness fits better than GovernmentOffice. Only includes
     * geo/telephone when real data is on file rather than emitting
     * empty/zero values Google would rather not see at all.
     */
    public function toLocalBusinessSchema(): array
    {
        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => $this->display_name,
            'description' => "Common Service Center (CSC) offering government services in {$this->location_line}.",
            'url'         => route('csc.show', $this),
        ];

        if ($this->address) {
            $schema['address'] = [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $this->address,
                'addressLocality' => $this->sub_district ?: $this->district,
                'addressRegion'   => 'Punjab',
                'postalCode'      => $this->pincode,
                'addressCountry'  => 'IN',
            ];
        }

        // Same near-(0,0) garbage-coordinate problem scopeNearby() already
        // works around, but stricter: 568 imported rows have a near-zero
        // lat/long that isn't exactly 0 (e.g. 1.04, -0.26), so a plain
        // truthy/!=0/>1 check still lets obvious junk through. Instead,
        // require the coordinates to actually fall within Punjab's real
        // geographic bounding box (roughly 28-33°N, 72-78°E) before
        // publishing them as structured data.
        if ($this->latitude && $this->longitude
            && $this->latitude >= 28 && $this->latitude <= 33
            && $this->longitude >= 72 && $this->longitude <= 78) {
            $schema['geo'] = [
                '@type'     => 'GeoCoordinates',
                'latitude'  => (float) $this->latitude,
                'longitude' => (float) $this->longitude,
            ];
        }

        if ($this->mobile) {
            $schema['telephone'] = $this->mobile;
        }

        return $schema;
    }

    /**
     * JSON-LD BreadcrumbList for the center's show page. Deliberately a
     * PHP method (not built inline in the .blade.php file) — Blade scans
     * raw template text for directives before it cares about quotes, so a
     * literal '@context' string typed directly into a .blade.php file
     * gets swallowed by Blade's own @context/@endcontext directive and
     * silently corrupted. Keeping this in real PHP sidesteps that.
     */
    public function toBreadcrumbSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Find a CSC Center', 'item' => route('csc.directory')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $this->display_name, 'item' => route('csc.show', $this)],
            ],
        ];
    }

    /**
     * JSON-LD FAQPage schema — null when there are no FAQs on file rather
     * than an empty shell, since Google's guidance is explicit that
     * FAQPage schema must match content actually visible on the page;
     * emitting it for centers with no real Q&A would be exactly the
     * "structured data with no matching visible content" pattern that
     * gets flagged. The Blade view only renders this script tag when it's
     * non-null, so the schema and the visible FAQ list stay in sync.
     */
    public function toFaqSchema(): ?array
    {
        if ($this->faqs->isEmpty()) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $this->faqs->map(fn (CscCenterFaq $faq) => [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq->answer,
                ],
            ])->all(),
        ];
    }
}