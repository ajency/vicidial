<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Elastic\ElasticQuery;

class deleteIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:delete_index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the specified index from Elasticsearch';

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
        $index    = $this->argument('index');
        $q        = new ElasticQuery();
        $response = $q->deleteIndex($index);
        if ($response["acknowledged"]) {
            $this->info("Index: " . $index . " deleted Successfully");
        } else {
            print_r($response);
        }
    }
}
