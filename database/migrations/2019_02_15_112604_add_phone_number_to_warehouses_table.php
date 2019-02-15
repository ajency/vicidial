<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneNumberToWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });

        Schema::table('warehouses', function (Blueprint $table) {
            $table->string('phone_number',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
        
        Schema::table('locations', function (Blueprint $table) {
            $table->string('phone_number',10)->after('use_in_inventory')->nullable();
        });
    }
}
