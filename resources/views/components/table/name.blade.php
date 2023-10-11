<div class='flex flex-row gap-2'>
    <span @click="$openModal('taskEditorModal');
     $dispatch('taskEditMode', {id: '{{ $task->id }}'})"
          class='text-sm cursor-pointer'>
       {{ $name }}

    </span>
    <div class='flex flex-row gap-2'>
        @foreach($tags->take(4) as $tag)
            <span class='flex items-center justify-center opacity-75 bg-primary-500 rounded-full
             text-white text-xs xs px-2'
                  style="{{'background-color: ' . $tag->color}}">
               {{ $tag->name }}
            </span>

            @if($loop->last && $tags->count() >= 5)
                <span class='flex items-center justify-center opacity-75 bg-primary-500 rounded-full
                 text-white text-xs xs px-2'
                          style="background-color: gray">
                   others
                </span>
            @endif

        @endforeach
    </div>
</div>
