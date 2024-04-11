## Description

WireUse offers traits that you can include on your [Component](https://laravel.com/docs/11.x/blade#components).

### WithLivewire

Located at `Foxws\WireUse\Views\Concerns\WithLivewire`, this trait can be used to call Livewire attributes.

The following methods are available:

- `wireKey()` - Value of `id` or `wire:model` attribute. Or generate with `uuid()`.
- `wireModel()` - Value of first `wire:model` attribute.
- `uuid()` - Generates `uuid()`, mainly used as fallback.

This is an example of using it with a Livewire `wire:key`:

@verbatim
```php
<article {{ $attributes
    ->merge([
        'wire:key' => $wireKey(),
    ])
}}>
    {{ $slot }}
</article>
```
@endverbatim

### WithHash

Located at `Foxws\WireUse\Views\Concerns\WithHash`, this trait can be used to generate a hash for the given component, and be used as a key.

The following methods are available:

- `hash()` - The hash will be generated using the class itself.
- `classHash()` - The hash will be generated using the class name.

Always be careful with `hash` methods, as collisions can occur.

This is an example of using it with a Livewire `wire:key`:

@verbatim
```php
<article {{ $attributes
    ->merge([
        'wire:key' => $hash(),
    ])
}}>
    {{ $slot }}
</article>
```
@endverbatim

### WithSeo

Located at `Foxws\WireUse\Views\Concerns\WithSeo`, this trait can be to handle SEO in your Laravel application.

This trait only works with [ralphjsmit/laravel-seo](https://github.com/ralphjsmit/laravel-seo).

@verbatim
```php
use Livewire\Component;

class PostViewController extends Component
{
    public Post $post;

    public function mount(): void
    {
        // $this->seo()->setTitle('using mount hook');
    }

    public function getTitle(): ?string
    {
        return $this->post->name;
    }

    public function getDescription(): ?string
    {
        return $this->post->description;
    }
}
```
@endverbatim

