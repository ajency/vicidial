<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveDeletedToVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('variants', function (Blueprint $table) {
            $table->boolean('active')->after('product_color_id')->default(true);
            $table->boolean('deleted')->after('active')->default(false);
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
            $table->dropColumn(['active','deleted']);
         });
    }
}
