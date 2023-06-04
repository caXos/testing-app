<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Jorge Gomez',
            'email' => 'jorge@nwta.com',
            'password' => bcrypt('nwta')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Mark Lloyd',
            'email' => 'mark.lloyd@nwta.com',
            'password' => bcrypt('nwta'),
            'role' => 2
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Emily Young',
            'email' => 'emily.young@nwta.com',
            'password' => bcrypt('nwta')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jorge Intern',
            'email' => 'jorgeintern@nwta.com',
            'password' => bcrypt('nwta'),
            'role' => 5
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Jorge Visitor',
            'email' => 'jorgevisitor@nwta.com',
            'password' => bcrypt('nwta'),
            'role' => 6
        ]);

        $this->call([
            TaskSeeder::class
        ]);
    }
}
