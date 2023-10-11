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

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): Response
    {
        if($user->hasRole('teamLeader'))
            return Response::allow();

        if($user->id === $task->createdBy)
            return Response::allow();

        if($task->assignments()->whereIn('id', $user->id))
            return Response::allow();

        else
            return Response::deny('Unauthorized');
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
}
