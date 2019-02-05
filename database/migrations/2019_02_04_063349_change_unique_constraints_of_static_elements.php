<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUniqueConstraintsOfStaticElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_elements', function (Blueprint $table) {
            $table->dropUnique('static_elements_sequence_type_published_unique');
            $table->dropUnique('static_elements_sequence_type_draft_unique');
            $table->unique(array('sequence', 'type','published','page_slug'));
            $table->unique(array('sequence','type','draft','page_slug'));
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
            $table->unique('static_elements_sequence_type_published_unique');
            $table->unique('static_elements_sequence_type_draft_unique');
            $table->dropUnique(array('sequence', 'type','published','page_slug'));
            $table->dropUnique(array('sequence','type','draft','page_slug'));
        });
    }
}
