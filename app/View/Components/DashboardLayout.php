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
        return view('layouts.dashboard', [
            'teams' => Team::all(),
            'projects' => Project::all()
        ]);
    }
}
