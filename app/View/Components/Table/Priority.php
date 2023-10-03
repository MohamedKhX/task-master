<?php

namespace App\View\Components\Table;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\View\Component;

class Priority extends Component
{
    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function render(): View|Closure|string
    {
        return view('components.table.priority', [
            'task' => $this->task
        ]);
    }
}
