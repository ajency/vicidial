<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entity');
            $table->unsignedInteger('entity_id');
            $table->string('entity_origin');
            $table->string('attribute');
            $table->string('value');
            $table->boolean('active');
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
        Schema::dropIfExists('entity_data');
    }
}
