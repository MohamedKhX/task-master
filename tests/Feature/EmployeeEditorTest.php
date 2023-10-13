<?php

namespace Tests\Feature;

use App\Livewire\Modal\EmployeeEditor;
use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use App\Notifications\AssignedTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployeeEditorTest extends TestCase
{
    use RefreshDatabase;

    protected Employee $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Employee::factory()->create();
        $this->admin->user->assignRole('admin');
    }

    /** @test */
    public function it_creates_employee_when_you_are_an_admin()
    {
        $team = Team::factory()->create();

        $role1 = Role::create(['name' => 'Role 1']);
        $role2 = Role::create(['name' => 'Role 2']);

        $inputData = [
            'name'     => 'John Doe',
            'email'    => 'johndoe@example.com',
            'job_role' => 'Developer',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'team_id'  => $team->id,
            'user_roles' => [$role1->name, $role2->name],
        ];

        Livewire::actingAs($this->admin->user)
            ->test(EmployeeEditor::class)
            ->dispatch('employeeCreateMode')
            ->set('name', $inputData['name'])
            ->set('email', $inputData['email'])
            ->set('job_role', $inputData['job_role'])
            ->set('password', $inputData['password'])
            ->set('password_confirmation', $inputData['password_confirmation'])
            ->set('team_id', $inputData['team_id'])
            ->set('user_roles', $inputData['user_roles'])
            ->call('saveEmployee');

        $this->assertDatabaseHas('employees', [
            'name'     => $inputData['name'],
            'job_role' => $inputData['job_role'],
            'team_id'  => $inputData['team_id'],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $inputData['email'],
        ]);

        $employee = Employee::where('name', $inputData['name'])->first();
        $user = User::where('email', $inputData['email'])->first();

        $this->assertTrue($user->hasRole($role1));
        $this->assertTrue($user->hasRole($role2));
    }

    public function it_updates_employee_when_you_are_an_admin()
    {
        $team = Team::factory()->create();
        $role = Role::factory()->create();

        $employee = Employee::factory()->create([
            'name' => 'John Doe',
            'job_role' => 'Developer',
        ]);

        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
        ]);

        $user->assignRole($role);

        $employee->user()->associate($user);
        $employee->team()->associate($team);
        $employee->save();

        Livewire::actingAs($this->admin->user)
            ->test(EmployeeEditor::class)
            ->set('employee', $employee)
            ->set('user', $user)
            ->set('editMode', true)
            ->set('name', 'Jane Smith')
            ->set('job_role', 'Designer')
            ->set('email', 'janesmith@example.com')
            ->set('team_id', $team->id)
            ->set('user_roles', [$role->name])
            ->call('saveEmployee');

        $this->assertDatabaseHas('employees', [
            'name' => 'Jane Smith',
            'job_role' => 'Designer',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'janesmith@example.com',
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => User::where('email', 'janesmith@example.com')->first()->id,
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_type' => Employee::class,
            'model_id' => Employee::where('name', 'Jane Smith')->first()->id,
        ]);
    }
}
