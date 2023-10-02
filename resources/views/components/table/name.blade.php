<div class='flex flex-row gap-2'>
    <span @click="$openModal('taskEditorModal')" class='text-sm cursor-pointer'>{{$task->name}}</span>
    <div class='flex flex-row gap-2'>
        <span class='flex items-center justify-center opacity-75 bg-primary-500 rounded-full text-white text-xs xs px-2'>
            Tag
        </span>
        <span class='flex items-center justify-center  opacity-75 bg-danger rounded-full text-white text-xs px-2'>
            Red
        </span>
        <span class='flex items-center justify-center  opacity-75 bg-danger rounded-full text-white text-xs px-2'>
            Red
        </span>
        <span class='flex items-center justify-center  opacity-75 bg-danger rounded-full text-white text-xs px-2'>
            Red
        </span>
        <span class='flex items-center justify-center  opacity-75 bg-danger rounded-full text-white text-xs px-2'>
            Red
        </span>
    </div>
</div>
