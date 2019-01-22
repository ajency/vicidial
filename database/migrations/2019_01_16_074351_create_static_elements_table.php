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
            $table->string('type');
            $table->integer('sequence');
            $table->boolean('published')->nullable();
            $table->boolean('draft')->nullable()->default(1);
            $table->unique(array('sequence', 'type','published'));
            $table->unique(array('sequence','type','draft'));
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
