<div>
     @if($task->priority)
        <div class="cursor-pointer flex justify-center">
            <x-badge :color="\App\Enums\TaskPriority::getColor($task->priority)" :label="$task->priority" />
        </div>
    @endif
</div>
