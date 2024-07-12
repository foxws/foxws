## Installation

To register the provided Blade macros, create and register a [service provider](https://laravel.com/docs/11.x/providers):

@verbatim
```php
use Illuminate\Support\ServiceProvider;
use Foxws\WireUse\Support\Blade\Concerns\WithBladeMacros;

class ViewServiceProvider extends ServiceProvider
{
    use WithBladeMacros;

    public function boot()
    {
        $this->registerBladeMacros();
    }
}
```
@endverbatim

## Usage

The following macros are inspired by [twMerge](https://github.com/gehrisandro/tailwind-merge-laravel), and may be valuable for managing inline classes.

Take `button.blade.php` as an example:

@verbatim
```php
<button {{ $attributes
    ->cssClass([
        'layer' => 'inline-flex shrink-0 cursor-pointer select-none items-center',
        'disabled' => '!bg-gray-300 pointer-events-none opacity-50',
    ])
    ->classMerge([
        'layer',
        'disabled' => $attributes->has('disabled'),
    ])
    ->merge([
        'type' => 'button',
    ])
}}>
    {{ $slot }}
</button>
```
@endverbatim

With the `cssClass` helper you define all CSS classes that a component may have.
Our approach is to use `layer` or `base` as a bare minimum style, and then it can be influenced depending on the parameters given.

Calling `classMerge` merges the classes, possibly with a condition.<br>
But you can also call `classMerge()` without parameters, then all classes will be merged.

### Reuse classes

It is also possible to apply classes on other tags within the same component:


@verbatim
```php
<label {{ $attributes
    ->cssClass([
        'layer' => 'flex items-center cursor-pointer',
        'error' => 'text-red-500',
        'hint' => 'pt-1 text-red-500',
        'required' => 'px-1 text-primary-400',
    ])
    ->classMerge([
        'layer',
        'error' => filled($error) || $errors->has($wireKey()),
    ])
}}>
    {{ $slot }}

    @if ($required)
        <span class="{{ $attributes->classFor('required') }}">*</span>
    @endif

    @if ($hint)
        <p class="{{ $attributes->classFor('hint') }}">
            {{ $hint }}
        </p>
    @endif
</label>
```
@endverbatim

### Rendering component

To render the component:

@verbatim
```php
<x-button>Submit</x-button>
```
@endverbatim

To overrule classes:

@verbatim
```php
<x-button
    class:layer="block"
    class:disabled="!bg-purple-600 pointer-events-none opacity-50"
>
    Submit
</x-button>
```
@endverbatim

This is a very powerful way to reuse classes.
Combined with Tailwind, you could opt-in to drop `@apply` CSS rules.

