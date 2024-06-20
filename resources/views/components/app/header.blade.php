<header class="border-b border-primary-800">
    <x-wireuse::layout.container>
        <x-wireuse::navigation.navbar class:padding="py-3">
            <x-slot:start>
                <a
                    href="/"
                    wire:navigate
                    class="inline-flex text-2xl text-primary-400 font-semibold hover:text-primary-300"
                >
                    Foxws
                </a>
            </x-slot:start>

            <x-slot:end>
                <x-wireuse::layout.join class="gap-x-6 text-lg text-primary-300 hover:text-primary-100">
                    <a
                        href="{{ route('about') }}"
                        wire:navigate
                        aria-label="{{ __('About') }}"
                        title="{{ __('About') }}"
                    >
                        {{ __('About' )}}
                    </a>

                    <a
                        href="{{ route('search') }}"
                        wire:navigate
                        aria-label="{{ __('Search') }}"
                        title="{{ __('Search') }}"
                    >
                        <x-heroicon-m-magnifying-glass class="size-5" />
                    </a>
                </x-wireuse::layout.join>
            </x-slot:end>
        </x-wireuse::navigation.navbar>
    </x-wireuse::layout.container>
</header>
