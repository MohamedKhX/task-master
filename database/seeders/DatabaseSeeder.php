<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole  = Role::create(['name' => 'admin']);
        $teamLeader = Role::create(['name' => 'teamLeader']);

        $adminPermissions = [
            Permission::create(['name' => 'create employees']),
            Permission::create(['name' => 'update employees']),
            Permission::create(['name' => 'delete employees']),

            Permission::create(['name' => 'create teams']),
            Permission::create(['name' => 'update teams']),
            Permission::create(['name' => 'delete teams']),
        ];

        $teamPermissions = [
            Permission::create(['name' => 'create projects']),
            Permission::create(['name' => 'update projects']),
            Permission::create(['name' => 'delete projects']),
            Permission::create(['name' => 'create task']),
            Permission::create(['name' => 'update task']),
            Permission::create(['name' => 'delete task']),
        ];

        $adminRole->syncPermissions($adminPermissions);
        $teamLeader->syncPermissions($teamPermissions);

        $admin = User::factory()->create([
             'email' => 'admin@admin.com',
             'password' => Hash::make('password')
         ]);

        $admin->assignRole('admin');

        $adminEmployee = Employee::factory()->create([
            'user_id' => $admin->id
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
             'created_by' => $adminEmployee->id,
             'team_id' => $team->id,
         ]);

         for ($i = 1; $i <= 3; $i++)
         {
             Task::factory(5)->create([
                 'project_id' => $i
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
    }
}
