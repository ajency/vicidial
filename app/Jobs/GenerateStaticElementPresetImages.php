<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateStaticElementPresetImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $static_element_id,$file_id,$filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($static_element_id,$file_id,$filename)
    {
        $this->static_element_id = $static_element_id;
        $this->file_id = $file_id;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
