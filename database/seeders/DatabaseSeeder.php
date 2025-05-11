<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Ardian Ilyas',
            'email' => 'ardian@oriona.com',
            'password' => bcrypt('developer')
        ]);

        $projects = Project::factory(10)->create([
            'user_id' => $user->id,
        ]);

        User::factory(100)->has(Project::factory(20))->create();
    }
}
