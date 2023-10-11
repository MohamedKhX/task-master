<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;

class Notifications extends Component
{
    public Employee $employee;

    public function markAsRead(): void
    {
        $this->employee->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
