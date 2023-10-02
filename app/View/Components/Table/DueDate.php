<?php

namespace App\View\Components\Table;

use App\Models\Task;
use Illuminate\View\Component;

class DueDate extends Component
{
    public Task $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    public function render()
    {
        return view('components.table.due-date', [
            'task' => $this->task
        ]);
    }
}
