---
title: Laravel Algos
summary: Create algorithms (algos) for your Laravel application.
type: package
order: 1
github: https://github.com/foxws/laravel-algos
tags:
  - laravel
  - algorithms
  - support
---

## What is Laravel Algos?

This package can be used to create algorithms (algos) for your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require foxws/laravel-algos
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="algos-config"
```

## Usage

Generate an `Algo` class (you may also use `php artisan make:algo MyAlgo`):

```php
use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GenerateUserFeed extends Algo
{
    protected ?User $user = null;

    public function handle(): Result
    {
        $hash = $this->generateUniqueId();

        cache()->set(
            $this->generateUniqueId(),
            ['ids' => (array) $this->getCollection()],
            now()->addMinutes(10),
        );

        return $this
            ->success('Feed generated successfully')
            ->with('hash', $hash);
    }

    public function model(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    protected function getCollection(): Collection
    {
        return Post::query()
            ->select('id')
            ->where('user_id', $this->user->getKey())
            ->inRandomOrder()
            ->take(5)
            ->get();
    }

    protected function generateUniqueId(): string
    {
        return Str::ulid();
    }
}
```

To run the algorithm:

```php
$algo = GenerateUserFeed::make()->model($user)->run();

// $algo->status; // success, failed, skipped
// $algo->message; // reason
// $algo->meta; // array of metadata
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

- [francoism90](https://github.com/foxws)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
