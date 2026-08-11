<?php

namespace App\Helpers;

class SeoHelper
{
    public static function title(string $page, ?string $suffix = null): string
    {
        $base = config('app.name', 'Punjab Seva Kendra');
        $suffix = $suffix ?? 'Download Government Forms Online';
        return "{$page} | {$base} – {$suffix}";
    }

    public static function description(string $fallback = ''): string
    {
        return $fallback ?: 'Download government forms and documents online. PAN Card, Passport, Aadhaar, Voter ID, Driving License and more — Punjab Seva Kendra.';
    }

    public static function ogTags(string $title, string $description, ?string $image = null, string $type = 'website'): array
    {
        return [
            'og:type'        => $type,
            'og:title'       => $title,
            'og:description' => $description,
            'og:image'       => $image ?? asset('images/og-default.jpg'),
            'og:url'         => url()->current(),
            'og:locale'      => 'en_IN',
            'og:site_name'   => config('app.name', 'Punjab Seva Kendra'),
        ];
    }

    public static function twitterTags(string $title, string $description, ?string $image = null): array
    {
        return [
            'twitter:card'        => 'summary_large_image',
            'twitter:title'       => $title,
            'twitter:description' => $description,
            'twitter:image'       => $image ?? asset('images/og-default.jpg'),
        ];
    }
}
