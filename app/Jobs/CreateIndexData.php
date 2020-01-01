<?php

namespace App\Jobs;

use App\Vicidial;

class CreateIndexData extends Job
{
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
        Vicidial::buildData();
    }
}
