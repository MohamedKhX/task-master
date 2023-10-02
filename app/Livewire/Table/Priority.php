<?php

namespace App\Livewire\Table;

use App\Models\Task;
use Livewire\Component;

class Priority extends Component
{
    public string $priority;
    public Task $task;

    public function updatedPriority()
    {
        if(isset($this->priority))
            $this->task->priority = $this->priority;
        else
            $this->task->priority = null;

        $this->task->save();
    }

    public function render()
    {
        return view('livewire.table.priority');
    }
}
