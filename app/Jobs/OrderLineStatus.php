<?php

namespace App\Jobs;

use App\OrderLine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderLineStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $lineIds, $status, $delivery_date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lineIds, $status, $delivery_date)
    {
        $this->lineIds       = $lineIds;
        $this->status        = $status;
        $this->delivery_date = $delivery_date;
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
            if ($ol) {
                $ol->shipment_status        = $this->status;
                $ol->shipment_delivery_date = $this->delivery_date;
                $ol->save();
            }
        }
    }
}
