<x-modal
    {{-- Close Modal on created or updated Task --}}
    @team-created.window="close"
    @team-updated.window="close"

    {{-- The name of the modal --}}
    wire:model="teamEditorModal"

    z-index="z-999"
>

    <x-card title="Team Editor">

        {{-- On Loading --}}
        <x-spinner/>
        {{-- On Loading --}}

        {{-- Start Form --}}
        <div wire:loading.class="hidden" class="p-5 py-0 flex flex-col gap-5">

            <x-input name="name" wire:model="name" class="pr-28" label="Team Name" placeholder="Enter team name" />
            <x-input name="department" wire:model="department" label="Team Department" placeholder="Enter team department" />

            <x-select
                label="Select Leader"
                placeholder="Select Leader"
                wire:model="leader_id"
            >
                @foreach($employees as $employee)
                    <x-select.user-option
                        :src="asset($employee->avatar_path)"
                        :label="$employee->name"
                        :value="$employee->id"
                    />
                @endforeach

            </x-select>

            <x-select
                label="Select Members"
                placeholder="Select Members"
                wire:model="members"
                multiselect
            >
                @foreach($employees as $employee)
                    <x-select.user-option
                        :src="asset($employee->avatar_path)"
                        :label="$employee->name"
                        :value="$employee->id"
                    />
                @endforeach

            </x-select>



        </div>
        {{-- End Form --}}

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <form method="post" wire:submit="saveTeam">
                    <x-button type="submit" primary label="Save" />
                </form>
            </div>
        </x-slot>
    </x-card>
</x-modal>
