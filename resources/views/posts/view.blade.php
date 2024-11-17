{{ html()->div()->class('page')->open() }}
    {{ html()->div()->class('page-content')->open() }}
        {{ html()->div()->class('prose-h1:mb-0 prose-h1:text-3xl')->children([
            html()->element('h1')->text($post->name),

            html()->element('dl')->class('not-prose divider text-secondary-400')
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
        ]) }}

        <x-markdown>
            @includeIf($post->blade_view)
        </x-markdown>
    {{ html()->div()->close() }}

    {{ html()->div()->class('pt-6 navbar gap-3 border-t border-primary-700/80')->children([
        html()->div()->class('navbar-center flex-wrap gap-3')
            ->childIf($this->previous, html()->a()->class('btn btn-outlined')->link('posts.view', ['project' => $post->project, 'post' => $this->previous ?? $post])->children([
                html()->icon()->svg('heroicon-o-chevron-left', 'size-3.5'),
                html()->span()->text($this->previous?->name)
            ]))
            ->childIf($this->next, html()->a()->class('btn btn-outlined')->link('posts.view', ['project' => $post->project, 'post' => $this->next ?? $post])->children([
                html()->icon()->svg('heroicon-o-chevron-right', 'size-3.5'),
                html()->span()->text($this->next?->name)
        ])),
    ]) }}
{{ html()->div()->close() }}
