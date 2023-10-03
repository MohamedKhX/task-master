<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\PowerGridThemes\PowerGridTheme;
use App\View\Components\Table\Assignee;
use App\View\Components\Table\Details;
use App\View\Components\Table\DueDate;
use App\View\Components\Table\Name;
use App\View\Components\Table\Priority;
use App\View\Components\Table\Status;
use App\View\Components\TestX;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Tests\Models\Dish;
use function GuzzleHttp\default_user_agent;

final class TaskTable extends PowerGridComponent
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

    public function template(): ?string
    {
        return PowerGridTheme::class;
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

    public function datasource(): ?Collection
    {

        if(isset($this->filteredData)) {
            return $this->filteredData;
        }

        return Project::first()->tasks;
    }

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput()
                ->showToggleColumns()
                ->includeViewOnBottom('components.table.header'),
            Detail::make()
                ->view('navigation-menu')
                ->options(['name' => 'Luan'])
                ->showCollapseIcon(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('Details', function (Task $task) {
                return Blade::renderComponent(new Details($task));
            })
            ->addColumn('Name', function (Task $task) {
                return Blade::renderComponent(new Name($task));
            })
            ->addColumn('Assignee', function (Task $task) {
                return Blade::renderComponent(new Assignee($task));
            })
            ->addColumn('Status', function (Task $task) {
                return Blade::renderComponent(new Status($task));
            })
            ->addColumn('Priority', function (Task $task) {
                return Blade::renderComponent(new Priority($task));
            })
            ->addColumn('DueTime', function (Task $task) {
                return Blade::renderComponent(new DueDate($task ));
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('SubTasks')
                ->field('Details')
                ->headerAttribute('text-center')

            ,
            Column::add()
                ->title('Name')
                ->searchable()
                ->sortable()
                ->field('Name', 'name')

            ,
            Column::add()
                ->title('Assignee')
                ->field('Assignee', 'assignee')
                ->headerAttribute('text-center'),

            Column::add()
                ->title('Due Date')
                ->field('DueTime', 'start_date')
                ->headerAttribute('text-center')
                ->sortable(),

            Column::add()
                ->title('Status')
                ->field('Status', 'status')
                ->sortable()
                ->headerAttribute('text-center'),


            Column::add()
                ->title('Priority')
                ->field('Priority', 'priority')
                ->headerAttribute('text-center')
                ->sortable(),

        ];
    }
}
