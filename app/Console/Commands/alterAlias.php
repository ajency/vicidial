<?php

namespace App\Console\Commands;

use App\Elastic\ElasticQuery;
use Illuminate\Console\Command;

class alterAlias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:alter_alias {alias} {old_index} {new_index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Points an alias to new index from old index';

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
        $alias    = $this->argument('alias');
        $old_index    = $this->argument('old_index');
        $new_index    = $this->argument('new_index');
        $q        = new ElasticQuery;
        $response = $q->alterAlias($alias, $old_index, $new_index);
        print_r($response);
    }
}
