<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->json('element_data');
            $table->json('element_data_draft');
            $table->string('type');
            $table->integer('sequence');
            $table->integer('sequence_data_draft');
            $table->boolean('published')->default(1);
            $table->boolean('display')->default(1);
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
        Schema::dropIfExists('static_elements');
    }
}
