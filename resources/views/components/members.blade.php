
@props(['members' => []])
<div class="flex justify-center items-center flex-col gap-4 2xsm:flex-row 2xsm:items-center">
    <div class="flex -space-x-2">
        @forelse($members->take(6) as $member)
            <a wire:navigate href="{{ route('employee.show', $member) }}" class="h-8 w-8 rounded-full border-2 border-white dark:border-boxdark">
                <img src="{{ asset( $member?->avatar_path) }}" alt="User">
            </a>
        @empty
            <span>Not Assigned</span>
        @endforelse
    </div>
</div>
