@use('Domain\Projects\Models\Project')

{{ html()->div()->class('container py-6')->children([
    html()->div()->class('prose')->children([
        html()->element('h1')->text('Current Projects'),
        html()->element('p')->text('The following projects will receive updates and are documented:'),

        html()->element('table')->class('table-auto')->children([
            html()->element('thead')->child(
                html()->element('tr')->children([
                    html()->element('th')->text('Name'),
                    html()->element('th')->text('Description'),
                ]),
            ),

            html()->element('tbody')->children($this->items, fn (Project $item) => html()
                ->element('tr')
                ->children([
                    html()->element('td')->child(
                        html()->element('a')
                            // ->href(route('projects.show', $item))
                            ->text($item->name),
                    ),

                    html()->element('td')->text($item->summary),
                ]),
        ),
        ]),
    ]),
]) }}
