<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Offer;

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
    protected $description = 'Add Discounts to Offer table';

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
        Offer::sync();
    }
}
