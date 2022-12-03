<?php

namespace Database\Seeders;

use App\Models\Incident;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IncidentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Incident::create([
            'title'=>'Primera Incidencia',
            'description'=>'descripción de la primera incidencia',
            'severity'=>'N',
            'category_id'=>2,
            'project_id'=>1,
            'level_id'=>1,
            'client_id'=>2,
            'support_id'=>51,
        ]);
    }
}
