<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->boolean('verified')->default(0);
            $table->integer('cart_id')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('verified');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('verified');
            $table->dropColumn('cart_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('verified');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
    }
}
