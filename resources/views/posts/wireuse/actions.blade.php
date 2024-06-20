## Description

Actions are very useful for links and buttons.<br>
You may also use it to create tabs, filters and trigger modals.

For example, you can add `->route('home')`, `->state('foo')`, `->iconActive('icon-svg')`, `->label(__('Name'))`, ..<br>
You can even add multiple actions into one action by using the `->add('sub-action')` method.

Please checkout the `Foxws\WireUse\Actions\Support\Action` class for all available methods and options.

## Usage

Create a Livewire component, for example a tab-component:

@verbatim
```php
use App\Livewire\Posts\Components\Edit\General;
use App\Livewire\Posts\Components\Edit\Assets;
use App\Livewire\Posts\States\PostState;
use Foxws\WireUse\Actions\Support\Action;
use Foxws\WireUse\Navigation\Concerns\WithTabs;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Url;

class PostEditController extends Page
{
    use WithTabs;

    public PostState $state;

    #[Url(as: 'tab', except: 'general', history: true)]
    public string $tab = 'general';

    public function render(): View
    {
        return view('livewire.pages.posts.edit')->with([
            'tabs' => $this->tabs(),
            'current' => $this->currentTab(),
        ]);
    }
    protected function authorizeAccess(): void
    {
        $this->canUpdate($this->post);
    }

    protected function tabs(): array
    {
        return [
            Action::make('general')
                ->label(__('General'))
                ->component(General::class),

            Action::make('assets')
                ->label(__('Assets'))
                ->component(Assets::class),
        ];
    }
}
```
@endverbatim

To use the actions in your `edit.blade.php` view:

@verbatim
```blade
<div>
    <x-wireuse::navigation.tabs wire:model.live="tab" :$tabs />

    @if ($current)
        <livewire:dynamic-component :is="$current->getComponent()" :key="$this->hash" :$state />
    @endif
</div>
```
@endverbatim
