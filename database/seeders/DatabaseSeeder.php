<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('cache:clear');

        $admin = User::factory()->create([
             'email' => 'admin@admin.com',
             'password' => Hash::make('password')
         ]);

        $admin->assignRole('admin', 'teamLeader');

        $adminEmployee = Employee::factory()->create([
            'user_id' => $admin->id,
            'team_id' => 1
        ]);

        $leader = User::factory()->create([
            'email' => 'mohamed@gmail.com',
            'password' => Hash::make('password')
        ]);

        $leader->assignRole('teamLeader');

        $leaderEmployee = Employee::factory()->create([
             'user_id' => $leader->id
         ]);

         $team = Team::factory()->create([
             'name' => 'Web developers',
             'created_by' => $adminEmployee->id,
         ]);

         Project::factory(3)->create([
             'team_id' => $team->id,
         ]);

         for ($i = 1; $i <= 3; $i++)
         {
             Task::factory(5)->create([
                 'project_id' => $i,
                 'created_by' => $leader->id
             ]);
         }

        Tag::factory(10)->create();
        $tags = Tag::inRandomOrder()->limit(10)->get();
        $tasks = Task::inRandomOrder()->limit(20)->get();

        // Create tag assignments
        foreach ($tasks as $task) {
            $randomTags = $tags->random(rand(1, 5));
            $task->tags()->attach($randomTags);
        }

        // Get some random user and task IDs
        $employeesIds = Employee::pluck('id')->all();
        $taskIds = Task::pluck('id')->all();

        // Create assignments
        foreach ($employeesIds as $employeesId) {
            $randomTasks = array_rand($taskIds, rand(1, 5));
            foreach ((array) $randomTasks as $randomTask) {
                Assignment::create([
                    'employee_id' => $employeesId,
                    'task_id' => $taskIds[$randomTask],
                ]);
            }
        }

        $allTasks = Task::all();

        foreach ($allTasks as $task) {
            for ($i = 0; $i <= 3; $i++) {
                Task::create([
                    'name' => fake()->name,
                    'priority' => fake()->randomElement(['Low', 'High', 'Critical']),
                    'status' => fake()->randomElement(['Completed', 'In Progress', 'Pending']),
                    'parent_id' => $task->id,
                    'project_id' => floor(rand(1, 3)),
                    'created_by' => $leader->id
                ]);
            }
        }

        foreach (Employee::all() as $employee) {
            $employee->update([
                'team_id' => 1
            ]);
        }
    }
}
