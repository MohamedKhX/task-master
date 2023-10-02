<div>
    <div class="cursor-pointer flex justify-center">
        <x-badge :color="\App\Enums\TaskStatus::getColor($task->status)" :label="$task->status" />
    </div>
</div>
