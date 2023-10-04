<?php

namespace App\Livewire\Table;

use App\Models\Project;
use Livewire\Component;

final class ProjectTasks extends TaskTable
{
    public ?Project $project;
}
