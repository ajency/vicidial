<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->boolean('verified')->default(0);
            $table->integer('cart_id')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('verified');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('verified');
        });

        foreach (DB::table('users')->get() as $user) {
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->update(['cart_id' => $user->cart_id, 'verified' => ($user->verified == null) ? 0 : $user->verified]);
            DB::statement("update orders join carts on orders.cart_id = carts.id set orders.verified = ".(($user->verified == null) ? 0 : $user->verified)." where carts.user_id = ".$user->id);
            DB::table('addresses')->where('user_id', $user->id)->update(['verified' => ($user->verified == null) ? 0 : $user->verified]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('verified');
            $table->dropColumn('cart_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('verified');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
    }
}
