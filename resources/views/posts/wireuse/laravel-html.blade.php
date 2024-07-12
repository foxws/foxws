## Description

The [laravel-html](https://spatie.be/docs/laravel-html/v3/introduction) package of Spatie helps you generate HTML using a clean, simple and easy to read API.
All elements can be dynamically generated and put together.

WireUse offers mixins to make the package compatible and more usable with Livewire.

## Installation

The Livewire mixins are enabled by default, but can be disabled individually in `config/wireuse.php`.

## Usage

The following example shows how to use the `wireKey` helper to generate a list of posts, e.g. `posts.blade.php`:

@verbatim
```php
{{ html()->div()->class('grid grid-cols-1 gap-3')->open() }}
    @foreach ($this->posts as $post)
        {{ html()->div()->wireKey($post->getRouteKey())->open() }}
            <livewire:app::post-item :$post :key="$post->getRouteKey()" />
        {{ html()->div()->close() }}
    @endforeach
{{ html()->div()->close() }}
```
@endverbatim

The following example shows how to use the `wireForm` helper to generate a form, e.g. `edit.blade.php`:

@verbatim
```php
{{ html()->wireForm($form, action: 'submit')->class('flex flex-col gap-y-6')->children([
    html()->div()
        ->classIf(flash()->message, 'form-message')
        ->textIf(flash()->message, flash()->message),

    html()->div()->class('form-control')->children([
        html()->label('Name', 'form.name')->class('label'),
        html()->text()->wireModel('form.name')->placeholder('Name')->class('input'),
        html()->validate('form.name'),
    ]),
]) }}
```
@endverbatim

Please checkout all mixins individually, because they are not all documented here.
