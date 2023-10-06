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

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public $listeners = ['employee-created', 'employee-updated'];

    public function employeeCreated(): void
    {
        $this->refresh();
    }

    public function employeeUpdated(): void
    {
        $this->refresh();
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
                    ->render(function () {
                        return Blade::render(<<<HTML
                            <x-button primary label="Create new employee"
                                      @click="\$openModal('employeeEditorModal'); \$dispatch('employeeCreateMode')"
                            />
                        HTML);
                    })
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
            ->addColumn('name', function ($entry) {
                return Blade::render(<<<HTML
                    <span class="cursor-pointer"
                     @click="\$openModal('employeeEditorModal');
                             \$dispatch('employeeEditMode', {id: '{{ $entry->id }}'})"
                    >
                           $entry->name
                    </span>
                HTML);
            })
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

            Column::add()
                ->title('Name')
                ->field('name')
                ->searchable()
                ->sortable(),

            Column::make('Job role', 'job_role')
                ->sortable(),

            Column::make('Created', 'created_at_formatted')
                    ->sortable(),

            Column::action('Action')
        ];
    }
}