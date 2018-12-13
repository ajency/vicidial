<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Promotion;

class getDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odoo:discounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Discounts to Promotions table';

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
        Promotion::getAllDiscountsFromOdoo();
    }
}
