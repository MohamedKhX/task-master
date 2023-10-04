<div class="flex justify-center">
    <x-button.circle @click="$openModal('subTasksModal');  $dispatch('showSubTasks', {taskId: '{{ $task->id }}'})"
                     secondary
                     icon="clipboard-list"
    />
</div>


