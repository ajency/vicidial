<?php

namespace App\Jobs;

use App\Facet;
use App\ListingPage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class RefreshFacetCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cache::forget('db-facets');
        Cache::rememberForever('db-facets', function () {
            return Facet::select(['facet_name', 'facet_value', 'display_name', 'slug', 'sequence', 'display'])->get();
        });

        Cache::forget('list-filters');
        Cache::rememberForever('list-filters', function () {
            $listingPage = new ListingPage([]);
            return $listingPage->generateSinglePageData(['filters_without_count', 'search_string', 'sort_on']);
        });
    }
}
