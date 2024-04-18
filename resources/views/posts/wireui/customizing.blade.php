## Strategies

WireUi can be customized in different ways, choose the method that best suits your situation.

### Use WireUi as a reference

You don't necessarily have to use WireUi.
For example, you can use our components as a reference for building your own components with [WireUse](/projects/wireuse).

### Overrule styles

WireUi uses [inline classes](/posts/wireuse/css-classes) as much as possible, for example, adjusting the base style with `class:layer`.

To publish and manage the views yourself:

```php
php artisan vendor:publish --tag="wireui-views"
```

> Note: Published views should be synced if the component also changes.

### Extending components

It is also possible to extend WireUi components:

```php
namespace App\Shared\Components\Actions;

use Foxws\WireUi\Actions\Components\Link as BaseLink;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class Link extends BaseLink
{
    public function render(): View
    {
        return view('app::actions.link');
    }
}
```

With this method you can inject/override or add your own methods.

> Tip: Use [structure-discovery](/posts/wireuse/structure-scout) automatically register components
