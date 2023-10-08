<?php

namespace App\View\Components;

use App\Models\Project;
use App\Models\Team;
use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $team = auth()->user()->employee->team;

        $members  = $team?->members;

        $projects = $team?->projects;

        return view('layouts.dashboard', [
            'members'  => $members,
            'projects' => $projects,
            'team'     => $team
        ]);
    }
}
