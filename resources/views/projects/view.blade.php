<x-wireuse::layout.container>
    <main class="flex flex-col py-6 gap-y-6 prose prose-invert max-w-none prose-headings:mb-0 prose-h1:font-semibold prose-h1:text-3xl prose-h2:first:mt-0 prose-p:my-1 prose-thead:text-left prose-a:text-primary-300 prose-table:text-base prose-pre:bg-primary-600/30">
        <section>
            <h1>{{ $this->getTitle() }}</h1>
            <p>{{ $this->getDescription() }}</p>
            @if ($project->github)
                <p>
                    {{ __('Source code is available at') }} <a href="{{ $project->github }}" target="_blank">GitHub</a>.
                </p>
            @endif

            @includeIf("projects.{$project->getKey()}.notice")

            @if ($this->posts->isNotEmpty())
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="text-transparent">{{ __('Name') }}</th>
                        <th>{{ __('Last updated') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($this->posts as $post)
                    <tr>
                        <td>
                            <a
                                href="{{ $post->route_view }}"
                                wire:navigate
                            >
                                {{ $post->name }}
                            </a>
                        </td>
                        <td>{{ $post->date_updated }}
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </section>
    </main>
</x-wireuse::layout.container>
