@use('Spatie\SiteSearch\SearchResults\Hit')

{{ html()->div()->class('page')->children([
    html()->div()->class('page-content prose-h1:mb-0')->children([
        html()->div()->children([
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
        ]),

        html()
            ->element('main')
            ->attribute('wire:poll.900s')
            ->class('grid grid-cols-1 gap-4')
            ->children($this->items->hits, fn (Hit $item) => html()
                ->a()
                ->href($item->url)
                ->class('flex flex-nowrap gap-3 justify-between bg-primary-600/50 hover:bg-primary-600/70 py-2 px-4 rounded w-full no-underline')
                ->children([
                    html()->div()->children([
                        html()->element('h2')->text($item->title()),
                        html()->element('p')->class('not-prose')->text(strip_tags($item->highlightedSnippet())),
                    ]),

                    html()->div()->child(
                        html()->icon()->svg('heroicon-o-chevron-right', 'size-5')
                    ),
                ])
            )
    ]),
]) }}
