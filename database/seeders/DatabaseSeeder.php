<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(LevelsSeeder::class);

        $this->call(SupportsSeeder::class);
        $this->call(ProjectsUsersSeeder::class);
        $this->call(IncidentsSeeder::class);

    }
}
