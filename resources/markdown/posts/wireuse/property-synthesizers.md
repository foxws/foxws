---
title: Property Synthesizers
project: wireuse
order: 1
tags:
  - eloquent
  - collection
---

## Introduction

By default the dehydrated value of Laravel Model properties sent over Livewire might look something like this:

```json
{
    "type": "model",
    "class": "user",
    "key": 1,
    "relationships": []
}
```

The provided property synthesizers try to hide the model IDs, by forcing the model [route-key](https://laravel.com/docs/11.x/routing#customizing-the-key):

```json
{
    "type": "model",
    "class": "user",
    "key": "91e0df48-a06e-4376-b273-73d97de96352", // notice the UUID
    "relationships": []
}
```

## Usage

To use the property synthesizers, create a custom [Service Provider](https://laravel.com/docs/11.x/providers#writing-service-providers):

```bash
php artisan make:provider LivewireServiceProvider
```

> Tip: It is recommended to also apply [Enforcing Morph Maps](https://livewire.laravel.com/docs/properties#properties-expose-system-information-to-the-browser).

Adjust the `boot` method:

```php
use Foxws\WireUse\Support\Livewire\LegacyModels\EloquentCollectionSynth;
use Foxws\WireUse\Support\Livewire\LegacyModels\EloquentModelSynth;
use Foxws\WireUse\Support\Livewire\Models\CollectionSynth;
use Foxws\WireUse\Support\Livewire\Models\ModelSynth;
use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureSynthesizers();
    }

    protected function configureSynthesizers(): void
    {
        app('livewire')->propertySynthesizer([
            ModelSynth::class,
            CollectionSynth::class,
            EloquentModelSynth::class,
            EloquentCollectionSynth::class,
        ]);
    }
}
```

> Warning: This will replace parts of the Livewire model binding property synthesizers. Be careful and test the adjustments!

If you need to use model keys in your views and collections, it is recommended to use `$model->getRouteKey()` instead of `$model->getKey()`/`$model->id`.
