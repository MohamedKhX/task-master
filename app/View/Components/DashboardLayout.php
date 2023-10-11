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
        $employee = auth()->user()->employee;
        $team     = $employee->team;

        $members  = $team?->members;

        $projects = $team?->projects()->limit(5)->get();

        return view('layouts.dashboard', [
            'employee' => $employee,
            'members'  => $members,
            'projects' => $projects,
            'team'     => $team
        ]);
    }
}
