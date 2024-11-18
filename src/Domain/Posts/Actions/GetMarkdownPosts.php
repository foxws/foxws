<?php

declare(strict_types=1);

namespace Domain\Posts\Actions;

use Illuminate\Support\Collection;
use League\CommonMark\Output\RenderedContentInterface;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class GetMarkdownPosts
{
    public function execute(): Collection
    {
        return collect($this->getMarkdowns()->getIterator())
            ->map(fn (SplFileInfo $file) => $this->parseMarkdown($file));
    }

    protected function parseMarkdown(SplFileInfo $file): RenderedContentInterface
    {
        return app(MarkdownRenderer::class)->convertToHtml($file->getContents());
    }

    protected function getMarkdowns(): Finder
    {
        return (new Finder())
            ->files()
            ->in(resource_path('markdown'))
            ->name('*.md')
            ->sortByName();
    }
}
