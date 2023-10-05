<?php

namespace App\Livewire\Table;

use App\Models\Task;
use Livewire\Attributes\Url;

final class SubTasks extends TaskTable
{
    public ?Task $task;

    public $listeners = ['showSubTasks', 'task-created', 'task-updated'];

    public function showSubTasks($taskId): void
    {
        $this->task = Task::find($taskId);
    }
}
