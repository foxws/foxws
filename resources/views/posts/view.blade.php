{{ html()->div()->class('page')->children([
    html()->div()->class('page-content')->children([
        html()->div()->class('prose-h1:mb-0 prose-h1:text-3xl')->children([
            html()->element('h1')->text($post->name),

            html()->element('dl')->class('not-prose divider')
                ->childrenIf($post->project, [
                    html()->element('dt')->text('Project')->class('sr-only'),
                    html()->element('dd')->child(html()->a()->link('projects.view', $post->project)->text($post->project->name)),
                ])
                ->childrenIf($post->category, [
                    html()->element('dt')->text('Category')->class('sr-only'),
                    html()->element('dd')->text($post->category),
                ])
                ->children([
                    html()->element('dt')->text('Updated')->class('sr-only'),
                    html()->element('dd')->text($post->diff_updated),
                ])
        ]),
    ])
]) }}
