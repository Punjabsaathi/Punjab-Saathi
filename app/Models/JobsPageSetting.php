<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobsPageSetting extends Model
{
    protected $fillable = [
        'meta_title', 'meta_description', 'meta_keywords', 'h1', 'hero_subtitle',
        'intro_content', 'how_to_apply_content', 'eligibility_content',
        'faqs', 'schema_enabled',
    ];

    protected $casts = [
        'faqs'           => 'array',
        'schema_enabled' => 'boolean',
    ];

    // Singleton — always exactly one row (id=1). Backend edits it through
    // the "Jobs Page SEO" Filament page; the front-end reads it here.
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'meta_title' => 'Punjab Government Jobs ' . now()->year . ' — Latest Sarkari Naukri & Recruitment Updates | Punjab Saathi',
            'meta_description' => 'Latest Punjab government job vacancies — PSSSB, Punjab Police, SSC, RRB, Banking & more. Eligibility, dates, apply links, updated daily by Punjab Saathi.',
            'h1' => 'Punjab Government Jobs — Latest Sarkari Naukri & Recruitment Updates',
            'hero_subtitle' => 'PSSSB · Punjab Police · SSC · RRB · Banking · NHM — All Punjab Government Jobs at One Place',
        ]);
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: 'Punjab Government Jobs ' . now()->year . ' — Latest Sarkari Naukri & Recruitment Updates | Punjab Saathi';
    }

    public function toFaqSchema(): ?array
    {
        if (! $this->schema_enabled || empty($this->faqs)) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type'    => 'FAQPage',
            'mainEntity' => collect($this->faqs)
                ->filter(fn ($faq) => !empty($faq['question']) && !empty($faq['answer']))
                ->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name'  => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $faq['answer'],
                    ],
                ])->values()->all(),
        ];
    }
}
