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
        $update_params  = ["use_in_inventory" => $this->payload['enable']];
        \DB::table('locations')
            ->where("id", "=", $this->payload['location_id'])
            ->update($update_params);
    }
}
