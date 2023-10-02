<div>
    <div class="flex justify-center gap-1 text-sm">
        @if($task->start_date)
            <span>{{ \Carbon\Carbon::parse($task->start_date)->format('d M') }} </span>
        @endif
        @if($task->end_date)
            <span> - {{ \Carbon\Carbon::parse($task->end_date)->format('d M') }} </span>
        @endif
    </div>
</div>
