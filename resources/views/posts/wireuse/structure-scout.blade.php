## Description

If you have a lot of Blade or Livewire components, it can be a lot of work to register them manually, especially in multi-tenancy applications.

Our component scout can help with this. It is supported by [spatie/php-structure-discoverer](https://github.com/spatie/php-structure-discoverer) package, which also offers benefits such as caching.

## Usage

### Blade Components

To discover Blade components, create a custom service provider:

```bash
php artisan make:provider ViewServiceProvider
```

Adjust the `boot` method:

```php
use Foxws\WireUse\Facades\WireUse;

public function boot(): void
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
```

To call a registered Blade component:

@verbatim
```php
<x-app::posts-card :$item />
```
@endverbatim

### Livewire Components

To discover Livewire components, create a custom service provider:

```bash
php artisan make:provider LivewireServiceProvider
```

Adjust the `boot` method:

```php
use Foxws\WireUse\Facades\WireUse;

public function boot(): void
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
```

To call a registered Livewire component:

@verbatim
```php
<livewire:app::posts-tags />
```
@endverbatim

## Tips

We recommend using a domain-driven-design (DDD) pattern, such as `src/App/Posts/Components/Card.php`.<br>
Spatie offers a course for this: <https://spatie.be/products/laravel-beyond-crud>
