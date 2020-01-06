<?php

namespace App\Jobs;

use App\Vicidial;

class CreateIndexData extends Job
{
    protected $date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Vicidial::buildData($date);
    }
}
