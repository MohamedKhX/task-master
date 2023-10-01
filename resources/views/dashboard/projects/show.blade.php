<x-dashboard-layout>
    {{-- Task Dialog --}}
    @push('dialogs')
        <x-dialog id="custom" title="Add New Task">
            <div class="mt-5 flex flex-col gap-5">
                <x-input label="Task Name" placeholder="Enter the task name..." x-model="name" />
                <x-select
                    label="Select Status"
                    placeholder="Select one status"
                    :options="$project->task_status_template"
                />
                <x-select
                    label="Select priority"
                    placeholder="Select one priority"
                    :options="\App\Enums\TaskPriority::getValues()"
                />
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
                <x-datetime-picker

                    label="Select Start Date"

                    placeholder="Start date of the task"

                    wire:model.defer="normalPicker"

                />
                <x-datetime-picker

                    label="Select End Date"

                    placeholder="End date of the task"

                    wire:model.defer="normalPicker"

                />

            </div>

        </x-dialog>
    @endpush
    {{-- End Task Dialog --}}


    <div class="p-5">
        <h3 class="text-xl font-semibold">Task List</h3>
        <div class="flex gap-8 mt-5">
            <div class="w-3/12 flex flex-col gap-5 bg-white shadow-2 p-5">
                <div class="flex flex-col gap-5">
                    <x-button  outline icon="plus" primary label="Add New Task" x-on:click="$wireui.confirmDialog({
                id: 'custom',
                icon: 'question',
                accept: {
                    label: 'Yes, save it',
                    execute: () => window.$wireui.notify({
                        'title': 'Profile name saved',
                        'description': `Good by, ${name}`,
                        'icon': 'success'
                    })
                },
                reject: {
                    label: 'No, cancel',
                    execute: () => window.$wireui.notify({
                        'title': 'You not confirmed',
                        'description': `Good by, ${name}`,
                        'icon': 'error'
                    })
                }
            })" />
                    <ul class="p-3 flex flex-col gap-5">
                        <li>
                            <a class="flex items-center gap-2 text-secondary-600 text-sm hover:text-primary-600 transition" href="">
                                <x-icon name="folder" class="w-5 h-5" />
                                <span>All Tasks</span>
                            </a>
                        </li>
                        <li>
                            <a class="flex items-center gap-2 text-secondary-600 text-sm hover:text-primary-600 transition" href="">
                                <x-icon name="clipboard-list" class="w-5 h-5" />
                                <span>My Tasks</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold">Status</h4>
                    <ul class="p-3 flex flex-col gap-5 mt-2">
                        <li>
                            <a class="flex items-center justify-between gap-2 text-secondary-600 text-sm hover:text-primary-600 transition" href="">
                                <div class="flex items-center gap-2">
                                    <x-icon name="arrows-expand" class="w-5 h-5" />
                                    <span>Pending Tasks</span>
                                </div>
                                <div>23</div>
                            </a>
                        </li>
                        <li>
                            <a class="flex items-center justify-between gap-2 text-secondary-600 text-sm hover:text-primary-600 transition" href="">
                                <div class="flex items-center gap-2">
                                    <x-icon name="check-circle" class="w-5 h-5" />
                                    <span>Completed</span>
                                </div>
                                <div>30</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold">Tags</h4>
                    <ul class="p-3 flex flex-col gap-5 mt-2">
                        <li>
                            <a class="flex items-center justify-between gap-2 text-secondary-600 text-sm hover:text-primary-600 transition" href="">
                                <div class="flex items-center gap-2">
                                    <div class="text-danger">
                                        <x-icon name="tag" class="w-5 h-5" />
                                    </div>
                                    <span>Frontend</span>
                                </div>
                                <div>12</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-9/12">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus atque aut beatae blanditiis commodi corporis dolore eaque est facilis illum magni maxime minima nemo nostrum numquam officia reiciendis rem sed similique sunt vel, voluptatem. Harum hic maxime nam. Ab aliquid cum debitis est et labore praesentium quod unde ut.</div>
        </div>
    </div>

</x-dashboard-layout>
