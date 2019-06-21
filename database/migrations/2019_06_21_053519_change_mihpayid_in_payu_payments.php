<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMihpayidInPayuPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payu_payments', function (Blueprint $table) {
             $table->string('mihpayid')->nullable(true)->change();
             $table->unique(['txnid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payu_payments', function (Blueprint $table) {
            $table->string('mihpayid')->nullable(false)->change();
            $table->dropUnique(['txnid']);
        });
    }
}
