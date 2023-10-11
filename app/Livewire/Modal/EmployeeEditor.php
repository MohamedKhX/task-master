<?php

namespace App\Livewire\Modal;

use App\Models\Employee;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;
use Laravel\Fortify\Rules\Password;
use Laravolt\Avatar\Facade as Avatar;
use Livewire\Component;
use WireUi\Traits\Actions;

class EmployeeEditor extends Component
{
    use Actions;

    //Only on Edit Mode
    public bool      $editMode = false;
    public ?Employee $employee = null;
    public ?User     $user = null;

    public ?string $name  = null;
    public ?string $email = null;
    public ?string $job_role = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public ?string $team_id = null;

    protected $listeners = ['employeeEditMode', 'employeeCreateMode'];


    public function rules(): array
    {
        $rules = [
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'job_role' => ['nullable','string', 'max:50'],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ];

        if($this->editMode) {
            $rules['email']    = ['required', 'string', 'email', 'max:255', (new Unique('users'))->ignore($this->user)];
            $rules['password'] = [];
        }

        return $rules;
    }

    public function employeeEditMode($id): void
    {
        $this->employee = Employee::with('team')->find($id);
        $this->user     = $this->employee->user;
        $this->editMode = true;

        $this->name     = $this->employee->name;
        $this->job_role = $this->employee->job_role;
        $this->email    = $this->employee->user->email;
        $this->team_id  = $this->employee->team?->id;
    }

    public function employeeCreateMode(): void
    {
        $this->employee = null;
        $this->editMode = false;

        $this->name                  = null;
        $this->email                 = null;
        $this->job_role              = null;
        $this->password              = null;
        $this->password_confirmation = null;
        $this->team_id               = null;
    }

    public function saveEmployee(): bool
    {
        $this->validate();

        if ($this->editMode) {
            return $this->updateEmployee();
        } else {
            return $this->createEmployee();
        }

    }

    public function createEmployee(): bool
    {
        $this->authorize('create', Employee::class);

        $user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $employee = Employee::create([
            'user_id'     => $user->id,
            'team_id'     => $this->team_id,
            'name'        => $this->name,
            'job_role'    => $this->job_role,
        ]);

        $this->notification()->success(
            'User Created Successfully'
        );

        $this->dispatch('employee-created', $employee);

        return true;
    }


    public function updateEmployee(): bool
    {
        $this->authorize('update', $this->employee);

        $this->employee->update([
            'name'     => $this->name,
            'job_role' => $this->job_role,
            'team_id'  => $this->team_id
        ]);

        $this->user->update([
            'email' => $this->email
        ]);

        $this->notification()->success(
            'Employee Updated',
            'Employee was successfully updated'
        );

        $this->dispatch('employee-updated', $this->employee);

        return true;
    }

    public function render()
    {
        return view('livewire.modal.employee-editor', [
            'teams' => Team::all()
        ]);
    }
}
