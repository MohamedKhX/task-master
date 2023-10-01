@props(['name', 'href' => '#'])
<li>
    <a wire:navigate
       class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2
        duration-300 ease-in-out hover:text-white"
       href="{{ $href }}"
       @click="subItemSelected = '{{ $name }}'"
       :class="subItemSelected === '{{ $name }}' ? 'text-white' : null">
        {{ $name }}
    </a>
</li>
