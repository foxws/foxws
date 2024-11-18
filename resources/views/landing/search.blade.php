@use('Domain\Projects\Models\Project')

{{ html()->div()->class('page')->children([
    html()->div()->class('page-content')->children([
        html()->div()->children([
            html()->element('h1')->text('Current Projects'),
            html()->element('p')->text('The following projects are currently maintained and open source available:'),

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
                            html()->a()->link('projects.view', $item)->text($item->name),
                        ),

                        html()->element('td')->text($item->summary),
                    ]),
                ),
            ])
        ]),

        html()->div()->children([
            html()->element('h2')->text('About Foxws'),
            html()->element('p')->text('Foxws is a side-project to showcase some of my projects and offer documentation for them when needed.'),
        ]),

        html()->div()->children([
            html()->element('h2')->text('Get in touch'),
            html()->element('p')->html('If you would like to contribute or send me a message, you can do so on <a href="https://github.com/francoism90/">GitHub</a> or my <a href="https://www.linkedin.com/in/francoismenning/">LinkedIn</a>.'),
        ]),
    ]),
]) }}
