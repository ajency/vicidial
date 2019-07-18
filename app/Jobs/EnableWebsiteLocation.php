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
    protected $subject, $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($subject, $payload)
    {
        $this->subject = $subject;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $location_id    = $this->payload['location_id' ];
        $enable_vendor  = $this->payload['enable'];
        $update_params  = ["use_in_inventory" => $enable_vendor];
        \DB::table('locations')
            ->where("id", "=", $location_id)
            ->update($update_params);

        Async::call("EnableInventoryLocation", ["location_id" => $location_id, "enable" => $enable_vendor], "sns", false);
    }
}
