<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->timestamp('start')->useCurrent();
            $table->timestamp('expire')->useCurrent();
            $table->integer('priority')->default(0);
            $table->boolean('active')->default(1);
            $table->boolean('global')->default(1);
            $table->boolean('display')->default(1);
            $table->boolean('has_coupons')->default(0);
            $table->integer('total_uses')->nullable();
            $table->longtext('description')->nullable();
            $table->string('odoo_model');
            $table->integer('odoo_id');
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
        Schema::dropIfExists('offers');
    }
}
