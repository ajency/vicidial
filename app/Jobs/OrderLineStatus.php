<?php

namespace App\Jobs;

use App\OrderLine;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderLineStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $lineIds, $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lineIds, $status)
    {
        $this->lineIds = $lineIds;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->lineIds as $lineId) {
            $ol = OrderLine::find($lineId);
            if($ol) {
                $ol->shipment_status = $this->status;
                $ol->save();
            }
        }
    }
}
