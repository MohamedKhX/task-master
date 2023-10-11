<?php

namespace App\View\Components\Table;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Name extends Component
{
    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function render(): View|Closure|string
    {
        return view('components.table.name', [
            'task' => $this->task,
            'tags' => $this->task->tags()->limit(5)->get(),
            'name' => Str::limit($this->task->name, 40, '...')
        ]);
    }
}
