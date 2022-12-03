<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $support1=User::create([
            'name'=>'Support',
            'lastname'=>'2',
            'email'=>'support1@hotmail.com',
            'status'=>1,
            'selected_project_id'=>null,
            'password'=>bcrypt('11111111'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        $role_support1=Role::where('id',3)->first();
        $support1->syncRoles($role_support1);

        $support2=User::create([
            'name'=>'Support',
            'lastname'=>'2',
            'email'=>'support2@hotmail.com',
            'status'=>1,
            'selected_project_id'=>null,
            'password'=>bcrypt('11111111'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        $role_support2=Role::where('id',3)->first();
        $support2->syncRoles($role_support2);
    }
}
