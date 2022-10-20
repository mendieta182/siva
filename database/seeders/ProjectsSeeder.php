<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'name'=>'Proyecto A',
            'description'=>'SIAGIE'
        ]);

        Project::create([
            'name'=>'Proyecto B',
            'description'=>'ESCALE'
        ]);
    }
}
