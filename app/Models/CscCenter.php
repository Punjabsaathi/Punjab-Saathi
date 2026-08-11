<?php
// app/Models/CscCenter.php

namespace App\Models;

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
     * Register new agent OR update existing one by mobile number.
     * Returns ['center' => CscCenter, 'action' => 'created'|'updated']
     */
    public static function registerOrUpdate(array $data): array
    {
        $mobile = preg_replace('/\D/', '', $data['mobile'] ?? '');

        $existing = static::where('mobile', $mobile)->first();

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
}