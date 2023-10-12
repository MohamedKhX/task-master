<?php

namespace App\Livewire\Table;

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

final class Inbox extends PowerGridComponent
{
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function datasource(): ?Collection
    {
        return auth()->user()->employee->notifications()->get();
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
            ->addColumn('message', function($entry) {
                return $entry->data['message']['content'];
            })
            ->addColumn('task_name', function ($entry) {
                return $entry->data['message']['task_details']['name'];
            })
            ->addColumn('At', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Message', 'message')
                ->searchable()
                ->sortable(),

            Column::make('Task Name', 'task_name')
                ->sortable(),

            Column::make('At', 'At'),
        ];
    }
}
