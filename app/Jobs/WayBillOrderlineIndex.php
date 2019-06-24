<?php

namespace App\Jobs;

use Ajency\ServiceComm\Comm\Sync;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WayBillOrderlineIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderlines)
    {
        $this->id = $orderlines;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->ids->each(function ($id) {
                $indexData = [];
                $wayBill = Sync::call('backoffice', 'fetchWaybillNumber', ["orderline_id" => $id] );
                DB::table('order_lines')
                    ->where('id', $id)
                    ->update(['wayBill' => $wayBill]);
                $orderline = OrderLine::find($id);
                $indexData = $orderline->flatData();
                $q = new ElasticQuery;
                $q->setIndex(config('elastic.indexes.weborder'));
                $q->createIndexParams($orderline->id, $indexData);
                $result = $q->index();

                if (!isset($result['result']) || !($result['result'] == 'created' || $result['result'] == 'updated')) {
                    throw new Exception(json_encode($result));
                }
            });
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
        }
    }
}