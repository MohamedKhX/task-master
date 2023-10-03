<x-dashboard-layout>

    {{-- Task Dialog --}}
    @push('dialogs')
        <livewire:modal.task-editor :project="$project" />
        <livewire:modal.sub-tasks />
    @endpush
    {{-- End Task Dialog --}}

    <div class="px-5 ">
    {{--    <h3 class="text-xl font-semibold">Task List</h3>
        <button @click="$openModal('subTasksModal');" >sdf</button>--}}
        <div class="mt-5">
            <livewire:task-table />
        </div>
    </div>

</x-dashboard-layout>
