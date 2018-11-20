<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ProductMove;

class IndexMove implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    protected $moveID;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($move)
    {
        $this->moveID = $move;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ProductMove::indexProductMove($this->moveID);
    }
}
