<?php

namespace Tests\Feature\Livewire\Modal;

use App\Enums\ProjectStatus;
use App\Livewire\Modal\ProjectEditor;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectEditorTest extends TestCase
{
    use RefreshDatabase;

    protected Employee $leader;
    protected Team $team;

    protected function setUp(): void
    {
        parent::setUp();

        $this->team = Team::factory()->create();
        $user = User::factory()->create();

        $this->leader = Employee::factory()->create([
            'user_id' => $user->id,
            'team_id' => $this->team->id
        ]);

        $this->leader->user->assignRole('teamLeader');
    }

    /** @test */
    public function it_can_create_a_project()
    {
        Livewire::actingAs($this->leader->user)
            ->test(ProjectEditor::class)
            ->set('name', 'New Project')
            ->set('status', ProjectStatus::IN_PROGRESS->value)
            ->set('budget', 1000)
            ->set('start_date', Date::now()->format('Y-m-d'))
            ->set('end_date', Date::now()->addDays(7)->format('Y-m-d'))
            ->call('saveProject');

        $this->assertDatabaseHas('projects', [
            'name' => 'New Project',
            'status' => ProjectStatus::IN_PROGRESS,
            'budget' => 1000,
            'start_date' => Date::now()->format('Y-m-d'),
            'end_date' => Date::now()->addDays(7)->format('Y-m-d'),
            'team_id' => $this->team->id,
           ]);
    }

    /** @test */
    public function it_can_update_a_project()
    {
        $project = Project::factory()->create([
            'name' => 'Old Project',
            'status' => ProjectStatus::IN_PROGRESS->value,
            'budget' => 1000,
            'start_date' => Date::now()->format('Y-m-d'),
            'end_date' => Date::now()->addDays(7)->format('Y-m-d'),
            'team_id' => $this->team->id,
        ]);

        Livewire::actingAs($this->leader->user)
            ->test(ProjectEditor::class)
            ->set('editMode', true)
            ->set('project', $project)
            ->set('name', 'Updated Project')
            ->set('status', ProjectStatus::COMPLETED->value)
            ->set('budget', 2000)
            ->set('start_date', Date::now()->addDays(1)->format('Y-m-d'))
            ->set('end_date', Date::now()->addDays(10)->format('Y-m-d'))
            ->call('saveProject');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project',
            'status' => ProjectStatus::COMPLETED->value,
            'budget' => 2000,
            'start_date' => Date::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Date::now()->addDays(10)->format('Y-m-d'),
        ]);
    }
}
