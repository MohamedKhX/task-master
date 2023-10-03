<?php

namespace App\Livewire;

use Livewire\Component;

class TaskTableFilters extends Component
{
    public string $tasksFilter;
    public string $statusFilter;
    public array $tagsFilter;

    public function updatedTasksFilter()
    {

    }

    public function render()
    {
        return view('livewire.task-table-filters');
    }
}
