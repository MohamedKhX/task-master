<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if($user->hasPermissionTo('create employees'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): Response
    {
        if($user->hasPermissionTo('update employees'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employee $employee): Response
    {
        if($user->hasPermissionTo('delete employees'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }
}
