<x-modal
    {{-- Close Modal on created or updated Task --}}
    @employee-created.window="close"
    @employee-updated.window="close"

    {{-- The name of the modal --}}
    wire:model="employeeEditorModal"

    z-index="z-999"
>

    <x-card title="Employee Editor">

        {{-- On Loading --}}
        <x-spinner/>
        {{-- On Loading --}}

        {{-- Start Form --}}
        <div wire:loading.class="hidden" class="p-5 py-0 flex flex-col gap-5">

            <x-input name="email" wire:model="email" class="pr-28" label="Email" placeholder="Enter employee email" suffix="@mail.com" />
            <x-input name="name" wire:model="name" label="User Name" placeholder="Enter employee name" />
            <x-input name="job_role" wire:model="job_role" label="Job Role" placeholder="Enter employee Job role" />

            <x-select
                label="Team"
                placeholder="Select team"
                wire:model.defer="team_id"
            >
                @foreach($teams as $team)
                    <x-select.option label="{{ $team->name }}" value="{{ $team->id }}" />
                @endforeach
            </x-select>

            @if(! $editMode)
                <x-inputs.password name="password" wire:model="password" label="employee Password" />
                <x-inputs.password id="password_confirmation" name="password_confirmation" wire:model="password_confirmation" label="Confirm Password" />
            @endif

        </div>
        {{-- End Form --}}

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <form method="post" wire:submit="saveEmployee">
                    <x-button type="submit" primary label="Save" />
                </form>
            </div>
        </x-slot>
    </x-card>
</x-modal>
