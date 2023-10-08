<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body
    x-data="{'loaded': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    style="background-color: rgb(241, 245, 249);" >

    <x-notifications />

    {{-- Start Dialogs --}}
    <x-dialog/>
    @stack('dialogs')
    {{-- End Dialogs --}}

    {{-- Start Page Wrapper --}}
    <div class="flex h-screen overflow-hidden">

        {{-- Start Sidebar --}}
        <x-dashboard.sidebar>
            <x-dashboard.sidebar_menu_group title="Menu">

                <x-dashboard.sidebar_menu_item
                    name="Overview"
                    icon-name="home"
                    href="{{ route('dashboard') }}"
                />

                <x-dashboard.sidebar_menu_item
                    name="Inbox"
                    icon-name="inbox"
                    href="{{ route('tasks') }}"
                />

                <x-dashboard.sidebar_menu_item
                    name="Employees"
                    icon-name="briefcase"
                    href="{{ route('employee.index') }}"
                />


                <x-dashboard.sidebar_menu_item
                    name="Teams"
                    icon-name="hand"
                    href="{{ route('team.index') }}"
                />

            </x-dashboard.sidebar_menu_group>
            @if($projects)
                <x-dashboard.sidebar_menu_group title="Our Projects">

                    @forelse($projects as $project)
                        <x-dashboard.sidebar_menu_item
                            name="{{ $project->name }}"
                            icon-name="check-circle"
                            icon-fills="fill-danger"
                            href="{{ route('project.show', $project) }}"
                        />
                    @empty
                        <span class="text-white ml-4 my-3">No Projects yet!</span>
                    @endforelse

                    <x-dashboard.sidebar_menu_item
                        name="All Projects"
                        icon-name="dots-horizontal"
                        href="{{ route('project.index') }}"
                    />

                </x-dashboard.sidebar_menu_group>
            @endif
            <x-dashboard.sidebar_menu_group title="Team Members">
                <x-dashboard.sidebar_menu_item class="flex items-center justify-start ml-4" type="empty">
                    @if($team)
                        <div class="flex justify-center items-center flex-col gap-4 2xsm:flex-row 2xsm:items-center">
                            <div class="flex flex-wrap gap-2">
                                @foreach($members as $member)
                                    <a wire:navigate href="{{ route('employee.show', $member) }}" class="h-8 w-8 rounded-full border-2 border-white dark:border-boxdark">
                                        <img src="{{ asset($member?->avatar_path)}}" alt="User">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span class="text-white">You aren't in a team yet</span>
                    @endif

                </x-dashboard.sidebar_menu_item>
            </x-dashboard.sidebar_menu_group>
        </x-dashboard.sidebar>
        {{-- End Sidebar --}}

        <div class=" relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            {{-- Start Header --}}
            <x-dashboard.header />
            {{-- End Header --}}

            <main>
                {{ $slot }}
            </main>

        </div>

    </div>
    {{-- End Page Wrapper --}}

    @stack('script')
    <wireui:scripts />
    @livewireScripts
</body>
</html>
