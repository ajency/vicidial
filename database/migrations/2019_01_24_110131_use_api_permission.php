<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UseApiPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = new Permission();
        $permission->name = "api permissions";
        $permission->save();

        $role=new Role();
        $role->name="admin";
        $role->givePermissionTo('api permissions');

        $role->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', "api permissions")->delete();
        Role::where('name',"admin")->delete();
    }
}
