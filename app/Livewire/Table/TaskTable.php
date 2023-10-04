<?php

namespace App\Livewire\Table;

use App\Livewire\Table\Traits\TableFilters;
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
use Livewire\Attributes\Url;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

abstract class TaskTable extends PowerGridComponent
{
    use TableFilters;

    public ?Project $project = null;

    public ?Task $task = null;

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

    /*
     * Custom Template.
     * */
    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    /*
     * Data to render in the table.
     * */
    public function datasource(): ?Collection
    {
        $this->filterData();

        return $this->filteredData;
    }

    /*
     * Create the main elements for the table
     * */
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

    /*
     * Custom Columns components.
     * */
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

    /*
     * The Real columns that will be rendered in the table
     * */
    public function columns(): array
    {
        $columns = [
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

        if($this->project) {
            array_unshift($columns,
                Column::add()
                    ->title('SubTasks')
                    ->field('Details')
                    ->headerAttribute('text-center'));
        }

        return $columns;
    }
}
