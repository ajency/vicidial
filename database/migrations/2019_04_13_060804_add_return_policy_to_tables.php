<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnPolicyToTables extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            //creating column to store parent order id

            $table->integer('new_transaction_id')->nullable();
        });

        Schema::table('sub_orders', function (Blueprint $table) {

            //creating column to store parent sub_order id
            $table->integer('new_transaction_id')->nullable();

            
        });

        Schema::table('order_lines', function (Blueprint $table) {

            //creating column to store return policy for an order_line as title from return policies table

            $table->string('return_policy')->nullable();
            $table->integer('product_type')->nullable();
            $table->integer('product_subtype')->nullable();


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('new_transaction_id');
        });

        Schema::table('sub_orders', function (Blueprint $table) {
            //
            $table->dropColumn('new_transaction_id');
        });

        Schema::table('order_lines', function (Blueprint $table) {
            //
            $table->dropColumn('return_policy');
            $table->dropColumn('product_type');
            $table->dropColumn('product_subtype');
        });
    }
}
