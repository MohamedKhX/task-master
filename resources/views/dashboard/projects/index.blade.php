<x-dashboard-layout>

    {{-- Task Dialog --}}
    @push('dialogs')
        <livewire:modal.project-editor />
    @endpush
    {{-- End Task Dialog --}}

    <div class="px-5 ">
        <div class="mt-5">
            <livewire:table.projects />
        </div>
    </div>

</x-dashboard-layout>
