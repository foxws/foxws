{{ html()->div()->class('page')->children([
    html()->div()->class('page-content prose-h1:text-3xl')->children([
        html()->div()->children([
            html()->element('h1')->text($post->name),

            html()->element('dl')->class('dl')
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
