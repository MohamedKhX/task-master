<div class="">
    <x-select

        wire:model.defer="asyncSearchUser"

        placeholder="Choose an assignee..."

        :template="[

            'name'   => 'user-option',

            'config' => ['src' => 'profile_image']

        ]"

        option-label="name"

        option-value="id"

        option-description="email"

    />

</div>
