<div x-data="{show: false}">
    <div class="cursor-pointer" x-show="! show" @click="show = true">
        @if($priority)
            <x-badge negative :label="$priority" />
        @endif
    </div>
    <div x-show="show">
        <x-select
            wire:model.live="priority"
        >
            @foreach(\App\Enums\TaskPriority::getValues() as $priorityValue)
                <x-select.option :label="$priorityValue" :value="$priorityValue" />
            @endforeach

        </x-select>
    </div>
</div>
