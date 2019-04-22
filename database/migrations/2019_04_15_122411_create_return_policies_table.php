<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnPoliciesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_policies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('display_name')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('display')->default(1);
        });

        Schema::create('facet_return_policy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facet_id');
            $table->integer('return_policy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('return_policies');

        Schema::dropIfExists('facet_return_policy');
        
    }
}
