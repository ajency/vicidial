<?php

namespace App\Jobs;

use App\Vicidial;

class DuplicateData extends Job
{
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Vicidial::duplicateBatchData();
    }
}
