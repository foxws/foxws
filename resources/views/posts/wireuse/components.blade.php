## Usage

WireUse offers a set of traits that you can include on your [Component](https://laravel.com/docs/11.x/blade#components) and [Livewire components](https://livewire.laravel.com/docs/components).

### Page

The `Foxws\WireUse\Views\Support\Page` class can be used for Livewire controllers:

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

    protected function getTitle(): ?string
    {
        return (string) $this->post->name;
    }

    protected function getDescription(): ?string
    {
        return (string) $this->post->summary;
    }
}
```

The `Page` class extends the `Livewire\Component` class and includes the following traits:

- `WithAuthentication` - Can be used to retieve the current user.
- `WithAuthorization` - Can be used to authorize the current user.
- `WithHash` - Can be used to generate a hash for the given component.
- `WithSeo` - Can be used to generate SEO contents.

### Component

The `Foxws\WireUse\Views\Support\Component` class may useful for Blade components:

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

The `Component` class extends the `Illuminate\View\Component` class and includes the following traits:

- `WithHash`
- `WithLivewire`
- `Illuminate/Support/Traits/Conditionable`
- `Illuminate/Support/Traits/Tappable`

### Concerns

A selection of some traits that are available:

#### WithLivewire

Located at `Foxws\WireUse\Views\Concerns\WithLivewire`, this trait can be used to call Livewire attributes.

The following methods are available:

- `wireKey()` - Value of `id` or `wire:model` attribute - or generate with `uuid()`.
- `wireModel()` - Value of first `wire:model` attribute.
- `uuid()` - Generates an UUID, mainly used as fallback.

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

#### WithHash

Located at `Foxws\WireUse\Views\Concerns\WithHash`, this trait can be used to generate a hash for the given component, and be used as a wire key.

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

#### WithSeo

Located at `Foxws\WireUse\Views\Concerns\WithSeo`, this trait can be to handle SEO in your Laravel application.

This trait only works with [ralphjsmit/laravel-seo](https://github.com/ralphjsmit/laravel-seo), and is a package requirement of WireUse.

```php
use Foxws\WireUse\Views\Concerns\WithSeo;
use Livewire\Component;

class PostViewController extends Component
{
    use WithSeo;

    public Post $post;

    public function mount(): void
    {
        // $this->seo()->setTitle('Title using mount hook');
        // $this->seo()->setDescription('Description using mount hook');
    }

    public function getTitle(): ?string
    {
        return (string) $this->post->name;
    }

    public function getDescription(): ?string
    {
        return (string) $this->post->description;
    }
}
```
