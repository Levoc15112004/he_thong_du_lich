<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tour;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML Sitemap for Google, Bing, and Search Engines (SEO/GEO)
     */
    public function sitemap(): Response
    {
        $baseUrl = url('/');
        $now = now()->toAtomString();

        $urls = [];

        // 1. Static Core Pages
        $urls[] = [
            'loc' => $baseUrl . '/',
            'lastmod' => $now,
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];
        $urls[] = [
            'loc' => $baseUrl . '/tours',
            'lastmod' => $now,
            'changefreq' => 'daily',
            'priority' => '0.9',
        ];
        $urls[] = [
            'loc' => $baseUrl . '/blog',
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];
        $urls[] = [
            'loc' => $baseUrl . '/contact',
            'lastmod' => $now,
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ];

        // 2. Active Tours (SEO High Priority)
        $tours = Tour::where('status', 1)->select('id', 'name', 'updated_at')->get();
        foreach ($tours as $tour) {
            $urls[] = [
                'loc' => route('user.tourDetail.index', $tour->id),
                'lastmod' => ($tour->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 3. Tour Categories
        $categories = Category::where('status', 1)->select('id', 'name', 'updated_at')->get();
        foreach ($categories as $cat) {
            $urls[] = [
                'loc' => route('user.category', $cat->id),
                'lastmod' => ($cat->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 4. Popular GEO Destinations
        $destinations = Tour::where('status', 1)
            ->whereNotNull('end_location')
            ->distinct()
            ->pluck('end_location');
        foreach ($destinations as $dest) {
            $urls[] = [
                'loc' => route('user.destination', urlencode($dest)),
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.75',
            ];
        }

        // 5. Blogs & Travel News
        $blogs = Blog::where('status', 1)->select('id', 'updated_at')->get();
        foreach ($blogs as $blog) {
            $urls[] = [
                'loc' => route('blog.show', $blog->id),
                'lastmod' => ($blog->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Generate dynamic robots.txt
     */
    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /cart\n";
        $content .= "Disallow: /order\n";
        $content .= "Disallow: /user\n";
        $content .= "Disallow: /payment\n";
        $content .= "Disallow: /paypal/\n";
        $content .= "Disallow: /auth/\n\n";
        $content .= "Sitemap: {$sitemapUrl}\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
