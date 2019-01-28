<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishStaticElementPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission       = new Permission();
        $permission->name = "publish static element";
        $permission->save();

        $role       = new Role();
        $role->name = "superadmin";
        $role->givePermissionTo('publish static element');

        $role->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', "publish static element")->delete();
        Role::where('name', "superadmin")->delete();
    }
}
