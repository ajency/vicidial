<?php

namespace App\Jobs;

use App\OrderLine;
use App\ReturnPolicy;
use Carbon\Carbon;
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
        $return_expiry_date = null;
        $changes            = [];
        foreach ($this->lineIds as $lineId) {
            $ol = OrderLine::find($lineId);
            if ($ol) {
                if ($this->delivery_date) {
                    $d         = explode("-", explode("T", explode(" ", $this->delivery_date)[0])[0]);
                    $orderDate = Carbon::createFromDate($d[0], $d[1], $d[2], "Asia/Kolkata");
                    $orderDate->startOfDay();
                    if ($ol->return_policy) {
                        $return_policy      = ReturnPolicy::find($ol->return_policy['id']);
                        $return_expiry_date = ($return_policy->expressions->first()->value[0] == 0) ? null : $orderDate->endOfDay()->addDays($return_policy->expressions->first()->value[0] - 1)->toDateTimeString();
                    }
                    $changes = [
                        'orderline_return_expiry_date'     => (new Carbon($return_expiry_date))->timestamp,
                        'orderline_shipment_delivery_date' => (new Carbon($this->delivery_date))->timestamp,
                    ];
                }
                $ol->shipment_status        = $this->status;
                $ol->shipment_delivery_date = $this->delivery_date;
                $ol->return_expiry_date     = $return_expiry_date;
                $ol->save();
                $changes['orderline_shipment_status'] = $this->status;
                $ol->updateIndex($changes);
            }
        }
    }
}
