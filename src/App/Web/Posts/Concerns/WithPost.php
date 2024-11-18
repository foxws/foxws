<?php

declare(strict_types=1);

namespace App\Web\Posts\Concerns;

use Domain\Posts\Models\Post;
use Livewire\Attributes\Locked;

trait WithPost
{
    #[Locked]
    public Post $post;

    public function bootWithPost(): void
    {
        $this->authorize('view', $this->post);
    }

    protected function getPostKey(): int
    {
        return $this->post->getKey();
    }

    protected function getPostId(): string
    {
        return $this->post->getRouteKey();
    }

    protected function refreshPost(): void
    {
        $this->post->refresh();

        $this->dispatch("post-updated.{$this->getPostId()}");
    }

    public function onPostDeleted(): void
    {
        $this->refreshPost();
    }

    public function onPostUpdated(): void
    {
        $this->refreshPost();
    }

    protected function getPostListeners(): array
    {
        if (! auth()->check()) {
            return [];
        }

        return [
            "echo-private:posts.{$this->getPostId()},.post.deleted" => 'onPostDeleted',
            "echo-private:posts.{$this->getPostId()},.post.updated" => 'onPostUpdated',
        ];
    }
}
