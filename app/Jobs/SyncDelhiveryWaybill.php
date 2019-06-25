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
        $shipping_data           = $this->payload["shipping_data"];
        $waybill_id              = $this->payload["waybill_id"];
        $orderline_ids           = $shipping_data->shippingLines->pluck('order_line_id')->toArray();
        try {
            foreach ($orderline_ids as $line_id) {
                \DB::table('order_lines')
                    ->where('id', $line_id)
                    ->update(['waybill' => $waybill_id]);
                $orderline = OrderLine::find($line_id);
                $index_data = $orderline->flatData();
                $orderlines["orderLines"][$line_id] = $index_data;
            }
            OrderLine::updateMultipleIndex($orderlines);
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
        }
    }
}
