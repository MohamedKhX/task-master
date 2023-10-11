<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if($user->hasPermissionTo('create projects'))
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): Response
    {
        if($user->hasPermissionTo('update projects')
            && $user->employee->team_id === $project->team_id)
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): Response
    {
        if($user->hasPermissionTo('delete projects')
            && $user->employee->team_id === $project->team_id)
            return Response::allow();
        else
            return Response::deny('Unauthorized');
    }
}
