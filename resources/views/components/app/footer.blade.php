<footer class="flex flex-col items-center gap-y-1.5 py-10">
    <div class="text-sm text-primary-400">
        <span>{{ config('app.name') }}</span>
        <span> • </span>
        <span>© 2024</span>
        <span> • </span>
        <x-wireui::actions-link
            target="_blank"
            href="https://github.com/foxws/foxws"
        >
            Source
        </x-wireui::actions-link>
    </div>
</footer>
