<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Ajency\Connections\ElasticQuery;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemapProductList implements ShouldQueue
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
        $changefreq = config('sitemap.changefreq');
        $sitemap = Sitemap::create();
        $index = config('elastic.indexes.product');
        $q     = new ElasticQuery;
        $q->setIndex($index)
            ->setQuery(
                ["match_all" => [
                    "boost" => 1.0,
                ]]
            )
            ->setSource(["search_result_data.product_slug"])
            ->setSize(10000);

        $response = $q->search();
        $links    = [];
        foreach ($response["hits"]["hits"] as $item) {
            $link = url('/') . "/" . $item["_source"]["search_result_data"]["product_slug"] . "/buy";
            $sitemap->add(Url::create($link)->setChangeFrequency($changefreq));
        }
        $filepath = config('ajfileupload.doc_base_root_path') . '/products_list'.time().'.xml';
        saveSitemapPath($filepath,"product_listing");
        \Storage::disk('s3')->put($filepath, $sitemap->render());
    }
}
