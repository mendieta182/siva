<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'name' => 'Atención por teléfono',
            'project_id' => 1
        ]);

        Level::create([
            'name' => 'Envío de Técnico',
            'project_id' => 1
        ]);

        Level::create([
            'name' => 'Mesa de ayuda',
            'project_id' => 2
        ]);

        Level::create([
            'name' => 'Consulta especializada',
            'project_id' => 2
        ]);
        
    }
}
