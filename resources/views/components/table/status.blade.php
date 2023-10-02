<div>
    <x-select
        wire:model.defer="model"
        :options="\App\Enums\TaskPriority::getValues()"
    />
</div>
