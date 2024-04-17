## Usage

WireUse offers a set of traits that you can include on your [Component](https://laravel.com/docs/11.x/blade#components) and [Livewire components](https://livewire.laravel.com/docs/components).

In order not to include every trait separately each time, we have made a selection based on the type of component.

The `Foxws\WireUse\Views\Support\Page` class can be used for Livewire controllers:

@verbatim
```php
use Foxws\WireUse\Views\Support\Page;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PostViewController extends Page
{
    public Post $post;

    protected function authorizeAccess(): void
    {
        $this->canView($this->post);
    }
}
```
@endverbatim

The `Foxws\WireUse\Views\Support\Component` class can be used for Blade components:

@verbatim
```php
use Foxws\WireUse\Views\Support\Component;
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

## Concerns

The following traits are included in the stated component classes, but can also be used individually.

### WithLivewire

Located at `Foxws\WireUse\Views\Concerns\WithLivewire`, this trait can be used to call Livewire attributes.

The following methods are available:

- `wireKey()` - Value of `id` or `wire:model` attribute. Or generate with `uuid()`.
- `wireModel()` - Value of first `wire:model` attribute.
- `uuid()` - Generates `uuid()`, mainly used as fallback.

This is an example of using it with a Livewire [wire:key](https://livewire.laravel.com/docs/troubleshooting#adding-wirekey):

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

> Note: Always be careful with `hash` methods, as collisions may occur.

This is an example of using it with a Livewire [wire:key](https://livewire.laravel.com/docs/troubleshooting#adding-wirekey):

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

    protected function authorizeAccess(): void
    {
        $this->canView($this->post);
    }

    public function mount(): void
    {
        // $this->seo()->setTitle('title using mount hook');
        // $this->seo()->setDescription('description using mount hook');
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
