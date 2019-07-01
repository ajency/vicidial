<?php

namespace App\Jobs;

use Ajency\Connections\ElasticQuery;
use App\OrderLine;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderlineIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $indexData      = [];
        $orderline      = OrderLine::find($this->id);
        $indexData      = $orderline->flatData();

        $q = new ElasticQuery;
        $q->setIndex(config('elastic.indexes.weborder'));
        $q->createIndexParams($orderline->id, $indexData);
        $result = $q->index();

        if (!isset($result['result']) || !($result['result'] == 'created' || $result['result'] == 'updated')) {
            throw new Exception(json_encode($result));
        }
    }
}
