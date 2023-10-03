<?php

namespace App\Livewire\Traits;

use App\Models\Project;
use Illuminate\Support\Collection;

trait TableFilters
{
    public Collection $filteredData;

    public ?string $filterTasks = null;
    public ?string $filterStatus = null;
    public array $filterTags = [];

    public function updatedFilterTasks(): void
    {
        $this->filterData();
    }

    public function updatedFilterStatus(): void
    {
        $this->filterData();
    }

    public function updatedFilterTags(): void
    {
        $this->filterData();
    }

    public function filterData(): void
    {
        $this->filteredData = Project::findOrFail(1)
            ->tasks()
            ->when($this->filterTasks === 'My Tasks', function ($query){
                $query->whereHas('assignments', function ($subQuery) {
                    $subQuery->where('assignments.user_id', 1);
                });
            })
            ->when($this->filterStatus, function ($query)  {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterTags, function ($query) {
                $query->whereHas('tags', function ($subQuery) {
                    $subQuery->whereIn('tag_id', $this->filterTags);
                });
            })
            ->get();
    }
}
