<x-modal
    {{-- Close Modal on created or updated Task --}}
    @task-created.window="close"
    @task-updated.window="close"

    {{-- The name of the modal --}}
    wire:model="taskEditorModal"

    z-index="z-999"
>

    <x-card title="Task Editor">

        {{-- On Loading --}}
        <x-spinner/>
        {{-- On Loading --}}

        {{-- Start Form --}}
        <div wire:loading.class="hidden" class="p-5 py-0 flex flex-col gap-5">

            {{-- Start Task Name Input --}}
            <x-input label="Task Name"
                     placeholder="Enter the task name..."
                     wire:model="task_name"
            />
            {{-- End Task Name Input --}}

            {{-- Start Status And Priority Inputs --}}
            <div class="flex gap-4 w-full">
                <x-select
                    label="Select Status"
                    placeholder="Select one status"
                    :options="$status"
                    class="flex-grow"
                    wire:model="task_status"
                />
                <x-select
                    label="Select priority"
                    placeholder="Select one priority"
                    :options="$priorities"
                    class="flex-grow"
                    wire:model="task_priority"
                />
            </div>
            {{-- End Status And Priority Inputs --}}

            {{-- Start Assignee To Input --}}
            <div>
                <x-select
                    label="Select Relator"
                    placeholder="Select relator"
                    wire:model.defer="model"
                    multiselect
                >
                    <x-select.user-option src="https://via.placeholder.com/500" label="People 1" value="1" />
                    <x-select.user-option src="https://via.placeholder.com/500" label="People 2" value="2" />
                    <x-select.user-option src="https://via.placeholder.com/500" label="People 3" value="3" />
                    <x-select.user-option src="https://via.placeholder.com/500" label="People 4" value="4" />
                </x-select>
            </div>
            {{-- End Assignee To Input --}}

            {{-- Start Tags Input --}}
            <div>
                <x-select
                    label="Tags:"
                    placeholder="Select some user"
                    option-label="name"
                    option-value="id"
                    multiselect="true"
                />
            </div>
            {{-- End Tags Input --}}

            {{-- Start Due Date Inputs --}}
            <div class="flex gap-4">
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select Start Date"
                        placeholder="Start date of the task"
                        wire:model="task_start_date"
                        without-time
                    />
                </div>
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select End Date"
                        placeholder="End date of the task"
                        wire:model="task_end_date"
                        without-time
                    />
                </div>
            </div>
            {{-- End Due Date Inputs --}}

            {{-- Start Description Textarea --}}
            <div>
                <x-textarea
                    wire:model="task_description"
                    label="Description"
                    placeholder="Unleash your thoughts and describe the task in vivid detail..."
                />
            </div>
            {{-- End Description Textarea --}}

        </div>
        {{-- End Form --}}

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <form method="post" wire:submit="saveTask">
                    <x-button type="submit" primary label="Save" />
                </form>
            </div>
        </x-slot>
    </x-card>
</x-modal>
