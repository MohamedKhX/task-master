<?php

namespace App\Livewire\Modal;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use WireUi\Traits\Actions;

class TaskEditor extends Component
{
    use Actions;

    public Project $project;

    //Only on Edit Mode
    public bool $editMode = false;
    public ?Task $task = null;

    public ?string $task_name = null;
    public ?string $task_status = null;
    public ?string $task_priority = null;
    public ?string $task_description = null;
    public ?string $task_start_date = null;
    public ?string $task_end_date = null;

    public ?string $task_parent_id = null;

    protected $listeners = ['taskEditMode', 'taskCreateMode'];

    public function taskEditMode($id): void
    {
        $this->task = Task::find($id);
        $this->editMode = true;

        $this->task_name        = $this->task->name;
        $this->task_status      = $this->task->status;
        $this->task_priority    = $this->task->priority;
        $this->task_description = $this->task->description;
        $this->task_start_date  = $this->task->start_date;
        $this->task_end_date    = $this->task->end_date;
    }

    public function taskCreateMode($parent_id = null): void
    {
        $this->task = null;
        $this->editMode = false;

        $this->task_name        = null;
        $this->task_status      = null;
        $this->task_priority    = null;
        $this->task_description = null;
        $this->task_start_date  = null;
        $this->task_end_date    = null;

        $this->task_parent_id   = $parent_id;
    }

    public function rules(): array
    {
        return [
            'task_name'         => ['required', 'max:255'],
            'task_status'       => ['nullable',  new Enum(TaskStatus::class)],
            'task_priority'     => ['nullable',  new Enum(TaskPriority::class)],
            'task_start_date'   => ['nullable', 'date'],
            'task_end_date'     => ['nullable', 'date']
        ];
    }

    public function saveTask(): bool
    {
        $this->validate();

        if($this->editMode) {
           return $this->updateTask();
        }

        return $this->createTask();
    }

    public function createTask(): bool
    {
        $task = Task::create([
            'name'        => $this->task_name,
            'status'      => $this->task_status,
            'priority'    => $this->task_priority,
            'start_date'  => $this->task_start_date,
            'end_date'    => $this->task_end_date,
            'description' => $this->task_description,

            'project_id' => $this->project->id,
            'created_by' => auth()->user()->id,
            'parent_id'  => $this->task_parent_id
        ]);

        $this->notification()->success(
             'Task Created',
             'Task was successfully created'
        );

        $this->dispatch('task-created', $task);

        return true;
    }

    public function updateTask(): bool
    {
        $this->task->update([
            'name'       => $this->task_name,
            'status'     => $this->task_status,
            'priority'   => $this->task_priority,
            'start_date' => $this->task_start_date,
            'end_date'   => $this->task_end_date,
            'description' => $this->task_description,
        ]);

        $this->notification()->success(
            'Task Updated',
            'Task was successfully updated'
        );

        $this->dispatch('task-updated', $this->task);

        return true;
    }

    public function render(): View|Closure|string
    {
        return view('livewire.modal.task-editor', [
            'priorities' => TaskPriority::getValues(),
            'status'     => TaskStatus::getValues()
        ]);
    }
}
