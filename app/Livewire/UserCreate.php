<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use WireUi\Traits\Actions;

class UserCreate extends Component
{
    use Actions;

    public string $name;
    public string $email;
    public string $password;
    public string $password_confirmation;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ];
    }

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->notification()->success(
            'User Created Successfully'
        );

        return $user;
    }

    public function render()
    {
        return view('livewire.user-create');
    }
}
