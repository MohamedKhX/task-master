<?php

namespace App\Livewire\Table;

use App\Models\Project;
use App\Models\Team;
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
use WireUi\Traits\Actions;

final class Projects extends PowerGridComponent
{
    use Actions;

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public $listeners = ['project-created', 'project-updated'];


    public function deleteProject(Project $project): void
    {
        $this->authorize('delete', $project);

        $project->delete();

        $this->refresh();

        $this->notification()->error(
            'Project has been deleted'
        );
    }

    public function projectCreated(): void
    {
        $this->refresh();
    }

    public function projectUpdated(): void
    {
        $this->refresh();
    }

    public function header(): array
    {
        return [
            Button::add('new-modal')
                ->render(function () {

                    if(! auth()->user()->can('create', Project::class)) return null;

                    return Blade::render(<<<HTML
                            <x-button primary label="Create new project"
                                      @click="\$openModal('projectEditorModal'); \$dispatch('projectCreateMode')"
                            />
                        HTML);
                })
            ,
        ];
    }

    public function actions(Project $row): array
    {
        return [
            Button::add('delete')
                ->render(function (Project $project) {


                    $projectRoute = route('project.show', $project);

                    if(auth()->user()->can('delete', $project)) {
                        $deleteButton = <<<HTML
                        <a x-on:click="\$wireui.confirmAction({
                             title: 'You want to delete the team?',
                             description: '$project->name',
                             icon: 'warning',
                             method: 'deleteProject',
                             iconBackground: 'white',
                             params: $project->id}, \$root.getAttribute('wire:id'))"
                             class="text-danger cursor-pointer"
                             >
                                Delete
                          </a>
                        HTML;
                    } else {
                        $deleteButton = '';
                    }

                    return Blade::render(<<<HTML
                    <div class="flex justify-center gap-2">
                          $deleteButton
                          <a wire:navigate href="$projectRoute" class="text-dark cursor-pointer">
                                Show
                          </a>
                    </div>

                    HTML);
                }),
        ];
    }


    /*
   * Custom Template.
   * */
    public function template(): ?string
    {
        return PowerGridTheme::class;
    }

    public function datasource(): ?Collection
    {
        return auth()->user()->employee->team->projects ?? collect([]);
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
            ->addColumn('Name', function ($model) {
                return <<<HTML
                    <span class="cursor-pointer"
                     @click="\$openModal('projectEditorModal');
                             \$dispatch('projectEditMode', {id: '$model->id'})"
                    >
                           $model->name
                    </span>
                HTML;
            })
            ->addColumn('budget')
            ->addColumn('status')
            ->addColumn('start_date')
            ->addColumn('end_date');
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'Name')
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
