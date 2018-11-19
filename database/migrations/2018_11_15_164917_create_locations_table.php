<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('odoo_id');
            $table->string('name');
            $table->integer('warehouse_odoo_id')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->integer('location_odoo_id')->nullable();
            $table->string('location_name')->nullable();
            $table->string('display_name')->nullable();
            $table->integer('company_odoo_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('type')->nullable();
            $table->json('address')->nullable();
            $table->string('store_code')->nullable();
            $table->boolean('use_in_inventory')->default(0);
            $table->timestamps();
            $table->unique('odoo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
