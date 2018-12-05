<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facet;

class updateAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odoo:attribute {attribute}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add attribute to facets table';

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
        $attribute  = strtoupper($this->argument('attribute'));
        Facet::updateAttribute($attribute);
    }
}
