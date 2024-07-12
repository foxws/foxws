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
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureComponents();
    }

    protected function configureComponents(): void
    {
        WireUse::registerComponents(
            path: app_path(),
            prefix: 'app'
        );
    }
}
```
@endverbatim

To call a registered Blade component:

@verbatim
```php
<x-app::posts-card :$item />
```
@endverbatim

### Livewire Components

To discover Livewire components, create and register a [service provider](https://laravel.com/docs/11.x/providers):

```bash
php artisan make:provider LivewireServiceProvider
```

```php
use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureComponents();
    }

    protected function configureComponents(): void
    {
        WireUse::registerLivewireComponents(
            path: app_path(),
            prefix: 'app'
        );
    }
}
```

To call a registered Livewire component:

@verbatim
```php
<livewire:app::posts-tags />
```
@endverbatim
