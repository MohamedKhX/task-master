<?php

namespace App\Livewire\Table;

use App\Models\Employee;
use App\PowerGridThemes\PowerGridTheme;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Tests\Models\Dish;
use WireUi\Traits\Actions;

final class Employees extends PowerGridComponent
{
    use Actions;

    public function confirmDelete(): void
    {
        // use a simple syntax

        $this->dialog()->confirm([

            'title'       => 'Are you Sure?',

            'description' => 'To delete the Employee?',

            'icon'        => 'x',

            'accept'      => [

                'label'  => 'Delete It!',

                'method' => 'save',

                'params' => 'Saved',

            ],

            'reject' => [
                'label'  => 'Nope, i want my employee',
            ],

        ]);
    }

    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function datasource(): ?Collection
    {
        return Employee::all();
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

    public function header(): array
    {
        return [
            Button::add('new-modal')
                ->slot('Create New Employee')
                ->class('outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     ring-primary-500 text-white bg-primary-500 hover:bg-primary-600 hover:ring-primary-600 dark:ring-offset-slate-800 dark:bg-primary-700 dark:ring-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600')
            ,
        ];
    }

    public function actions(Employee $row): array
    {
        return [
            Button::add('delete')
                ->render(function (Employee $employee) {
                    return Blade::render(<<<HTML
                          <a x-on:confirm="{
                                title: 'Sure Delete The Employee?',
                                icon: 'warning',
                                method: 'delete',
                                iconBackground: 'white',
                                params: 1}"
                                class="text-danger cursor-pointer">
                                Delete
                          </a>
                    HTML);
                })
        ];
}

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('profile_photo', function ($entry) {
                return <<<HTML
                    <div>
                        <img class="w-12 h-12 rounded-full" src="$entry->profile_photo_path" alt="">
                    </div>
                  HTML;
            })
            ->addColumn('name')
            ->addColumn('job_role')
            ->addColumn('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('Photo')
                ->field('profile_photo'),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable()
                ->editOnClick(),

            Column::make('Job role', 'job_role')
                ->sortable()
                ->editOnClick(),

            Column::make('Created', 'created_at_formatted')
                    ->sortable(),

            Column::action('Action')
        ];
    }
}
