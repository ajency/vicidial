<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        echo "in 223";
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';

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
            $content .='<url><loc>'.$link.'</loc><xhtml:link rel="alternate" media="only screen and (max-width: 640px)" href="'.$link.'" /><changefreq>monthly</changefreq><priority>0.5</priority></url>';
        }
        $content .='</urlset>';
        \Storage::disk("public")->put('/sitemap/products_list.xml', $content);
        // dd(storage_path('app/public').'/sitemap/products_list.xml'."======".public_path()."/products_list.xml");
        copy(storage_path('app/public').'/sitemap/products_list.xml', public_path()."/products_list.xml");
        // \Storage::disk('public')->move('/sitemap/products_list.xml', public_path()."/products_list.xml");
    }
}
