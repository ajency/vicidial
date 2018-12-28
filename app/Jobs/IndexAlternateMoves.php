<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\ProductMove;

class IndexAlternateMoves implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $start, $end, $index;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($index, $start, $end)
    {
        $this->index = $index;
        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ProductMove::indexMoves($this->index, $this->start, $this->end);
    }
}
