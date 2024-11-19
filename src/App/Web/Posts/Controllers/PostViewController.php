<?php

declare(strict_types=1);

namespace App\Web\Posts\Controllers;

use App\Web\Posts\Concerns\WithPost;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;

class PostViewController extends Page
{
    use WithPost;

    public function render(): View
    {
        return view('posts.view');
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
