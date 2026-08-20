<?php

namespace App\Support;

// Shared JSON-LD builders reused across many controllers/views so the same
// Organization/WebSite identity and breadcrumb shape don't get re-typed
// (and drift out of sync) on every page. Built in real PHP, never inline in
// a .blade.php file — a literal '@context' string typed directly into a
// Blade template gets silently mangled by Blade's own @context/@endcontext
// directive before it's quote-aware.
class Seo
{
    public static function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => config('site.name'),
            'url'      => config('site.website'),
            'logo'     => asset('images/punjab-saathi-logo.webp'),
            'email'    => config('site.email'),
            'telephone' => config('site.phone'),
            'address'  => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => config('site.address'),
                'addressRegion'   => 'Punjab',
                'addressCountry'  => 'IN',
            ],
            'sameAs' => array_values(array_filter(config('site.social', []))),
        ];
    }

    public static function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => config('site.name'),
            'url'      => config('site.website'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => url('/csc-centers') . '?pincode={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * @param  array<int, array{name: string, url: string}>  $items
     */
    public static function breadcrumbSchema(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
                'item'     => $item['url'],
            ])->all(),
        ];
    }

    public static function json(array $schema): string
    {
        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
