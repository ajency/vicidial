<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ajency\Connections\OdooConnect;
use App\Jobs\IndexProduct;

class IndexDropshipping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odoo:dropshipping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all dropshipping products';

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
        $odoo = new OdooConnect;
        $productIds = $odoo->defaultExec('product.template','search',[[['route_ids','ilike','drop']]], ['limit'=>10000]);
        foreach ($productIds as $productID) {
            IndexProduct::dispatch($productID)->onQueue('process_product');
        }
    }
}
