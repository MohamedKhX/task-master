<div>
    <div class="flex my-5 gap-5 bg-white shadow-2 p-5">
        <div class="flex items-center flex-grow gap-5">
            <x-button class="px-12" outline icon="plus" primary label="Add New Task"
                      @click="$openModal('taskEditorModal'); $dispatch('taskCreateMode')"

            />
        </div>
        <div class="flex items-center gap-5">
            <x-select
                placeholder="Filter"
                :options="['All Tasks', 'My Tasks']"
                wire:model.live="filterTasks"
            />
        </div>
        <div class="flex items-center gap-5">
            <x-select
                placeholder="Status"
                :options="['Completed', 'In Progress', 'Pending']"
                wire:model.live="filterStatus"
            />
        </div>
        <div class="flex items-center gap-5">
            <x-select
                multiselect
                :async-data="route('tags')"
                placeholder="Tags"
                option-label="name"
                option-value="id"
                wire:model.live="filterTags"
            />
        </div>
    </div>

</div>
