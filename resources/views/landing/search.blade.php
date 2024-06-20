<x-wireuse::layout.container>
    <main class="flex flex-col py-6 gap-y-6 prose prose-invert max-w-none prose-headings:my-0 prose-h1:mb-2 prose-h1:font-semibold prose-h1:text-3xl prose-p:my-1 prose-thead:text-left prose-a:text-primary-300">
        <section>
            <h1>{{ __('Search') }}</h1>

            <form class:layout="flex flex-col py-2 gap-y-2">
                <x-wireuse::layout.join class="flex-nowrap gap-x-4 rounded bg-primary-700/40 px-3">
                    <x-wireuse::forms.input
                        class="border-0 bg-transparent px-0 py-2.5"
                        type="search"
                        placeholder="{{ __('Search on article, term or creator') }}"
                        autocomplete
                        autofocus
                        wire:model.live.debounce.300ms="form.search"
                    />

                    @if ($this->form->filled('search'))
                        <x-wireuse::actions-button wire:click.prevent="$set('form.search', '')">
                            <x-heroicon-o-x-mark class="size-5" />
                        </x-wireuse::actions-button>
                    @endif
                </x-wireuse::layout.join>
            </form>
        </section>

        @if ($this->form->filled('search'))
        <section
            wire:poll.keep-alive.2400s
            class="flex flex-col gap-y-8 pt-4"
        >
            <div class="grid grow grid-cols-1 gap-3.5">
                @forelse ($this->results->hits as $item)
                    <a
                        href="{{ $item->url }}"
                        class="flex flex-nowrap gap-2.5 justify-between bg-primary-600/50 hover:bg-primary-600/70 py-2 px-4 rounded w-full no-underline"
                    >
                        <div class="flex flex-col">
                            <h4>{{ $item->title() }}</h4>
                            <p class="not-prose">
                                {{ strip_tags($item->highlightedSnippet()) }}
                            </p>
                        </div>

                        <x-wireuse::actions-button class:layer="block">
                            <x-heroicon-o-chevron-right class="size-5" />
                        </x-wireuse::actions-button>
                    </a>
                @empty
                    <div class="flex items-center justify-center p-2 text-primary-400">
                        {{ __('No results found') }}
                    </div>
                @endforelse
            </div>
        </section>
        @endif
    </main>
</x-wireuse::layout.container>
