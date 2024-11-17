{{ html()->element('footer')->class('flex gap-y-1.5 py-10')->children([
    html()->element('nav')->class('container flex items-center justify-center gap-1.5 *:text-secondary-400 *:py-0.5 *:text-sm')->children([
        html()->a()->link('home')->text('© 2024'),
        html()->span()->text('•'),
        html()->a()->href('https://github.com/foxws/foxws')->text('Source'),
    ])
]) }}
