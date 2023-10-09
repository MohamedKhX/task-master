@props([
    'name',
    'iconName',
    'href' => '',
    'iconFills' => '',
    'type' => ''
    ])

@if($type === 'multi')
    <li>
        <a
            class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
            href="#"
            @click.prevent="selected = (selected === '{{ $name }}' ? '':'{{ $name }}')"
            :class="{ 'bg-graydark dark:bg-meta-4': (selected === '{{ $name }}')}"
        >
            <x-icon name="{{ $iconName }}" class="w-5 h-5 {{ $iconFills }}"/>

            {{ $name }}

            <svg
                class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                :class="{ 'rotate-180': (selected === 'Forms') }"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                    fill=""
                />
            </svg>
        </a>

        {{-- Start Dropdown Menu --}}
        <div
            class="overflow-hidden"
            :class="(selected === '{{ $name }}') ? 'block' :'hidden'"
            x-data="{subItemSelected: ''}"
        >
            <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                {{ $slot }}
            </ul>
        </div>
        <!-- End Dropdown Menu  -->
    </li>
@elseif($type === 'empty')
    <li :class="{{ $attributes->merge(['class'])}}">
        {{ $slot }}
    </li>
@else
    {{-- Overview Item --}}
    <li
        x-init="

        if(getUrlWithoutQueryString() === '{{ $href }}')
        {
            selected = '{{$name}}'
        }

        function getUrlWithoutQueryString() {
            let url = window.location.href;
            let index = url.indexOf('?');

            if (index !== -1) {
                url = url.substring(0, index);
            }

            return url;
        }


        ">
        <a
            wire:navigate
            class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
            href="{{ $href }}"
            @click="selected = '{{ $name }}'"
            :class="selected === '{{$name}}' ? 'bg-graydark dark:bg-meta-4' : null"
        >
            <x-icon name="{{ $iconName }}" class="w-5 h-5 {{ $iconFills }}"/>
            {{ $name }}
        </a>
    </li>
@endif

