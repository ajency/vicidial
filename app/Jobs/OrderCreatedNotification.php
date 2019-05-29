<?php

namespace App\Jobs;

use Ajency\ServiceComm\Comm\Async;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class OrderCreatedNotification implements ShouldQueue
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
        $order = Order::find($this->id);
        Log::debug($order);
        $orderlines = collect();
        $order->orderLines->each(function ($orderline) use ($orderlines) {
            $orderlines->push($orderline->flatData());
            Log::debug($orderline);
        });
        Log::debug($orderlines->toJson());
        Log::info(Async::call('OrderCreated', $orderlines->toArray(), 'sns', false));
    }
}
