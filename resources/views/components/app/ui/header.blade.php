{{ html()->element('header')->class('h-14 min-h-14 w-full border-b border-primary-800/80')->children([
    html()->element('nav')->class('container h-full flex flex-nowrap items-stretch justify-between gap-x-3 overflow-x-auto sm:gap-x-12')->children([
        html()->div()->class('inline-flex w-2/4 items-center justify-start')->child(
            html()->a()->link('home')->child(
                html()->span('Foxws')->class('font-semibold text-2xl text-primary-400 hover:text-primary-300')
            )
        ),

        // html()->div()->class('*:inline-flex *:h-full *:gap-1 *:py-0.5 *:text-sm *:font-medium *:line-clamp inline-flex w-2/4 items-center justify-end gap-x-3')->children([
        //     html()->a()->link('search.index')->attribute('aria-label', __('Search'))->child(
        //         html()->icon()->svg('heroicon-o-magnifying-glass', 'size-6 text-inherit'),
        //     ),

        //     html()->a()->link('account.notifications')->attribute('aria-label', __('Notifications'))->child(
        //         html()->icon()->svg('heroicon-o-bell', 'size-6 text-inherit'),
        //     ),
        // ]),
    ])
]) }}
