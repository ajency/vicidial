<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('type')->after('address_id');
        });

        DB::table('orders')->update(['type' => 'New Transaction']);

        Schema::table('sub_orders', function (Blueprint $table) {
            $table->string('type')->after('location_id');
        });

        DB::table('sub_orders')->update(['type' => 'New Transaction']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('sub_orders', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
