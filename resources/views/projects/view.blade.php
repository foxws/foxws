@use('Domain\Posts\Models\Post')

{{ html()->div()->class('page')->children([
    html()->div()->class('page-content')->children([
        html()->div()->children([
            html()->element('h1')->text($this->project->name),
            html()->element('p')->text($this->project->description),
            html()->element('blockquote')->text('Note: The documentation always follows the latest release.'),
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
