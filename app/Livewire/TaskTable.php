<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\PowerGridThemes\PowerGridTheme;
use App\View\Components\TestX;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
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
                return "
                        <div class='flex flex-row gap-2'>
                              <span class='text-sm'>$task->name</span>
                            <div class='flex flex-row gap-2'>
                                <span class='flex items-center justify-center opacity-75 bg-primary-500 rounded-full text-white text-xs px-2'>
                                    Tag
                                </span>
                                <span class='flex items-center justify-center  opacity-75 bg-danger rounded-full text-white text-xs px-2'>
                                    Red
                                </span>
                            </div>
                        </div>
                        ";
            })
            ->addColumn('Assignee', function (Task $task) {
                return Blade::renderComponent(new TestX());
            })
            ->addColumn('DueTime', function (Task $task) {
                return Blade::renderComponent(new TestX());
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
                ->title('Due Date')
                ->field('DueTime', 'assignee'),

            Column::make('Priority', 'priority')
                ->sortable(),
        ];
    }
}
