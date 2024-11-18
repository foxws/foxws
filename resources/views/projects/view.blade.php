{{ html()->div()->class('page')->open() }}
    {{ html()->div()->class('page-content')->open() }}
        {{ html()->div()->class('prose-h1:mb-0 prose-h1:text-3xl')->children([
            html()->element('h1')->text($project->name),
            html()->element('dl')->class('not-prose divider text-secondary-400')
                // ->childrenIf($project->type, [
                //     html()->element('dt')->text('Project')->class('sr-only'),
                //     html()->element('dd')->child(html()->a()->link('projects.view', $post->project)->text($post->project->name)),
                // ])
                ->children([
                    html()->element('dt')->text('Updated')->class('sr-only'),
                    html()->element('dd')->text("Updated {$project->diff_updated}"),
                ])
        ]) }}

        <x-markdown>{!! $project->content !!}</x-markdown>

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
