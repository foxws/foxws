@use('Domain\Projects\Models\Project')

{{ html()->div()->class('page')->children([
    html()->div()->class('page-content prose-h1:mb-0')->children([
        html()->div()->children([
            html()->element('h1')->text('Search'),

            html()->wireForm($form, 'submit')->class('flex flex-col gap-y-3')->children([
                html()->div()
                    ->classIf(flash()->message, ['alert mt-6', flash()->class])
                    ->textIf(flash()->message, flash()->message),

                html()->div()->class('form-control')->children([
                    html()->text()->wireModel('form.query')->placeholder('Search for posts, projects or term')->class('input'),
                    html()->error('form.query'),
                ]),
            ]),
        ]),

        html()
            ->element('main')
            ->attribute('wire:poll.900s')
            ->class('grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4')
            ->children($this->items->hits, fn ($item) => html()
                ->div()
                ->text($item->title())
            )
    ]),
]) }}
