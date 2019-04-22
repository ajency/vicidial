<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnFieldsToOrderlinesSuborders extends Migration
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
            $table->date('shipment_delivery_date')->nullable();
            $table->json('return_policy')->nullable();
            $table->string('product_type')->nullable();
            $table->string('product_subtype')->nullable();
            $table->boolean('is_returned')->default(false);

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
            $table->dropColumn('shipment_delivery_date');
            $table->dropColumn('return_policy');
            $table->dropColumn('product_type');
            $table->dropColumn('product_subtype');
        });
    }
}
