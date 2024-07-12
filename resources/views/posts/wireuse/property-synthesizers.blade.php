## Description

By default, Livewire shows the model location and model key in requests.<br>
Our property synthesizers try to prevent this.

By default the dehydrated value of model properties sent over Livewire might look something like this:

```json
{
    "type": "model",
    "class": "user",
    "key": 1,
    "relationships": []
}
```

Our property synthesizers try to hide the model IDs, by forcing the model [route-key](https://laravel.com/docs/11.x/routing#customizing-the-key):

```json
{
    "type": "model",
    "class": "user",
    "key": "91e0df48-a06e-4376-b273-73d97de96352", // notice the UUID
    "relationships": []
}
```

> Warning: This will replace parts of the Livewire model binding property synthesizers. Be careful and test the adjustments!

> Tip: It is recommended to also apply [Enforcing Morph Maps](https://livewire.laravel.com/docs/properties#properties-expose-system-information-to-the-browser).

## Usage

To use our property synthesizers, create a custom service provider:

```bash
php artisan make:provider LivewireServiceProvider
```

Adjust the `boot` method:

```php
use Foxws\WireUse\Support\Livewire\LegacyModels\EloquentCollectionSynth;
use Foxws\WireUse\Support\Livewire\LegacyModels\EloquentModelSynth;
use Foxws\WireUse\Support\Livewire\Models\CollectionSynth;
use Foxws\WireUse\Support\Livewire\Models\ModelSynth;

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
```

If you need to use model keys in your views, it is recommended to use `$model->getRouteKey()` instead of `$model->getKey()`/`$model->id`.
