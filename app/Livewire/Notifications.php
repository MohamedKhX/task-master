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
        $notifications       = $this->employee->notifications()->limit(20)->get();
        $unReadNotifications = $notifications->where('read_at', '=', null);

        return view('livewire.notifications', [
            'notifications'       => $notifications,
            'unReadNotifications' => $unReadNotifications
        ]);
    }
}
