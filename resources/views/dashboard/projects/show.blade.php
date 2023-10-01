<x-dashboard-layout>
    {{-- Task Dialog --}}
    @push('dialogs')
        <livewire:task-editor-modal :project="$project" />
    @endpush
    {{-- End Task Dialog --}}
{{--
            <div class="w-3/12 flex flex-col gap-5 bg-white shadow-2 p-5">
                <div class="flex flex-col gap-5">
                    <x-button  outline icon="plus" primary label="Add New Task" @click="$openModal('taskEditorModal')" />
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
--}}
    <div class="p-5">
        <h3 class="text-xl font-semibold">Task List</h3>
        <div class="">
                <livewire:task-table />
        </div>
    </div>

</x-dashboard-layout>
