<div>
    <form wire:submit="createUser" class="flex flex-col gap-6 px-28 mt-4" action="">
        <x-input name="email" wire:model="email" class="pr-28" label="Email" placeholder="your email" suffix="@mail.com" />
        <x-input name="name" wire:model="name" label="User Name" placeholder="Enter user name" />
        <x-inputs.password name="password" wire:model="password" label="User Password" />
        <x-inputs.password id="password_confirmation" name="password_confirmation" wire:model="password_confirmation" label="Confirm Password" />

        <x-button type="submit" primary label="Create user" />
    </form>
</div>
