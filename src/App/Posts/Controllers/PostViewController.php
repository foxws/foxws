<?php

namespace App\Posts\Controllers;

use App\Posts\Concerns\WithPost;
use Domain\Posts\Models\Post;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PostViewController extends Page
{
    use WithPost;

    public function render(): View
    {
        return view('posts.view');
    }

    public function getTitle(): string
    {
        return (string) $this->post->name;
    }

    #[Computed]
    public function prevPost(): ?Post
    {
        return Post::query()
            ->where('project_id', $this->post->project_id)
            ->where('order_column', max($this->post->order_column - 1, 0))
            ->first();
    }

    #[Computed]
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
            ...$this->getPostListeners(),
        ];
    }
}
