<?php

namespace Tests\Feature\Livewire\Modal;

use App\Livewire\Modal\TeamEditor;
use App\Models\Employee;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeamEditorTest extends TestCase
{
    use RefreshDatabase;

    protected Employee $admin;

    protected function setUp(): void
    {
        parent::setUp();

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


        $this->admin = Employee::factory()->create();
        $this->admin->user->assignRole('admin');
    }

    /** @test */
    public function it_can_create_a_team()
    {
        Livewire::actingAs($this->admin->user)
            ->test(TeamEditor::class)
            ->set('name', 'New Team1234')
            ->set('department', 'Development')
            ->call('saveTeam');

        $this->assertDatabaseHas('teams', [
            'name' => 'New Team1234',
            'department' => 'Development',
            'created_by' => auth()->user()->id,
        ]);
    }

    /** @test */
    public function it_can_update_a_team()
    {
        $this->actingAs($this->admin->user);

        $team = Team::factory()->create([
            'name' => 'Old Team',
            'department' => 'Development',
            'created_by' => auth()->user()->id,
        ]);

        $employee1 = Employee::factory()->create();
        $employee2 = Employee::factory()->create();

        Livewire::actingAs($this->admin->user)
            ->test(TeamEditor::class)
            ->set('editMode', true)
            ->set('team', $team)
            ->set('name', 'Updated Team')
            ->set('department', 'Design')
            ->set('members', [$employee1->id, $employee2->id])
            ->call('saveTeam');

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'name' => 'Updated Team',
            'department' => 'Design',
        ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee1->id,
            'team_id' => $team->id,
        ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee2->id,
            'team_id' => $team->id,
        ]);
    }
}
