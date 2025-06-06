{{ html()->element('header')->class('h-14 min-h-14 w-full border-b border-primary-800/80')->children([
    html()->element('nav')->class('navbar container h-full')->children([
        html()->div()->class('navbar-start')->child(
            html()->a()->link('home')->child(
                html()->span('Foxws')->class('font-semibold text-2xl text-primary-400 hover:text-primary-300')
            )
        ),

        html()->div()->class('navbar-end gap-x-6 *:text-base ')->children([
            html()->a()->href('https://github.com/foxws/')->child(
                html()->span('Github')->class('text-primary-300 hover:text-primary-300')
            ),

            html()->a()->link('search')->attribute('aria-label', __('Search'))->child(
                html()->icon()->svg('heroicon-o-magnifying-glass', 'size-6 text-inherit'),
            ),
        ]),
    ])
]) }}
