<x-wireui::layout-container>
    <main class="flex flex-col py-6 gap-y-6 prose prose-invert max-w-none prose-headings:my-0 prose-h1:font-semibold prose-h1:text-3xl prose-p:my-1 prose-thead:text-left prose-a:text-primary-300">
        <section>
            <h1>{{ __('Our Projects') }}</h1>
            <table class="table-auto">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Links') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($this->projects as $project)
                    <tr>
                        <td>
                            <x-wireui::actions-link href="{{ route('projects.view', $project) }}">
                                {{ $project->name }}
                            </x-wireui::actions-link>
                        </td>
                        <td>{{ $project->summary }}</td>
                        <td class="inline-flex gap-3">
                        @if ($project->github)
                            <a href="{{ $project->github }}" target="_blank">
                                GitHub
                            </a>
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        @foreach ($this->projects as $project)
            <a id="{{ $project->getKey() }}"></a>
            <section>
                <h2>{{ $project->name }}</h2>
                <p>{{ $project->description }}</p>
                @if ($project->github)
                    <p>
                        {{ __('Source code is available at') }} <a href="{{ $project->github }}" target="_blank">GitHub</a>.
                    </p>
                @endif

                <p class="flex gap-3 py-1">
                    <x-wireui::actions-link
                        href="{{ route('projects.view', $project) }}"
                        class="gap-2 h-9 px-2.5 border border-primary-600 no-underline"
                    >
                        <x-heroicon-o-document class="size-5" />
                        {{ __('Documentation') }}
                    </x-wireui::actions-link>
                </p>
            </section>
        @endforeach
    </main>
</x-wireui::layout-container>
