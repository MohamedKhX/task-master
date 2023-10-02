<?php

namespace App\View\Components\Table;

use App\Models\Task;
use Illuminate\View\Component;

class Name extends Component
{
    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function render(): string
    {
        return view('components.table.name', [
            'task' => $this->task
        ]);
    }
}
