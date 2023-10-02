<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\PowerGridThemes\PowerGridTheme;
use App\View\Components\Table\Assignee;
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
use PowerComponents\LivewirePowerGrid\Components\Filters\Builders\DateTimePicker;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Tests\Models\Dish;

final class TaskTable extends PowerGridComponent
{
    public string $pro;

    public function sub()
    {
        dd($this->priority);
    }

    public function updated()
    {

    }

    public function priorityUpdated()
    {
        dump('Hi there');
    }

    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function datasource(): ?Collection
    {
        $project = Project::all()->first();
        return  $project->tasks;
    }

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Detail::make()
                ->view('components.banner')
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
                ->title('Name')
                ->searchable()
                ->sortable()
                ->field('Name', 'name')
            ,
            Column::add()
                ->title('Assignee')
                ->field('Assignee', 'assignee'),

            Column::add()
                ->title('Status')
                ->field('Status', 'status'),

            Column::add()
                ->title('Due Date')
                ->field('DueTime', 'assignee'),

            Column::add()
                ->title('Priority')
                ->field('Priority', 'priority')
                ->sortable(),

        ];
    }
}
