<x-modal  max-width="6xl" wire:model="subTasksModal">
    <x-card title="Task Editor">
        <livewire:task-table />
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="Create" />
            </div>
        </x-slot>
    </x-card>
</x-modal>
