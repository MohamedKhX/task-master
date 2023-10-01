<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use WireUi\View\Components\Modal;

class TaskEditorModal extends Component
{
    public Project $project;

    public Modal $taskEditorModal;


    public function render()
    {
        return view('livewire.task-editor-modal', [
            'priorities' => \App\Enums\TaskPriority::getValues()
        ]);
    }
}
