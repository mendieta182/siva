<?php

namespace Database\Seeders;

use App\Models\ProjectUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectUser::create([
            'project_id'=> 1,
            'user_id'=> 51,
            'level_id'=> 1,
        ]);

        ProjectUser::create([
            'project_id'=> 1,
            'user_id'=> 52,
            'level_id'=> 2,
        ]);
    }
}
