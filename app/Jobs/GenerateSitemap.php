<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use URL;
class GenerateSitemap implements ShouldQueue
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
        $content = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><sitemap><loc>';
        $content .= URL::to('/')."/products_list.xml";
        $content .= '</loc></sitemap></sitemapindex>';
        \Storage::disk("public")->put('/sitemap/sitemap.xml', $content);
        // copy(storage_path('app/public').'/sitemap/sitemap.xml', public_path()."/sitemap.xml");
        \Storage::disk('s3')->put(config('ajfileupload.doc_base_root_path') . '/sitemap.xml', storage_path('app/public').'/sitemap/sitemap.xml');
    }
}
