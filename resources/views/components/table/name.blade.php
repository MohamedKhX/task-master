<div class='flex flex-row gap-2'>
    <span @click="$openModal('taskEditorModal')" class='text-sm cursor-pointer'>{{$task->name}}</span>
    <div class='flex flex-row gap-2'>
        @foreach($task->tags as $tag)
            <span class='flex items-center justify-center opacity-75 bg-primary-500 rounded-full
             text-white text-xs xs px-2'
                  style="{{'background-color: ' . $tag->color}}">
               {{ $tag->name }}
            </span>
        @endforeach
    </div>
</div>
