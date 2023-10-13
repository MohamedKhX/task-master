<?php

namespace Tests\Feature\Livewire\Modal;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Livewire\Modal\TaskEditor;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use App\Notifications\AssignedTask;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class TaskEditorTest extends TestCase
{
    use DatabaseTruncation;

    /** @test */
    public function it_can_create_a_task()
    {
        $emp = Employee::factory()->create();

        $project = Project::factory()->create();

        $employee = Employee::factory()->create();

        Livewire::actingAs($emp->user)
            ->test(TaskEditor::class)
            ->set('project', $project)
            ->dispatch('taskCreateMode')
            ->set('task_name', 'New Task')
            ->set('task_status', TaskStatus::IN_PROGRESS->value)
            ->set('task_priority', TaskPriority::HIGH->value)
            ->set('task_description', 'Task description')
            ->set('task_start_date', '2023-10-01')
            ->set('task_end_date', '2023-10-05')
            ->set('task_tags', json_encode(['tag1', 'tag2']))
            ->set('task_assignments', [$employee->id])
            ->call('saveTask');

        $this->assertDatabaseHas('tasks', [
            'name' => 'New Task',
            'status' => TaskStatus::IN_PROGRESS->value,
            'priority' => TaskPriority::HIGH,
            'description' => 'Task description',
            'start_date' => '2023-10-01',
            'end_date' => '2023-10-05',
            'project_id' => $project->id,
        ]);

        $this->assertDatabaseHas('tags', ['name' => 'tag1']);
        $this->assertDatabaseHas('tags', ['name' => 'tag2']);

        $this->assertDatabaseHas('assignments', [
            'task_id' => Task::where('name', 'New Task')->first()->id,
            'employee_id' => $employee->id,
        ]);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $emp = Employee::factory()->create();
        $this->actingAs($emp->user);

        $task = Task::factory()->create([
            'created_by' => $emp->id
        ]);

        $employee = Employee::factory()->create();
        Livewire::actingAs($emp->user)
            ->test(TaskEditor::class)
            ->dispatch('taskEditMode', $task->id)
            ->set('task_name', 'Updated Task')
            ->set('task_status', TaskStatus::COMPLETED->value)
            ->set('task_priority', TaskPriority::LOW->value)
            ->set('task_description', 'Updated task description')
            ->set('task_start_date', '2023-10-01')
            ->set('task_end_date', '2023-10-05')
            ->set('task_tags', json_encode(['tag1', 'tag2']))
            ->set('task_assignments', [$employee->id])
            ->call('saveTask');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task',
            'status' => TaskStatus::COMPLETED->value,
            'priority' => TaskPriority::LOW->value,
            'description' => 'Updated task description',
            'start_date' => '2023-10-01',
            'end_date' => '2023-10-05',
        ]);

        $this->assertDatabaseHas('tags', ['name' => 'tag1']);
        $this->assertDatabaseHas('tags', ['name' => 'tag2']);

        $this->assertDatabaseHas('assignments', [
            'task_id' => $task->id,
            'employee_id' => $employee->id,
        ]);
    }
}
