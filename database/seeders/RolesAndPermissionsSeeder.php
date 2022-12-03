<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $role1=Role::create(['name'=>'super-admin']);
        $role2=Role::create(['name'=>'admin']);
        $role3=Role::create(['name'=>'support']);
        $role4=Role::create(['name'=>'client']);

        Permission::create(['name'=>'read:dashboard'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'user:create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'user:read'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'user:update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'user:delete'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'role:create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'role:read'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'role:update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'role:delete'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'permission:create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'permission:read'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'permission:update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'permission:delete'])->syncRoles([$role1,$role2]);

    }
}
