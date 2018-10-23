<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facet_name');
            $table->string('facet_value');
            $table->string('display_name');
            $table->string('slug');
            $table->integer('sequence');
            $table->unique(['facet_name','facet_value']);
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
        Schema::dropIfExists('facets');
    }
}
