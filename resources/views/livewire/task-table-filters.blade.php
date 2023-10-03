<div class="flex my-5 gap-5 bg-white shadow-2 p-5">
    <div class="flex items-center flex-grow gap-5">
        <x-button class="px-12" outline icon="plus" primary label="Add New Task"
                  {{--@click="$openModal('taskEditorModal')" --}}
                  wire:click="changeData()"
        />
    </div>
    <div class="flex items-center gap-5">
        <x-select
            placeholder="Filter"
            :options="['All Tasks', 'My Tasks']"
            wire:model.live="tasksFilter"
        />
    </div>
    <div class="flex items-center gap-5">
        <x-select
            placeholder="Status"
            :options="['Complete', 'In Progress', 'Pending']"
            wire:model.defer="model"
        />
    </div>
    <div class="flex items-center gap-5">
        <x-select
            placeholder="Tags"
            :options="['Complete', 'In Progress', 'Pending']"
            wire:model.defer="model"
        />
    </div>
</div>
