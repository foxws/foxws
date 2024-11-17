<?php

declare(strict_types=1);

namespace App\Web\Posts\Controllers;

use App\Web\Posts\Concerns\WithPost;
use Domain\Posts\Models\Post;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Computed;

class PostViewController extends Page
{
    use WithPost;

    public function render(): View
    {
        return view('posts.view');
    }

    #[Computed()]
    public function previous(): ?Post
    {
        return Post::query()
            ->where('project_id', $this->post->project_id)
            ->where('order_column', max($this->post->order_column - 1, 0))
            ->first();
    }

    #[Computed()]
    public function next(): ?Post
    {
        return Post::query()
            ->where('project_id', $this->post->project_id)
            ->where('order_column', $this->post->order_column + 1)
            ->first();
    }

    protected function getTitle(): string
    {
        return (string) $this->post->name;
    }

    public function getListeners(): array
    {
        return [
            ...$this->getPostListeners(),
        ];
    }
}
