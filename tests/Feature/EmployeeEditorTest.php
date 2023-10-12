<?php

namespace Tests\Feature;

use App\Livewire\Modal\EmployeeEditor;
use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployeeEditorTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateEmployee()
    {
        $this->withoutMiddleware();

        // Create a test team
        $team = Team::factory()->create();

        // Create test roles
        $role1 = Role::create(['name' => 'Role 1']);
        $role2 = Role::create(['name' => 'Role 2']);

        // Define input data for creating an employee
        $inputData = [
            'name'     => 'John Doe',
            'email'    => 'johndoe@example.com',
            'job_role' => 'Developer',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'team_id'  => $team->id,
            'user_roles' => [$role1->name, $role2->name],
        ];

        // Emit the employeeCreateMode event
        Livewire::test(EmployeeEditor::class)
            ->dispatch('employeeCreateMode')
            ->set('name', $inputData['name'])
            ->set('email', $inputData['email'])
            ->set('job_role', $inputData['job_role'])
            ->set('password', $inputData['password'])
            ->set('password_confirmation', $inputData['password_confirmation'])
            ->set('team_id', $inputData['team_id'])
            ->set('user_roles', $inputData['user_roles'])
            ->call('saveEmployee');

        dd(Employee::all());
        // Assert that the employee was created in the database
        $this->assertDatabaseHas('employees', [
            'name'     => $inputData['name'],
            'job_role' => $inputData['job_role'],
            'team_id'  => $inputData['team_id'],
        ]);

        // Assert that the user was created in the database
        $this->assertDatabaseHas('users', [
            'email' => $inputData['email'],
        ]);

        // Get the created employee and user from the database
        $employee = Employee::where('name', $inputData['name'])->first();
        $user = User::where('email', $inputData['email'])->first();

        // Assert that the user has the correct roles assigned
        $this->assertTrue($user->hasRole($role1));
        $this->assertTrue($user->hasRole($role2));
    }

}
