<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CscCenter;
use App\Models\FormCategory;
use App\Models\GovForm;
use App\Models\GovJob;
use App\Models\GovJobCategory;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Sitemap index — kept tiny and fast so crawlers always get a quick
     * response, with the actual URL lists split into their own files.
     * CSC centers (36,000+ rows) are split out from everything else
     * (a few dozen pages) so that huge, low-uniqueness set doesn't
     * dominate the main content sitemap.
     */
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.index', 3600, function () {
            $sitemaps = [
                ['loc' => route('sitemap.pages'), 'lastmod' => now()->toAtomString()],
                ['loc' => route('sitemap.cscCenters'), 'lastmod' => now()->toAtomString()],
            ];

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            foreach ($sitemaps as $s) {
                $xml .= '  <sitemap>' . "\n";
                $xml .= '    <loc>' . e($s['loc']) . '</loc>' . "\n";
                $xml .= '    <lastmod>' . $s['lastmod'] . '</lastmod>' . "\n";
                $xml .= '  </sitemap>' . "\n";
            }
            $xml .= '</sitemapindex>';

            return $xml;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Main content: static pages, services, gov forms, blog, jobs.
     * Everything here is small in volume (under a few hundred URLs
     * total today), so one file comfortably covers it.
     */
    public function pages(): Response
    {
        $xml = Cache::remember('sitemap.pages', 3600, function () {
            $urls = [];

            // Static pages
            $static = [
                ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
                ['url' => url('/about'), 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['url' => route('services.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['url' => route('jobs.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
                ['url' => route('blog.index'), 'priority' => '0.7', 'changefreq' => 'weekly'],
                ['url' => route('forms.index'), 'priority' => '0.7', 'changefreq' => 'weekly'],
                ['url' => route('contact'), 'priority' => '0.5', 'changefreq' => 'yearly'],
                ['url' => route('csc.directory'), 'priority' => '0.8', 'changefreq' => 'weekly'],
                ['url' => route('agent.registration'), 'priority' => '0.6', 'changefreq' => 'monthly'],
                ['url' => route('application.track'), 'priority' => '0.5', 'changefreq' => 'yearly'],
                ['url' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
                ['url' => route('terms-conditions'), 'priority' => '0.3', 'changefreq' => 'yearly'],
                ['url' => route('refund-cancellation-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
                ['url' => route('disclaimer'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ];
            foreach ($static as $s) {
                $urls[] = $s + ['lastmod' => null];
            }

            // Services
            foreach (Service::active()->get(['slug', 'updated_at']) as $service) {
                $urls[] = [
                    'url' => route('services.show', $service->slug),
                    'lastmod' => $service->updated_at?->toAtomString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                ];
            }

            // Government form categories + forms
            foreach (FormCategory::active()->get(['slug', 'updated_at']) as $cat) {
                $urls[] = [
                    'url' => route('categories.show', $cat->slug),
                    'lastmod' => $cat->updated_at?->toAtomString(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            }
            foreach (GovForm::active()->get(['slug', 'updated_at']) as $form) {
                $urls[] = [
                    'url' => route('forms.show', $form->slug),
                    'lastmod' => $form->updated_at?->toAtomString(),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                ];
            }

            // Blog posts + categories
            foreach (Blog::published()->get(['slug', 'updated_at']) as $post) {
                $urls[] = [
                    'url' => route('blog.show', $post->slug),
                    'lastmod' => $post->updated_at?->toAtomString(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            }
            foreach (BlogCategory::all(['slug', 'updated_at']) as $cat) {
                $urls[] = [
                    'url' => route('blog.category', $cat->slug),
                    'lastmod' => $cat->updated_at?->toAtomString(),
                    'priority' => '0.5',
                    'changefreq' => 'weekly',
                ];
            }

            // Government job listings + categories
            foreach (GovJob::query()->get(['slug', 'updated_at']) as $job) {
                $urls[] = [
                    'url' => route('jobs.show', $job->slug),
                    'lastmod' => $job->updated_at?->toAtomString(),
                    'priority' => '0.8',
                    'changefreq' => 'daily',
                ];
            }
            foreach (GovJobCategory::all(['slug', 'updated_at']) as $cat) {
                $urls[] = [
                    'url' => route('jobs.category', $cat->slug),
                    'lastmod' => $cat->updated_at?->toAtomString(),
                    'priority' => '0.6',
                    'changefreq' => 'weekly',
                ];
            }

            return $this->buildUrlsetXml($urls);
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * CSC center directory listings — split into their own sitemap
     * since there are 36,000+ of them. Cached longer than the main
     * content sitemap since this dataset changes far less often
     * relative to its size.
     */
    public function cscCenters(): Response
    {
        $xml = Cache::remember('sitemap.csc-centers', 21600, function () {
            $urls = [];

            CscCenter::publiclyVisible()
                ->select('id', 'updated_at')
                ->orderBy('id')
                ->chunk(1000, function ($chunk) use (&$urls) {
                    foreach ($chunk as $center) {
                        $urls[] = [
                            'url' => route('csc.show', $center->id),
                            'lastmod' => $center->updated_at?->toAtomString(),
                            'priority' => '0.4',
                            'changefreq' => 'monthly',
                        ];
                    }
                });

            return $this->buildUrlsetXml($urls);
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * @param  array<int, array{url: string, lastmod: ?string, priority: string, changefreq: string}>  $urls
     */
    private function buildUrlsetXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . e($u['url']) . '</loc>' . "\n";
            if (!empty($u['lastmod'])) {
                $xml .= '    <lastmod>' . $u['lastmod'] . '</lastmod>' . "\n";
            }
            $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
