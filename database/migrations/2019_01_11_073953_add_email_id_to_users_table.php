<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_id')->after('email')->nullable();
        });

        DB::table('users')->update(['email_id' => DB::raw("email")]);
        DB::table('users')->update(['email' => DB::raw("phone")]);
        foreach (DB::table('users')->get() as $user) {
            DB::table('users')->where('id', '=', $user->id)->update(['password' => bcrypt(defaultUserPassword($user->phone))]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });

        DB::table('users')->update(['email' => DB::raw("email_id")]);
        DB::table('users')->update(['password' => NULL]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_id');
        });
    }
}
