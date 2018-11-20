<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\IndexMove;

class CreateMoveJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $moveIds;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($moves)
    {
        $this->moveIds = $moves;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->moveIds as $moveID) {
            IndexMove::dispatch($moveID)->onQueue('process_move');
        }
    }
}
