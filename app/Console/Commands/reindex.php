<?php

namespace App\Console\Commands;

use App\Elastic\ElasticQuery;
use Illuminate\Console\Command;

class reindex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:reindex {src_index} {dest_index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to copy data from one index to another';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dest_index = $this->argument('dest_index');
        $src_index  = $this->argument('src_index');
        $q          = new ElasticQuery();
        $response   = $q->reindex($src_index, $dest_index);
        print_r($response);
    }
}
