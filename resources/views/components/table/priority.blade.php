<div>
     @if($task->priority)
        <div class="cursor-pointer">
            <x-badge :label="$task->priority" />
        </div>
    @endif
</div>
