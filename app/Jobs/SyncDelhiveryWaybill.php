<?php

namespace App\Jobs;

use Ajency\Connections\ElasticQuery;
use App\OrderLine;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncDelhiveryWaybill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subject, $payload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $subject, array $payload)
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
        $waybill_id              = $this->payload["waybill_id"];
        $shipping_data           = $this->payload["shipping_data"];
        $shipping_lines          = $shipping_data["shippingLines"];

        foreach ($shipping_lines as $line) {
            $orderline_id = $line["order_line_id"];
            \DB::table('order_lines')
                ->where('id', $orderline_id)
                ->update(['waybill' => $waybill_id]);
            $orderline = OrderLine::find($orderline_id);
            $index_data = $orderline->flatData();
            $orderlines["orderLines"][$orderline_id] = $index_data;
        }
        OrderLine::updateMultipleIndex($orderlines);
    }
}
