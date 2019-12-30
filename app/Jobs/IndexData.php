<?php

namespace App\Jobs;

use App\Vicidial;

class IndexData extends Job
{
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Count: '.count($this->data));
        \Log::info('Data: '.json_encode($this->data->first));
    }
}
