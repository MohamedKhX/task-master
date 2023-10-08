<?php

namespace App\Livewire\Table;

use App\Models\Project;
use App\PowerGridThemes\PowerGridTheme;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Projects extends PowerGridComponent
{

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    /*
   * Custom Template.
   * */
    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function datasource(): ?Collection
    {
        return Project::all();
    }

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('name')
            ->addColumn('budget')
            ->addColumn('status')
            ->addColumn('start_date')
            ->addColumn('end_date');
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Budget', 'budget')
                ->searchable()
                ->sortable(),


            Column::make('Status', 'status')
                ->searchable()
                ->sortable(),

            Column::make('Start Date', 'start_date')
                ->searchable()
                ->sortable(),

            Column::make('End Date', 'end_date')
                ->searchable()
                ->sortable(),



            Column::action('Action')
        ];
    }
}
