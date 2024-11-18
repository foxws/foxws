{{ html()->div()->class('page')->open() }}
    {{ html()->div()->class('page-content')->open() }}
        {{ html()->div()->class('prose-h1:mb-0 prose-h1:text-3xl')->children([
            html()->element('h1')->text($project->name),
            html()->element('dl')->class('not-prose divider text-secondary-400')
                ->childrenIf($project->type, [
                    html()->element('dt')->text('Type')->class('sr-only'),
                    html()->element('dd')->text($project->type?->label()),
                ])
                ->childrenIf($project->github, [
                    html()->element('dt')->text('Github')->class('sr-only'),
                    html()->element('dd')->child(html()->a()->href($project->github)->text('Source')),
                ])
        ]) }}

        <x-markdown>{!! $project->content !!}</x-markdown>

        {{ html()->element('h4')->text('Documentation') }}

        {{ html()->element('table')->class('table-auto')->children([
            html()->element('thead')->child(
                html()->element('tr')->children([
                    html()->element('th')->text('Subject'),
                    html()->element('th')->text('Last Updated'),
                ]),
            ),

            html()->element('tbody')->children($this->items, fn ($item) => html()
                ->element('tr')
                ->children([
                    html()->element('td')->child(
                        html()->a()->link('posts.view', $item)->text($item->name),
                    ),

                    html()->element('td')->text($item->date_updated),
                ]),
            ),
        ]) }}
    {{ html()->div()->close() }}
{{ html()->div()->close() }}
