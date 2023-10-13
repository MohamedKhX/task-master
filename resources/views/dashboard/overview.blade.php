<x-dashboard-layout>
    {{-- Task Dialog --}}
    @push('dialogs')
        <livewire:modal.task-editor />
        <livewire:modal.sub-tasks />
    @endpush
    {{-- End Task Dialog --}}

    <div class="px-5 ">
        <div class="mt-5">
            <livewire:table.overview :employee="$employee" />
        </div>
    </div>

</x-dashboard-layout>
