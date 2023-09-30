@props(['title'])
<div>
    <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">{{ $title }}</h3>

    <ul class="mb-6 flex flex-col gap-1.5">
        {{ $slot }}
    </ul>
</div>
