<?php

namespace App\Jobs;

use App\SingleProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class RefreshProductCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $slug;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slug = $this->slug;
        $singleProduct = new SingleProduct($slug);
        Cache::forget('single-product-' . $slug);
        $apiResponse = Cache::rememberForever('single-product-' . $slug, function () use ($singleProduct) {
            $apiResponse   = $singleProduct->generateSinglePageData(['attributes', 'facets', 'variants', 'images', 'is_sellable', 'color_variants', 'breadcrumbs', 'related_products', 'meta', 'size_chart', 'blogs']);
            return $apiResponse;
        });
        Cache::forget('list-product-' . $slug);
        $apiResponse = Cache::rememberForever('list-product-' . $slug, function () use ($singleProduct) {
            $apiResponse   = $singleProduct->generateSinglePageData(['attributes', 'facets', 'variants', 'images', 'is_sellable', 'is_available']);
            return $apiResponse;
        });
    }
}
