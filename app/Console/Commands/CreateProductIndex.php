<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Elastic\ElasticQuery;

class CreateProductIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:create:product';

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
        $path = config_path()."/indexes/product.json";
        $params = json_decode(file_get_contents($path), true);
        $q = new ElasticQuery();
        $response = $q->createIndex(config("elastic.prefix")."products", $params);
        if ($response["acknowledged"])
            echo "Index ".$response["index"]." created Successfully";
        else{
            print_r($response);
        }
    }
}
