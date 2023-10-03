<?php

namespace App\View\Components\Table;

use App\Models\Task;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Details extends Component
{
    public Task $task;

    /**
     * Create a new component instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.details');
    }
}
