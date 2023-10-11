<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    public function createSubtask(User $user, Task $parentTask): Response
    {
        return $this->checkUserAbilities($user, $parentTask);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
       return $this->checkUserAbilities($user, $task);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): Response
    {
        if($user->hasRole('teamLeader'))
            return Response::allow();

        return Response::deny('Unauthorized');
    }

    protected function checkUserAbilities(User $user, Task $task): Response
    {
        if($user->hasRole('teamLeader'))
            return Response::allow();

        if($user->id === $task->created_by)
            return Response::allow();

        if($task->assignments()
            ->where('employee_id', '=', $user->employee->id)
            ->exists()
        )
            return Response::allow();


        return Response::deny('Unauthorized');
    }
}
