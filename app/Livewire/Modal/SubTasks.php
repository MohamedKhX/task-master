<?php

namespace App\Livewire\Modal;

use App\Models\Task;
use Livewire\Component;
use WireUi\View\Components\Modal;

class SubTasks extends Component
{
    public ?Task $task = null;

    protected $listeners = ['showSubTasks'];

    public function showSubTasks($taskId): void
    {
        $this->task = Task::find($taskId);
    }

    public function render()
    {
        return view('livewire.modal.sub-tasks', [
            'task' => $this->task
        ]);
    }
}
