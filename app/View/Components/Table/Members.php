<?php

namespace App\View\Components\Table;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Members extends Component
{
    public Collection $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function render(): View|Closure|string
    {
        return view('components.members', [
            'members' => $this->members
        ]);
    }
}
