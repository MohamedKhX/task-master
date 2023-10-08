<?php

namespace App\Livewire\Modal;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class ProjectEditor extends Component
{

    use Actions;

    //Only on Edit Mode
    public bool $editMode    = false;
    public ?Project $project = null;

    public ?string $name       = null;
    public ?string $status     = null;
    public ?string $budget     = null;
    public ?string $start_date = null;
    public ?string $end_date   = null;

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:50'],
            'status'     => ['required', new Enum(ProjectStatus::class)],
            'budget'     => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date']
        ];
    }

    protected $listeners = ['projectEditMode', 'projectCreateMode'];

    public function projectEditMode($id): void
    {
        $this->project = Project::find($id);
        $this->editMode = true;

        $this->name       = $this->project->name;
        $this->status     = $this->project->status;
        $this->budget     = $this->project->budget;
        $this->start_date = $this->project->start_date;
        $this->end_date   = $this->project->end_date;
    }

    public function projectCreateMode(): void
    {
        $this->project  = null;
        $this->editMode = false;

        $this->name       = null;
        $this->status     = null;
        $this->budget     = null;
        $this->start_date = null;
        $this->end_date   = null;
    }

    public function saveProject(): bool
    {
        $this->validate();

        if ($this->editMode) {
            return $this->updateProject();
        } else {
            return $this->createProject();
        }
    }

    public function createProject(): bool
    {
        $project = Project::create([
            'name'       => $this->name,
            'status'     => $this->status,
            'budget'     => $this->budget,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,

            'team_id'    => auth()->user()->employee->team->id,
            'created_by' => auth()->user()->employee->id
        ]);


        $this->notification()->success(
            'Project Created Successfully'
        );

        $this->dispatch('project-created', $project);

        return true;
    }

    public function updateProject(): bool
    {
        $this->project->update([
            'name'       => $this->name,
            'status'     => $this->status,
            'budget'     => $this->budget,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date
        ]);

        $this->notification()->success(
            'Project Updated',
            'Project was successfully updated'
        );

        $this->dispatch('project-updated', $this->project);

        return true;
    }

    public function render()
    {
        return view('livewire.modal.project-editor', [
            'statuses' => ProjectStatus::getValues()
        ]);
    }
}
