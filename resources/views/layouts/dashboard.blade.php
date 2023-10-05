<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <wireui:scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body
    x-data="{'loaded': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    style="background-color: rgb(241, 245, 249);" >

    <x-notifications />

    {{-- Start Dialogs --}}
    <x-dialog />
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

            </x-dashboard.sidebar_menu_group>
            <x-dashboard.sidebar_menu_group title="Projects">

                @foreach($projects as $project)
                    <x-dashboard.sidebar_menu_item
                        name="{{ $project->name }}"
                        icon-name="check-circle"
                        icon-fills="fill-danger"
                        href="{{ route('project.show', $project) }}"
                    />
                @endforeach

            </x-dashboard.sidebar_menu_group>
            <x-dashboard.sidebar_menu_group title="Team">
                <x-dashboard.sidebar_menu_item class="flex items-center justify-start ml-4" type="empty">
                    <x-members />
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
    @livewireScripts
</body>
</html>
