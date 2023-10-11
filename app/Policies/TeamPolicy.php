<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if($user->hasPermissionTo('create teams'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): Response
    {
        if($user->hasPermissionTo('update teams'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): Response
    {
        if($user->hasPermissionTo('delete teams'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }
}
