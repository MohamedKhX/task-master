<?php

namespace App\Livewire\Table\Traits;

use App\Models\Project;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;

trait TableFilters
{
    public Collection $filteredData;

    public ?string $filterTasks = null;
    public ?string $filterStatus = null;
    public array $filterTags = [];

    public Collection $tags;

    public function mount(): void
    {
        parent::mount();

        $this->tags = Cache::remember('tags', 3600, function () {
            return Tag::all();
        });
    }

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
        if($this->project) {
            $data = $this->project->tasksWithoutSubTasks();
        } else if($this->task) {
            $data = $this->task->subTasks()->with('tags');
        } else if($this->employee) {
            $data = $this->employee->tasksWithOutSubTasks()->with('project', function ($query) {
                $query->select('id', 'name');
            });
        } else {
            throw new Exception('Please Provide date to filter and render');
        }

        $this->filteredData = $data
            ->when($this->filterTasks === 'My Tasks', function ($query){
                $query->whereHas('assignments', function ($subQuery) {
                    $subQuery->where('assignments.employee_id', 1);
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
