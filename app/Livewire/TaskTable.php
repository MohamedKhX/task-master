<?php

namespace App\Livewire;

use App\Livewire\Traits\TableFilters;
use App\Models\Project;
use App\Models\Task;
use App\PowerGridThemes\PowerGridTheme;
use App\View\Components\Table\Assignee;
use App\View\Components\Table\Details;
use App\View\Components\Table\DueDate;
use App\View\Components\Table\Name;
use App\View\Components\Table\Priority;
use App\View\Components\Table\Status;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class TaskTable extends PowerGridComponent
{
    use TableFilters;

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public $listeners = ['task-created', 'task-updated'];

    public function taskCreated(): void
    {
        $this->refresh();
    }

    public function taskUpdated(): void
    {
        $this->refresh();
    }

    public function template(): ?string
    {
        return PowerGridTheme::class;
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
