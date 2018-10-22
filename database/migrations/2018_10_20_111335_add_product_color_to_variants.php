<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductColorToVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->integer('color_id')->after('odoo_id')->nullable();
            $table->integer('product_id')->after('odoo_id');
            $table->unique('odoo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->dropColumn(['color_id', 'product_id']);
        });
    }
}
