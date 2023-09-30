<aside
    :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false"
>
    {{-- Sidebar Header --}}
    <div class="flex items-center justify-center gap-2 px-6 py-5.5 pt-12">
        <a href="{{ route('dashboard') }}">
            <img class="w-52" src="{{ asset('img/logo/logo-no-background.svg') }}" alt="">
        </a>
        <button
            class="block lg:hidden"
            @click.stop="sidebarToggle = !sidebarToggle"
        >
            <svg
                class="fill-white"
                width="20"
                height="18"
                viewBox="0 0 20 18"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill=""
                />
            </svg>
        </button>
    </div>
    {{-- Sidebar Header --}}

    {{-- Sidebar Menu --}}
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        @persist('nav')
            <nav
                class="mt-2 py-2 px-4 lg:mt-5 lg:px-6"
                x-data="{selected: 'Overview'}">

                {{ $slot }}

            </nav>

        @endpersist
    </div>
    {{-- Sidebar Menu --}}

</aside>
