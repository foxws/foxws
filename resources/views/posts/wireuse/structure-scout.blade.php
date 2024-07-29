## Description

If you have a lot of Blade or Livewire components, it may take a lot of work to register them manually, especially in multi-tenancy applications.

Our component scout can help with this. It is supported by [spatie/php-structure-discoverer](https://github.com/spatie/php-structure-discoverer) package, which also offers benefits such as caching.

We recommend using a domain-driven-design (DDD) pattern, such as `src/App/Posts/Components/Card.php`.<br>
Spatie offers an excellent in dept course for this: <https://spatie.be/products/laravel-beyond-crud>

## Usage

### Blade Components

To discover Blade components, create and register a [service provider](https://laravel.com/docs/11.x/providers):

```bash
php artisan make:provider ViewServiceProvider
```

@verbatim
```php
use Foxws\WireUse\Scout\ComponentScout;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerComponents();
    }

    protected function registerComponents(): static
    {
        ComponentScout::create(app_path('Web'), 'App\\')->register();

        return $this;
    }
}
```
@endverbatim

To call a registered Blade component:

@verbatim
```php
<x-web.posts.card :$item />
```
@endverbatim

### Livewire Components

To discover Livewire components, create and register a [service provider](https://laravel.com/docs/11.x/providers):

```bash
php artisan make:provider LivewireServiceProvider
```

```php
use Foxws\WireUse\Scout\LivewireScout;
use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerComponents();
    }

    protected function registerComponents(): static
    {
        LivewireScout::create(app_path('Web'), 'App\\')->register();

        return $this;
    }
}
```

To call a registered Livewire component:

@verbatim
```php
<livewire:web.posts.tags />
```
@endverbatim
