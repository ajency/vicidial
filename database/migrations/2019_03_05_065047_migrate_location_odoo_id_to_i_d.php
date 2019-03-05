<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateLocationOdooIdToId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE `sub_orders` JOIN locations ON `sub_orders`.location_id = `locations`.odoo_id set `sub_orders`.location_id = `locations`.id;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("UPDATE `sub_orders` JOIN locations ON `sub_orders`.location_id = `locations`.id set `sub_orders`.location_id = `locations`.odoo_id;");
    }
}
