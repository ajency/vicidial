<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOdooIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('odoo_id')->nullable();
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('odoo_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('odoo_id');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('odoo_id');
        });
    }
}
