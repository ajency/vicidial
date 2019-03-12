<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashOnDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_on_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('phone',10);
            $table->string('otp');
            $table->timestamp('otp_expiry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_on_deliveries');
    }
}
