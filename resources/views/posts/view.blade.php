<x-wireui::layout-container>
    <main class="flex flex-col py-6 gap-y-6 prose prose-invert max-w-none prose-headings:mb-0 prose-h1:font-semibold prose-h1:text-3xl prose-h2:first:mt-0 prose-thead:text-left prose-a:text-primary-300 prose-table:text-base prose-pre:bg-primary-600/30">
        <section>
            <h1>{{ $this->getTitle() }}</h1>
            <p class="m-0 inline-flex items-center gap-1.5 text-primary-400">
                @if ($post->project)
                    <x-wireui::actions-link
                        href="{{ route('projects.view', $post->project) }}"
                        class="no-underline !text-primary-400"
                    >
                        {{ $post->project->name }} -
                    </x-wireui::actions-link>
                @endif

                @if ($post->category)
                    {{ $post->category }} -
                @endif

                {{ $post->date_updated }}
            </p>
        </section>

        <x-markdown theme="github-dark">
            @includeIf($this->post->blade_view)
        </x-markdown>

        <hr class="my-0">

        <nav class="flex flex-wrap justify-between items-center">
            <div>
                @if ($this->prev_post)
                    <x-wireui::actions-link
                        href="{{ route('posts.view', $this->prev_post) }}"
                        class="gap-2 h-9 px-2.5 border border-primary-600 no-underline"
                    >
                        <x-heroicon-o-chevron-left class="size-3" />
                        {{ $this->prev_post->name }}
                    </x-wireui::actions-link>
                @endif
            </div>

            <div>
                @if ($this->next_post)
                    <x-wireui::actions-link
                        href="{{ route('posts.view', $this->next_post) }}"
                        class="gap-2 h-9 px-2.5 border border-primary-600 no-underline"
                    >
                        {{ $this->next_post->name }}
                        <x-heroicon-o-chevron-right class="size-3" />
                    </x-wireui::actions-link>
                @endif
            </div>
        </nav>
    </main>
</x-wireui::layout-container>
