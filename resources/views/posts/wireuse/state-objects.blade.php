## Description

State objects are based on states that you find, for example, in a VueJS Store.

This can be used to make your Livewire component more lightweight, and to separate code.<br>
It is also helpful to create a global state and use it in subcomponents (tabs, wizards, etc.).

## Installation

States are disabled by default, and can be enabled in `config/wireuse.php`:

```bash
php artisan vendor:publish --tag="wireuse-config"
```

```php
'features' => [
    \Foxws\WireUse\Support\Livewire\StateObjects\SupportStateObjects::class,
],
```

## Usage

Create a State class:

```php
namespace App\Posts\States;

use Foxws\WireUse\Support\Livewire\StateObjects\State;
use Livewire\Attributes\Locked;

class PostState extends State
{
    #[Locked]
    public ?string $id = null;

    public function tags(): array
    {
        return $this->getComponent()
            ->post
            ->tags
            ->pluck('name')
            ->toArray();
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

    public function mount(): void
    {
        $this->state->fill([
            'id' => $this->post->getRouteKey(),
        ]);
    }
}
```

You can call any state objects in your Blade components:

@verbatim
```php
<div class="container">
    <p>{{ $this->state->tags() }}></p>
    <p>{{ $this->state->id }}></p>
</div>
```
@endverbatim

The `Foxws\WireUse\States\Concerns\WithState` trait can be used to reactively inject a state object into a subcomponent.

@verbatim
```php
<livewire:post-edit-details :$state />
```
@endverbatim

@verbatim
```php
use Foxws\WireUse\States\Concerns\WithState;
use Livewire\Component;

/**
 * @property PostState $state
 */
class PostEditDetails extends Component
{
    use WithState;

    protected function getModel(): ?Post
    {
        return Post::find($this->state->id);
    }
}
```
@endverbatim

> Note: At the moment it only works if the parent variable is named or injected as `$state`.
