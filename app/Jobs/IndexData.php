<?php

namespace App\Jobs;

use App\Vicidial;
use App\Defaults;
use Carbon\Carbon;

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
        $start_time     = Carbon::now();
        Vicidial::index($this->data);
        $defaults_data = Defaults::firstOrNew(['label' => 'sync']);
        $meta_data = $defaults_data->meta_data;
        $meta_data['index_time'][] = Carbon::now()->diffInSeconds($start_time);
        $defaults_data->meta_data = $meta_data;
        $defaults_data->save();
    }
}
