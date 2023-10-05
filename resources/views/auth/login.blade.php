<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 mt-18">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-16 w-auto"
                     src=" {{ asset('img/logo/logo-no-background.svg') }}"
                     alt="TaskMaster">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray">
                    Sign in to your account
                 </h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="flex flex-col">
                        <label for="email" class="mb-1 text-gray">Email</label>
                        <x-input class="pr-28" name="email" placeholder="your email" suffix="@mail.com" />
                    </div>
                    <div>
                        <label for="password" class="mb-1 text-gray">Password</label>
                        <x-inputs.password name="password"  value="" />
                    </div>
                    <div>
                        <x-button type="submit" primary label="Sign in" />
                    </div>
                </form>
            </div>
        </div>
</x-guest-layout>
