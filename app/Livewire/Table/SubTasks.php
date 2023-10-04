<?php

namespace App\Livewire\Table;

use App\Models\Task;
use Livewire\Attributes\Url;

final class SubTasks extends TaskTable
{
    public ?Task $task;
}
