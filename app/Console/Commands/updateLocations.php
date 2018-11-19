<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Location;

class updateLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odoo:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add the new locations created on odoo to the database';

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
        Location::getAllLocationsFromOdoo();
    }
}
