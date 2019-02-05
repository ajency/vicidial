<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageSlugColumnStaticElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_elements', function (Blueprint $table) {
             $table->string('page_slug')->after('draft')->default("home")->nullable();
            });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_elements', function (Blueprint $table) {
            $table->dropColumn('page_slug');
        });
    }
}
