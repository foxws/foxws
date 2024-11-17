@use('Domain\Posts\Models\Post')

{{ html()->div()->class('page')->children([
    html()->div()->class('page-content')->children([
        html()->div()->class('prose-h1:mb-0 prose-h1:text-3xl')->children([
            html()->element('h1')->text($project->name),
            html()->element('dl')->class('not-prose divider text-secondary-400')
                ->childrenIf($project->type, [
                    html()->element('dt')->text('Category')->class('sr-only'),
                    html()->element('dd')->text($project->type->label()),
                ]),

            html()->element('p')->text($project->description),
        ]),

        html()->element('table')->class('table-auto')->children([
            html()->element('thead')->child(
                html()->element('tr')->children([
                    html()->element('th')->text('Subject'),
                    html()->element('th')->text('Last Updated'),
                ]),
            ),

            html()->element('tbody')->children($this->items, fn (Post $item) => html()
                ->element('tr')
                ->children([
                    html()->element('td')->child(
                        html()->a()->link('posts.view', ['project' => $item->project, 'post' => $item])->text($item->name),
                    ),

                    html()->element('td')->text($item->date_updated),
                ]),
            ),
        ])
    ]),
]) }}
