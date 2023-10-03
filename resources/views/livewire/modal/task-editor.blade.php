<x-modal
    @task-created.window="close"
    @task-updated.window="close"
    wire:model="taskEditorModal">
    <x-card title="Task Editor">
        <div class="p-5 py-0 flex flex-col gap-5">
            <x-input label="Task Name"
                     placeholder="Enter the task name..."
                     wire:model="task_name"
            />
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
            <x-select
                label="Assign To:"
                wire:model.defer="asyncSearchUser"
                placeholder="Select some user"
                :template="[
                            'name'   => 'user-option',
                            'config' => ['src' => 'profile_image']
                        ]"
                option-label="name"
                option-value="id"
                option-description="email"
                multiselect="true"
            />

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
            <x-textarea
                wire:model="task_description"
                label="Description"
                placeholder="Unleash your thoughts and describe the task in vivid detail..."
            />
        </div>

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
