<x-modal max-width="6xl" wire:model="subTasksModal">
    <x-card title="Sub Tasks For {{ $task->name ?? null }}">
        <div class="w-full" wire:loading>
            <div class="flex gap-3 justify-center">
                <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
                     role="status">
              <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">
                  Loading...
              </span>
                </div>
                <span>Loading...</span>
            </div>
        </div>
        @if($task)
            <div wire:loading.class="hidden">
                <livewire:table.sub-tasks :task="$task"/>
            </div>
        @endif
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button secondary outline flat label="Close" x-on:click="close" />
            </div>
        </x-slot>
    </x-card>
</x-modal>
