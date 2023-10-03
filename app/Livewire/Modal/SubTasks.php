<?php

namespace App\Livewire\Modal;

use Livewire\Component;
use WireUi\View\Components\Modal;

class SubTasks extends Component
{

    public Modal $subTasksModal;

    public function render()
    {
        return view('livewire.modal.sub-tasks');
    }
}
