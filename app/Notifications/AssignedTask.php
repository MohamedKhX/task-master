<?php

namespace App\Notifications;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignedTask extends Notification
{
    use Queueable;

    public Task $task;
    public Employee $employee;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, Employee $employee)
    {
        $this->task = $task;
        $this->employee = $employee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        $employeeName = $this->employee->name;
        $taskName = $this->task->name;

        return [
            'task_id' => $this->task->id,
            'message' => [
                'greeting' => "Hello $employeeName",
                'content' => 'A new task has been assigned to you. Please review the details and take necessary action.',
                'task_details' => [
                    'name' => $taskName,
                ],
            ],
        ];
    }
}
