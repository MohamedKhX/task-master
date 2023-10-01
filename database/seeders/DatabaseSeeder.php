<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $admin = User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@admin.com',
             'password' => Hash::make('password')
         ]);

         $leader = User::factory()->create([
             'name' => 'MohamedKhX',
             'email' => 'mohamed@gmail.com',
             'password' => Hash::make('password')
         ]);

         $team = Team::factory()->create([
             'name' => 'Web developers',
             'created_by' => $admin->id,
             'leader_id' => $leader->id
         ]);

         Project::factory(3)->create([
             'created_by' => $admin->id,
             'team_id' => $team->id,
             'manager_id' => $leader->id
         ]);

         Status::factory(10)->create();

         for ($i = 1; $i <= 3; $i++)
         {
             Task::factory(5)->create([
                 'project_id' => $i
             ]);
         }


    }
}
