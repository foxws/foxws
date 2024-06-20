<x-wireuse::layout.container>
    <main class="flex flex-col py-6 gap-y-6 prose prose-invert max-w-none prose-headings:mb-0 prose-h1:font-semibold prose-h1:text-3xl prose-h2:my-2 prose-h2:first:mt-0 prose-thead:text-left prose-a:text-primary-300 prose-table:text-base prose-pre:bg-primary-600/30">
        <section>
            <h1>{{ $this->getTitle() }}</h1>
            <p class="m-0 inline-flex items-center gap-1.5 text-primary-400">
                @if ($post->project)
                    <a
                        href="{{ route('projects.view', $post->project) }}"
                        wire:navigate
                        class="no-underline !text-primary-400"
                    >
                        {{ $post->project->name }} -
                    </a>
                @endif

                @if ($post->category)
                    {{ $post->category }} -
                @endif

                {{ $post->date_updated }}
            </p>
        </section>

        <x-markdown>
            @includeIf($this->post->blade_view)
        </x-markdown>

        <hr class="my-0">

        <nav class="flex flex-wrap justify-between items-center gap-3">
            <div>
                @if ($previous)
                    <x-wireuse::actions-link :button="true" :action="$previous" />
                @endif
            </div>

            <div>
                @if ($next)
                    <x-wireuse::actions-link :button="true" :action="$next" />
                @endif
            </div>
        </nav>
    </main>
</x-wireuse::layout.container>
