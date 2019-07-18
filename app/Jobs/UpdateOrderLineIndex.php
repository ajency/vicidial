<?php

namespace App\Jobs;

use Ajency\Connections\ElasticQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ajency\ServiceComm\Comm\Async;

class UpdateOrderLineIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id, $changes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $changes)
    {
        $this->id      = $id;
        $this->changes = $changes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $changes = $this->changes;
        $changes['orderline_id'] = $this->id;
        Async::call('OrderUpdated', [$changes], 'sns',false);
        // $q = new ElasticQuery;
        // $q->setIndex(config('elastic.indexes.weborder'));
        // $q->createUpdateParams($this->id, $this->changes);
        // $result = $q->update();
        // if (!isset($result['result']) || $result['result'] != 'updated') {
        //     throw new Exception(json_encode($result));
        // }
    }
}