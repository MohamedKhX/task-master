<x-modal wire:model="taskEditorModal">
    <x-card title="Task Editor">
        <div class="p-5 py-0 flex flex-col gap-5">
            <x-input label="Task Name" placeholder="Enter the task name..." x-model="name" />
            <div class="flex gap-4 w-full">
                <x-select
                    label="Select Status"
                    placeholder="Select one status"
                    :options="$project->task_status_template"
                    class="flex-grow"
                />
                <x-select
                    label="Select priority"
                    placeholder="Select one priority"
                    :options="$priorities"
                    class="flex-grow"

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
                        wire:model.defer="normalPicker"
                    />
                </div>
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select End Date"
                        placeholder="End date of the task"
                        wire:model.defer="normalPicker"
                    />
                </div>
            </div>
            <x-textarea wire:model="comment" label="Description" placeholder="Unleash your thoughts and describe the task in vivid detail..." />

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="I Agree" />
            </div>
        </x-slot>
    </x-card>
</x-modal>
