<header class="border-b border-primary-800">
    <x-wireui::layout-container>
        <x-wireui::navigation-navbar class:padding="py-3">
            <x-slot:start>
                <x-wireui::actions-link
                    href="/"
                    class:layer="inline-flex text-2xl text-primary-400 font-semibold hover:text-primary-300"
                    class:active="text-inherit"
                >
                    Foxws
                </x-wireui::actions-link>
            </x-slot:start>

            <x-slot:end>
                <x-wireui::layout-join class="gap-x-6 text-lg text-primary-300 hover:text-primary-100">
                    <x-wireui::actions-link
                        href="{{ route('about') }}"
                        aria-label="{{ __('About') }}"
                        title="{{ __('About') }}"
                    >
                        {{ __('About' )}}
                    </x-wireui::actions-link>
                </x-wireui::layout-join>
            </x-slot:end>
        </x-wireui::navigation-navbar>
    </x-wireui::layout-container>
</header>
