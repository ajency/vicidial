<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('name');
            $table->integer('variant_id');
            $table->json('images');
            $table->string('size');
            $table->string('price_mrp');
            $table->string('price_final');
            $table->string('price_discounted');
            $table->string('discount_per');
            $table->integer('product_id');
            $table->integer('product_color_id');
            $table->string('product_slug');
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('line_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_line_id');
            $table->string('type');
            $table->integer('line_mapping_id');
            $table->string('line_mapping_type');
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
        Schema::dropIfExists('order_lines');
        
        Schema::dropIfExists('line_mappings');
    }
}
