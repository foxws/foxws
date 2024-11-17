@use('Domain\Projects\Models\Project')

{{ html()->div()->class('container py-6')->children([
    html()->div()->class('prose')->children([
        html()->element('h1')->text('Projects'),

        html()->div()->class('project')->children($this->items, fn (Project $item) => html()
            ->div()
            ->class('project-item')
            ->children([
                html()->element('h2')->text($item->name),
                html()->p()->text($item->description),
            ])

        ),
    ]),
]) }}
