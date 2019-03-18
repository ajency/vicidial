<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use URL;
use Spatie\Sitemap\SitemapIndex;
use App\Defaults;
use Carbon\Carbon;

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
        $sitemapIndex = SitemapIndex::create();
        $sitemapIndex->add(URL::to('/')."/products_list.xml");
        $filename = 'sitemap'.time();
        $filepath = config('ajfileupload.doc_base_root_path') . '/'.$filename.'.xml';

        saveSitemapPath($filepath);
        \Storage::disk('s3')->put($filepath, $sitemapIndex->render());
    }
}
