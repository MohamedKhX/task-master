<?php

namespace App\Listeners;

use App\Events\AssignedTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAssignedTaskNotification
{
    /**
     * Handle the event.
     */
    public function handle(AssignedTask $event): void
    {
        $event->employee->notify(
            new \App\Notifications\AssignedTask($event->task, $event->employee)
        );
    }
}
