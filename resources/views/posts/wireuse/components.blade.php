## Description

WireUse offers a set of traits that you can include on your [Component](https://laravel.com/docs/11.x/blade#components) and [Livewire components](https://livewire.laravel.com/docs/components).

### Classes

In order not to include every trait separately each time, we have made a selection based on the type of component.

The `Foxws\WireUse\Views\Page` class can be used for Livewire controllers:

@verbatim
```php
use Foxws\WireUse\Views\Components\Page;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PostViewController extends Page
{
    use WithPost;

    protected function authorizeAccess(): void
    {
        $this->canView($this->getPost());
    }
}
```
@endverbatim

The `Foxws\WireUse\Views\Components` class can be used for Livewire components:

@verbatim
```php
use Foxws\WireUse\Views\Components\Component;
use Illuminate\Contracts\Support\Htmlable;

class Button extends Component
{
    public function __construct(
        public string|Htmlable|null $label = '',
    ) {
    }
}
```
@endverbatim

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

This trait only works with [ralphjsmit/laravel-seo](https://github.com/ralphjsmit/laravel-seo), and is included with WireUse.

@verbatim
```php
use Foxws\WireUse\Views\Concerns\WithSeo;
use Livewire\Component;

class PostViewController extends Component
{
    use WithSeo;

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
