<x-dashboard-layout>

    {{-- Task Dialog --}}
    @push('dialogs')
    <livewire:modal.employee-editor />
    @endpush
    {{-- End Task Dialog --}}

    <div class="px-5 ">
        <div class="mt-5">
            <livewire:table.employees/>
        </div>
    </div>

</x-dashboard-layout>
