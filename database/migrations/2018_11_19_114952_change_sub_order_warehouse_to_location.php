<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSubOrderWarehouseToLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_orders', function (Blueprint $table) {
            $table->integer('location_id')->after('warehouse_id');
            $table->dropColumn('warehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_orders', function (Blueprint $table) {
            $table->integer('warehouse_id')->after('location_id');
            $table->dropColumn('location_id');
        });
    }
}
