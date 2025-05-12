<?php

namespace Database\Seeders;

use App\Enums\ProjectRole;
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
        
        foreach ($projects as $project) {
            $project->members()->attach($user->id, [
                'role' => ProjectRole::Admin->value,
            ]);
            for($i = 0; $i < rand(7, 10); $i++) {
                $project->members()->attach(User::all()->random()->id, [
                    'role' => collect(ProjectRole::cases())->random()->value,
                ]);
            }
        }

    }
}
