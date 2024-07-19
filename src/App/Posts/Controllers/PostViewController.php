<?php

namespace App\Posts\Controllers;

use App\Posts\Concerns\WithPost;
use Domain\Posts\Models\Post;
use Foxws\WireUse\Actions\Support\Action;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PostViewController extends Page
{
    use WithPost;

    public function render(): View
    {
        return view('posts.view')->with([
            'previous' => $this->previous(),
            'next' => $this->next(),
        ]);
    }

    public function getTitle(): string
    {
        return (string) $this->post->name;
    }

    protected function previous(): ?Action
    {
        $model = $this->previousPost();

        if (! $model) {
            return null;
        }

        return Action::make('next')
            ->icon('heroicon-o-chevron-left')
            ->label($model->name)
            ->url($model->route_view)
            ->componentAttributes([
                'class' => 'gap-2 h-9 px-2.5 border border-primary-600 no-underline',
                'class:icon' => 'size-3',
            ]);
    }

    protected function next(): ?Action
    {
        $model = $this->nextPost();

        if (! $model) {
            return null;
        }

        return Action::make('next')
            ->icon('heroicon-o-chevron-right')
            ->label($model->name)
            ->url($model->route_view)
            ->componentAttributes([
                'class' => 'gap-2 h-9 px-2.5 border border-primary-600 no-underline',
                'class:icon' => 'size-3',
            ]);
    }

    protected function previousPost(): ?Post
    {
        return Post::query()
            ->where('project_id', $this->post->project_id)
            ->where('order_column', max($this->post->order_column - 1, 0))
            ->first();
    }

    public function nextPost(): ?Post
    {
        return Post::query()
            ->where('project_id', $this->post->project_id)
            ->where('order_column', $this->post->order_column + 1)
            ->first();
    }

    public function getListeners(): array
    {
        return [
            // ...$this->getPostListeners(),
        ];
    }
}
