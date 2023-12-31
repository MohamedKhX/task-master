<?php

namespace App\Livewire\Table;

use App\Models\Employee;
use App\PowerGridThemes\PowerGridTheme;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
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

    public function deleteEmployee(Employee $employee): void
    {
        $this->authorize('delete', $employee);

        $employee->delete();

        $this->refresh();

        $this->notification()->error(
            'Employee has been deleted'
        );
    }

    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function datasource()
    {
        return Employee::with('team', 'user.roles')->get();
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
                          <a x-on:click="\$wireui.confirmAction({
                             title: 'You want to delete the employee?',
                             description: '$employee->name',
                             icon: 'warning',
                             method: 'deleteEmployee',
                             iconBackground: 'white',
                             params: $employee->id}, \$root.getAttribute('wire:id'))"
                             class="text-danger cursor-pointer"
                             >
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
                $imgPath = asset($entry->avatar_path);
                $route = route('employee.show', $entry);
                return <<<HTML
                    <div>
                        <a wire:navigate href="$route">
                            <img class="w-12 h-12 rounded-full" src="$imgPath" alt="">
                        </a>
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
            ->addColumn('team', function ($entry) {
                return $entry->team?->name;
            })
            ->addColumn('job_role')
            ->addColumn('roles', function ($entry) {
                $roles = $entry->user->roles;
                return Blade::render(<<<HTML
                     <div class="flex gap-2">
                        @foreach(\$roles as \$role)
                           <span class="text-danger uppercase">{{ \$role->name }}</span>
                        @endforeach
                     </div>
                HTML, [
                    'roles' => $roles
                ]);
            })
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

            Column::add()
                ->title('Roles')
                ->field('roles')
                ->sortable(),


            Column::add()
                ->title('Team')
                ->field('team')
                ->sortable(),

            Column::make('Created', 'created_at_formatted')
                    ->sortable(),

            Column::action('Action')
        ];
    }
}
