<x-wireuse::layout.container>
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
                @foreach ($items as $item)
                    <tr>
                        <td><x-wireuse::actions-link :action="$item->action" /></td>
                        <td>{{ $item->summary }}</td>
                        <td class="inline-flex gap-3">
                        @if ($item->github)
                            <a href="{{ $item->github }}" target="_blank">
                                GitHub
                            </a>
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        @foreach ($items as $item)
            <a id="{{ $item->id }}"></a>
            <section>
                <h2>{{ $item->name }}</h2>
                <p>{{ $item->description }}</p>
                @if ($item->github)
                    <p>
                        {{ __('Source code is available at') }} <a href="{{ $item->github }}" target="_blank">GitHub</a>.
                    </p>
                @endif

                <p class="flex gap-3 py-1">
                    <x-wireuse::actions-button :action="$item->view" />
                </p>
            </section>
        @endforeach
    </main>
</x-wireuse::layout.container>
