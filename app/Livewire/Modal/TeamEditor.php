<?php

namespace App\Livewire\Modal;

use App\Models\Employee;
use App\Models\Team;
use Livewire\Attributes\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class TeamEditor extends Component
{
    use Actions;

    //Only on Edit Mode
    public bool  $editMode = false;
    public ?Team $team = null;

    #[Rule('required|max:50|string')]
    public ?string $name       = null;

    #[Rule('required|max:60|string')]
    public ?string $department = null;

    #[Rule('nullable')]
    public array $members;

    protected $listeners = ['teamEditMode', 'teamCreateMode'];

    public function teamEditMode($id): void
    {
        $this->team     = Team::find($id);
        $this->editMode = true;

        $this->name       = $this->team->name;
        $this->department = $this->team->department;
        $this->members    = $this->team->members->pluck('id')->toArray();

    }

    public function teamCreateMode(): void
    {
        $this->team     = null;
        $this->editMode = false;

        $this->name       = null;
        $this->department = null;
        $this->members    = [];
    }

    public function saveTeam(): bool
    {
        $this->validate();

        if ($this->editMode) {
            return $this->updateTeam();
        } else {
            return $this->createTeam();
        }
    }

    public function createTeam(): bool
    {
        $team = Team::create([
            'name'       => $this->name,
            'department' => $this->department,
            'created_by' => auth()->user()->id
        ]);

        Employee::whereIn('id', $this->members)
            ->update(['team_id' => $team->id]);

        $this->notification()->success(
            'Team Created Successfully'
        );

        $this->dispatch('team-created', $team);

        return true;
    }

    public function updateTeam(): bool
    {
        $this->team->update([
           'name'       => $this->name,
           'department' => $this->department,
        ]);

        Employee::whereIn('id', $this->members)
            ->update(['team_id' => $this->team->id]);

        $this->notification()->success(
            'Team Updated',
            'Team was successfully updated'
        );

        $this->dispatch('team-updated', $this->team);

        return true;
    }

    public function render()
    {
        return view('livewire.modal.team-editor', [
            'employees' => Employee::all()
        ]);
    }
}
