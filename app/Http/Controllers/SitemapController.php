<?php

namespace App\Http\Controllers;

use App\Models\CareerJob;
use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/about'), 'priority' => '0.8'],
            ['loc' => url('/leadership'), 'priority' => '0.7'],
            ['loc' => url('/services'), 'priority' => '0.8'],
            ['loc' => url('/manufacturing'), 'priority' => '0.8'],
            ['loc' => url('/products'), 'priority' => '0.9'],
            ['loc' => url('/global-presence'), 'priority' => '0.7'],
            ['loc' => url('/csr'), 'priority' => '0.6'],
            ['loc' => url('/partners'), 'priority' => '0.7'],
            ['loc' => url('/careers'), 'priority' => '0.7'],
            ['loc' => url('/contact'), 'priority' => '0.8'],
            ['loc' => url('/privacy-policy'), 'priority' => '0.3'],
            ['loc' => url('/terms-and-conditions'), 'priority' => '0.3'],
        ]);

        Product::query()->active()->select(['slug', 'updated_at'])->each(function (Product $product) use ($urls) {
            $urls->push([
                'loc' => route('products.show', $product->slug),
                'lastmod' => $product->updated_at?->toAtomString(),
                'priority' => '0.6',
            ]);
        });

        CareerJob::query()->active()->select(['slug', 'updated_at'])->each(function (CareerJob $job) use ($urls) {
            $urls->push([
                'loc' => route('careers.show', $job->slug),
                'lastmod' => $job->updated_at?->toAtomString(),
                'priority' => '0.5',
            ]);
        });

        News::query()->active()->published()->select(['slug', 'updated_at'])->each(function (News $news) use ($urls) {
            $urls->push([
                'loc' => url('/news/'.$news->slug),
                'lastmod' => $news->updated_at?->toAtomString(),
                'priority' => '0.5',
            ]);
        });

        $content = view('sitemap.index', ['urls' => $urls])->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
