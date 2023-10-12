<?php

namespace App\Livewire\Table;

use App\Models\Team;
use App\PowerGridThemes\PowerGridTheme;
use App\View\Components\Table\Members;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use WireUi\Traits\Actions;

final class Teams extends PowerGridComponent
{
    use Actions;

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public $listeners = ['team-created', 'team-updated'];

    public function deleteTeam(Team $team): void
    {
        $this->authorize('delete', $team);

        $team->delete();

        $this->refresh();

        $this->notification()->error(
            'Team has been deleted'
        );
    }

    public function teamCreated(): void
    {
        $this->refresh();
    }

    public function teamUpdated(): void
    {
        $this->refresh();
    }

    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function header(): array
    {
        return [
            Button::add('new-modal')
                ->render(function () {
                    return Blade::render(<<<HTML
                            <x-button primary label="Create new team"
                                      @click="\$openModal('teamEditorModal'); \$dispatch('teamCreateMode')"
                            />
                        HTML);
                })
            ,
        ];
    }

    public function actions(Team $row): array
    {
        return [
            Button::add('delete')
                ->render(function (Team $team) {
                    return Blade::render(<<<HTML
                          <a x-on:click="\$wireui.confirmAction({
                             title: 'You want to delete the team?',
                             description: '$team->name',
                             icon: 'warning',
                             method: 'deleteTeam',
                             iconBackground: 'white',
                             params: $team->id}, \$root.getAttribute('wire:id'))"
                             class="text-danger cursor-pointer"
                             >
                                Delete
                          </a>
                    HTML);
                })
        ];
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

    public function datasource(): Collection
    {
        return Team::all();
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('name', function ($model) {
                return <<<HTML
                    <span class="cursor-pointer"
                     @click="\$openModal('teamEditorModal');
                             \$dispatch('teamEditMode', {id: '$model->id'})"
                    >
                           $model->name
                    </span>
                HTML;
            })
            ->addColumn('department')
            ->addColumn('Members', function ($model) {
                return Blade::renderComponent(new Members($model->members));
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Department', 'department')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Members')
                ->field('Members', 'Members')
                ->headerAttribute('text-center'),

            Column::action('Actions')
        ];
    }
}
