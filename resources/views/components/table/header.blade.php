<div>
    <div class="flex my-5 gap-5 bg-white shadow-2 p-5">
        <div class="flex items-center flex-grow gap-5">
            @if($project)
                <x-button class="px-12" outline icon="plus" primary label="Add New Task"
                          @click="$openModal('taskEditorModal'); $dispatch('taskCreateMode')"
                />

            @else
                <x-button class="px-12" outline icon="plus" primary label="Add Sub Task"
                          @click="$openModal('taskEditorModal'); $dispatch('taskCreateMode', {parent_id: '{{ $task->id }}'})"
                />
            @endif
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
                label="Select tags"
                placeholder="Select tags"
                wire:model="filterTags"
                multiselect
            >
                @foreach($tags as $tag)
                    <x-select.option :label="$tag->name" :value="$tag->id" />
                @endforeach
            </x-select>

        </div>
    </div>

</div>
