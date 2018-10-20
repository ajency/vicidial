<?php

namespace App\Console\Commands;

use App\Elastic\ElasticQuery;
use Illuminate\Console\Command;

class CreateProductIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:create_index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $path     = config_path() . "/indexes/{$index}.json";
        $params   = json_decode(file_get_contents($path), true);
        $q        = new ElasticQuery();
        $response = $q->createIndex(config("elastic.prefix") . $index, $params);
        if ($response["acknowledged"]) {
            $this->info("Index: " . $response["index"] . " created Successfully");
        } else {
            print_r($response);
        }
    }
}
