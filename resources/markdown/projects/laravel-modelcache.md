---
title: Laravel Model Cache
summary: Cache helpers for Laravel Eloquent models.
type: package
order: 2
github: https://github.com/foxws/laravel-modelcache
tags:
  - laravel
  - caching
  - eloquent
---

This package does not cache models, it gives you helpers to manage the Laravel Cache using a model instance. By default, logged in users will each have their own separate cache prefix.

## Installation

You can install the package via composer:

```bash
composer require foxws/laravel-modelcache
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="modelcache-config"
```

## Usage

Implement the `Foxws\ModelCache\Concerns\InteractsWithModelCache` trait to your Eloquent models:

```php
use Foxws\ModelCache\Concerns\InteractsWithModelCache;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use InteractsWithModelCache;
}
```

### Model instances

To set a cache model value:

```php
Video::first()->modelCache('currentTime', 20);
Video::first()->modelCache('randomSeed', 20, now()->addDay()); // cache for one day
```

To retrieve a cached model value:

```php
Video::first()->modelCached('currentTime');
Video::first()->modelCached('randomSeed', $default); // with fallback
```

To forget a cached model value:

```php
Video::first()->modelCacheForget('currentTime');
Video::first()->modelCacheForget('randomSeed');
```

### Model class caching

To set a model class cache value:

```php
Video::modelClassCache('randomSeed', 0.1);
Video::modelClassCache('randomSeed', 0.1, now()->addDay()); // cache for one day
```

To retrieve a model class cached value:

```php
Video::modelClassCached('randomSeed');
Video::modelClassCached('randomSeed', $default);
```

To forget a model class cached value:

```php
Video::modelClassCacheForget('randomSeed');
```

### Creating a custom cache profile

To determine which values should be cached, and for how long, a cache profile class is used. The default class that handles these questions is `Foxws\ModelCache\CacheProfiles\CacheAllSuccessful`.

You can create your own cache profile class by implementing the  `Foxws\ModelCache\CacheProfile\CacheProfile`, and overruling the `cache_profile` in `config/modelcache.php`.

It is also possible to overrule the cache prefix using the model instance. For this create a method named `cacheNameSuffix` on the model instance:

```php
use Foxws\ModelCache\Concerns\InteractsWithModelCache;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use InteractsWithModelCache;

    /**
     * @doc When using a overule, it doesn't create a separated cache by default for authenticated users.
     */
    protected function cacheNameSuffix(string $key): string
    {
        return "{$key}:my-modelcache-prefix";
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

This package is entirely based on the [space/laravel-responsecache](https://github.com/spatie/laravel-responsecache/) package.

Please consider to sponsor Spatie, such as purchasing their excellent courses. :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
