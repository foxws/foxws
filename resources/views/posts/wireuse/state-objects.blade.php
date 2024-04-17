## Description

State objects are based on states that you find, for example, in a VueJS Store.

This can be used to make your Livewire component more lightweight, and to separate code.

> Note: State Objects are still experimental and may change.

## Usage

Create a State class:

```php
namespace App\Posts\States;

use Foxws\WireUse\Support\Livewire\StateObjects\State;

class PostState extends State
{
    public string $foo = 'bar';

    public function tags(): array
    {
        return $this->getComponent()->post->tags->pluck('name')->toArray();
    }
}
```

Create a Livewire Component:

```php
use Foxws\WireUse\Views\Support\Page;
use App\Posts\States\PostState;

class PostViewController extends Page
{
    public Post $post;

    public PostState $state;
}
```

You can call state objects in your Blade components:

@verbatim
```php
<div class="container">
    <h1>{{ $this->post->title }}</h1>
    <p>{{ $this->state->tags() }}></p>
    <p>{{ $this->state->foo }}></p>
</div>
```
@endverbatim
