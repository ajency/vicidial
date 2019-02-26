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
            $table->string('transaction_mode')->after('type')->nullable();
        });

        DB::table('orders')->update(['type' => 'New Transaction']);

        Schema::table('sub_orders', function (Blueprint $table) {
            $table->string('type')->after('location_id');
            $table->boolean('is_invoiced')->after('type')->default(false);
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
            $table->dropColumn('transaction_mode');
        });

        Schema::table('sub_orders', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('is_invoiced');
        });
    }
}
