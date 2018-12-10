<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('cart');
            $table->integer('odoo_id');
            $table->string('title');
            $table->integer('value');
            $table->string('discount_type');
            $table->string('step_quantity');
            $table->timestamp('start')->useCurrent();
            $table->timestamp('expire')->useCurrent();
            $table->longtext('description')->nullable();
            $table->string('priority');
            $table->timestamps();
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('promotion_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('promotion_id');
        });
    }
}
