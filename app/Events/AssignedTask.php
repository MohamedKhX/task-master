<?php

namespace App\Events;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignedTask
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Task $task;
    public Employee $employee;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task, Employee $employee)
    {
        $this->task = $task;
        $this->employee = $employee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
