<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePromotionsAddCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('coupon')->after('promotion_id')->nullable();
            $table->dropColumn('promotion_id');
        });
        Schema::dropIfExists('promotions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('cart');
            $table->integer('odoo_id');
            $table->string('title');
            $table->integer('value');
            $table->string('discount_type');
            $table->integer('step_quantity');
            $table->timestamp('start')->useCurrent();
            $table->timestamp('expire')->useCurrent();
            $table->longtext('description')->nullable();
            $table->string('priority');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('promotion_id')->after('coupon')->nullable();
            $table->dropColumn('coupon');
        });
    }
}
