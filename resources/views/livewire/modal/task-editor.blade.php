<x-modal
    {{-- Close Modal on created or updated Task --}}
    @task-created.window="close"
    @task-updated.window="close"

    {{-- The name of the modal --}}
    wire:model="taskEditorModal"

    z-index="z-999"
>

    <x-card title="Task Editor">

        {{-- On Loading --}}
        <x-spinner/>
        {{-- On Loading --}}

        {{-- Start Form --}}
        <div wire:loading.class="hidden" class="p-5 py-0 flex flex-col gap-5">

            {{-- Start Task Name Input --}}
            <x-input label="Task Name"
                     placeholder="Enter the task name..."
                     wire:model="task_name"
            />
            {{-- End Task Name Input --}}

            {{-- Start Status And Priority Inputs --}}
            <div class="flex gap-4 w-full">
                <x-select
                    label="Select Status"
                    placeholder="Select one status"
                    :options="$status"
                    class="flex-grow"
                    wire:model="task_status"
                />
                <x-select
                    label="Select priority"
                    placeholder="Select one priority"
                    :options="$priorities"
                    class="flex-grow"
                    wire:model="task_priority"
                />
            </div>
            {{-- End Status And Priority Inputs --}}

            {{-- Start Assignee To Input --}}
            <div>
                <x-select
                    label="Select employee"
                    placeholder="Select employee"
                    wire:model="task_assignments"
                    multiselect
                >
                    @foreach($members as $member)
                        <x-select.option :label="$member->name" :value="$member->id" />
                    @endforeach
                </x-select>
            </div>
            {{-- End Assignee To Input --}}

            {{-- Start Tags Input --}}
            <div>
                <div x-data class="mt-2">
                    <div @assign-tags.window="init($event.detail)" x-data="tagSelect()" @click.away="clearSearch()" @keydown.escape="clearSearch(); @this.task_tags = JSON.stringify(tags)">
                        <div class="relative" @keydown.enter.prevent="addTag(textInput); @this.task_tags = JSON.stringify(tags)">
                            <input x-model="textInput" x-ref="textInput" @input="search($event.target.value); " class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter some tags">
                            <div :class="[open ? 'block' : 'hidden']">
                                <div class="absolute z-40 left-0 mt-2 w-full">
                                    <div class="py-1 text-sm bg-white rounded shadow-lg border border-gray-300">
                                        <a @click.prevent="addTag(textInput); @this.task_tags = JSON.stringify(tags)" class="block py-1 px-5 cursor-pointer hover:bg-indigo-600 hover:text-white">Add tag "<span class="font-semibold" x-text="textInput"></span>"</a>
                                    </div>
                                </div>
                            </div>
                            <!-- selections -->
                            <template x-for="(tag, index) in tags">
                                <div class="bg-indigo-100 inline-flex items-center text-sm rounded mt-2 mr-1">
                                    <span class="ml-2 mr-1 leading-relaxed truncate max-w-xs" x-text="tag"></span>
                                    <button @click.prevent="removeTag(index); @this.task_tags = JSON.stringify(tags)" class="w-6 h-8 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                                        <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Tags Input --}}

            {{-- Start Due Date Inputs --}}
            <div class="flex gap-4">
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select Start Date"
                        placeholder="Start date of the task"
                        wire:model="task_start_date"
                        without-time
                    />
                </div>
                <div class="flex-grow">
                    <x-datetime-picker
                        label="Select End Date"
                        placeholder="End date of the task"
                        wire:model="task_end_date"
                        without-time
                    />
                </div>
            </div>
            {{-- End Due Date Inputs --}}

            {{-- Start Description Textarea --}}
            <div>
                <x-textarea
                    wire:model="task_description"
                    label="Description"
                    placeholder="Unleash your thoughts and describe the task in vivid detail..."
                />
            </div>
            {{-- End Description Textarea --}}

        </div>
        {{-- End Form --}}

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                @if($editMode)
                    @can('update', $task)
                        <form method="post" wire:submit="saveTask">
                            <x-button type="submit" primary label="Save" />
                        </form>
                    @endcan
                @else
                    <form method="post" wire:submit="saveTask">
                        <x-button type="submit" primary label="Save" />
                    </form>
                @endif
            </div>
        </x-slot>
    </x-card>

    <div wire:ignore>
        @push('script')
            <script>
                function tagSelect() {
                    return {
                        open: false,
                        textInput: '',
                        tags: [],
                        init(eventTags) {

                            if(eventTags[0] == null) {
                                this.tags = [];
                                return;
                            }

                            this.tags = JSON.parse(eventTags);
                        },
                        addTag(tag) {
                            tag = tag.trim()
                            if (tag != "" && !this.hasTag(tag)) {
                                this.tags.push( tag )
                            }
                            this.clearSearch()
                            this.$refs.textInput.focus()
                            this.fireTagsUpdateEvent()
                        },
                        fireTagsUpdateEvent() {
                            this.$el.dispatchEvent(new CustomEvent('tags-update', {
                                detail: { tags: this.tags },
                                bubbles: true,
                            }));
                        },
                        hasTag(tag) {
                            var tag = this.tags.find(e => {
                                return e.toLowerCase() === tag.toLowerCase()
                            })
                            return tag != undefined
                        },
                        removeTag(index) {
                            this.tags.splice(index, 1)
                            this.fireTagsUpdateEvent()
                        },
                        search(q) {
                            if ( q.includes(",") ) {
                                q.split(",").forEach(function(val) {
                                    this.addTag(val)
                                }, this)
                            }
                            this.toggleSearch()
                        },
                        clearSearch() {
                            this.textInput = ''
                            this.toggleSearch()
                        },
                        toggleSearch() {
                            this.open = this.textInput != ''
                        }
                    }
                }
            </script>
        @endpush
    </div>

</x-modal>
