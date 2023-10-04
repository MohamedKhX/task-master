<x-dashboard-layout>

    {{-- Task Dialog --}}
    @push('dialogs')
        <livewire:modal.task-editor :project="$project" />
        <livewire:modal.sub-tasks />
    @endpush
    {{-- End Task Dialog --}}

    <div class="px-5 ">
        <div class="mt-5">
            <livewire:table.project-tasks :project="$project" />
        </div>
    </div>

</x-dashboard-layout>
