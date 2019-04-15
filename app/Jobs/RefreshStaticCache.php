<?php

namespace App\Jobs;

use App\StaticElement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class RefreshStaticCache implements ShouldQueue
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
        Cache::forget('static_element_' . $slug . '_published');
        $fetchedData = Cache::rememberForever('static_element_' . $slug . '_published', function () use ($slug) {
            return StaticElement::fetch($slug, [], true);
        });
    }
}
