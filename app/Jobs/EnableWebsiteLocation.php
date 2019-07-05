<?php

namespace App\Jobs;

use Ajency\ServiceComm\Comm\Async;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EnableWebsiteLocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->enable       = $params["enable"];
        $this->location_id  = $param["location_id"];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $update_params  = ["use_in_inventory" => $this->enable];
        \DB::table('locations')
            ->where("id", "=", $this->location_id)
            ->update($update_params);

        Async::call("EnableInventoryLocation", ["location_id" => $location_id, "enable" => $enable_vendor]);
    }
}
