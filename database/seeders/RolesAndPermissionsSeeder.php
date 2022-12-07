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

        Permission::create(['name'=>'read_dashboard'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'user_create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'user_read'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'user_update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'user_delete'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'role_create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'role_read'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=>'role_update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'role_delete'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'permission_create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'permission_read'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'permission_update'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'permission_delete'])->syncRoles([$role1,$role2]);

        Permission::create(['name'=>'incident_create'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name'=>'incident_read'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name'=>'incident_update'])->syncRoles([$role4]);
        Permission::create(['name'=>'incident_delete'])->syncRoles([$role4]);
        Permission::create(['name'=>'incident_open'])->syncRoles([$role4]);
        Permission::create(['name'=>'incident_solve'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'incident_derive'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=>'incident_attend'])->syncRoles([$role1,$role2]);

    }
}
