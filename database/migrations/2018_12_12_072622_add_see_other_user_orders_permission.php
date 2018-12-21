<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
class AddSeeOtherUserOrdersPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = new Permission();
        $permission->name = "see other user orders";
        $permission->guard_name = "see_other_user_orders";
        $permission->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('guard_name', "see_other_user_orders")->delete();
    }
}
