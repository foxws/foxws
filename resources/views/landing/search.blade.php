@php
    $cleanHighlight = fn (?string $value) => str($value ?? '')->markdown()->stripTags()->limit(180)->toString();
@endphp

@use('Spatie\SiteSearch\SearchResults\Hit')

{{ html()->div()->class('page')->open() }}
    {{ html()->div()->class('page-content prose-h1:mb-0 prose-h2:text-base prose-p:text-sm')->open() }}
        {{ html()->div()->children([
            html()->element('h1')->text('Search'),

            html()->wireForm($form, 'submit')->class('flex flex-col gap-y-3')->children([
                html()->div()
                    ->classIf(flash()->message, ['alert mt-6', flash()->class])
                    ->textIf(flash()->message, flash()->message),

                html()->div()->class('form-control')->children([
                    html()->text()->wireModel('form.query', 'live.debounce.300ms')->placeholder('Search for posts, projects or term')->class('input'),
                    html()->error('form.query'),
                ]),
            ]),
        ]) }}

        @if ($form->getQuery() && $this->items->hits->isNotEmpty())
            {{ html()
                ->element('main')
                ->attribute('wire:poll.900s')
                ->class('grid grid-cols-1 py-3 gap-4 max-w-none')
                ->children($this->items->hits, fn (Hit $item) => html()
                    ->a()
                    ->href($item->url)
                    ->class('flex flex-nowrap gap-3 justify-between bg-primary-600/50 hover:bg-primary-600/70 px-4 rounded-sm w-full no-underline')
                    ->children([
                        html()->div()->children([
                            html()->element('h2')->text($item->title()),
                            html()->element('p')->text($cleanHighlight($item->highlightedSnippet())),
                        ]),
                    ])
                )
            }}
        @elseif ($form->getQuery())
            {{ html()->div()->class('flex flex-col mt-3 bg-primary-600/50 hover:bg-primary-600/70 px-4 rounded-sm w-full no-underline')->children([
                html()->element('h2')->text('No results found'),
                html()->element('p')->text('Please try another search term.'),
            ]) }}
        @endif
    {{ html()->div()->close() }}
{{ html()->div()->close() }}
