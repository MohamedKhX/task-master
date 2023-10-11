<x-modal
    {{-- Close Modal on created or updated Task --}}
    @project-created.window="close"
    @project-updated.window="close"

    {{-- The name of the modal --}}
    wire:model="projectEditorModal"

    z-index="z-999"
>

    <x-card title="Project Editor">

        {{-- On Loading --}}
        <x-spinner/>
        {{-- On Loading --}}

        {{-- Start Form --}}
        <div wire:loading.class="hidden" class="p-5 py-0 flex flex-col gap-5">

            <x-input name="name" wire:model="name" class="pr-28" label="Project Name" placeholder="Enter project name" />
            <x-input name="budget" wire:model="budget" label="Project Budget" placeholder="Enter project budget" />

            <x-select
                label="Select status"
                placeholder="Select status"
                wire:model="status"
            >
                @foreach($statuses as $status)
                    <x-select.option
                        :label="$status"
                        :value="$status"
                    />
                @endforeach

            </x-select>

            {{-- Start Due Date Inputs --}}
            <div class="flex gap-4">
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select Start Date"
                        placeholder="Start date of the task"
                        wire:model="start_date"
                        without-time
                    />
                </div>
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select End Date"
                        placeholder="End date of the task"
                        wire:model="end_date"
                        without-time
                    />
                </div>
            </div>
            {{-- End Due Date Inputs --}}


        </div>
        {{-- End Form --}}

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                @canany('update projects')
                    <form method="post" wire:submit="saveProject">
                        <x-button type="submit" primary label="Save" />
                    </form>
                @endcanany
            </div>
        </x-slot>
    </x-card>
</x-modal>
