<div>
    <x-select
        placeholder="Select relator"
        multiselect="true"
        wire:model.defer="model"

    >

        <x-select.user-option src="https://via.placeholder.com/500" label="People 1" value="1" />

        <x-select.user-option src="https://via.placeholder.com/500" label="People 2" value="2" />

        <x-select.user-option src="https://via.placeholder.com/500" label="People 3" value="3" />

        <x-select.user-option src="https://via.placeholder.com/500" label="People 4" value="4" />

    </x-select>
</div>
