<?php

declare(strict_types=1);

namespace Domain\Posts\Actions;

use Illuminate\Support\Collection;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContentInterface;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class GetMarkdownPosts
{
    public function execute(): Collection
    {
        return collect($this->getMarkdowns())
            ->map(fn (SplFileInfo $file) => $this->parseMarkdown($file))
            ->filter(fn (RenderedContentInterface $html) => $html instanceof RenderedContentWithFrontMatter)
            ->sortBy([
                fn (RenderedContentWithFrontMatter $html) => data_get($html->getFrontMatter(), 'weight'),
                fn (RenderedContentWithFrontMatter $html) => data_get($html->getFrontMatter(), 'date'),
            ]);
    }

    protected function parseMarkdown(SplFileInfo $file): RenderedContentInterface
    {
        return app(MarkdownRenderer::class)->convertToHtml($file->getContents());
    }

    protected function getMarkdowns(): Finder
    {
        return (new Finder())
            ->files()
            ->depth('< 5')
            ->in(config('settings.markdown_path', resource_path('markdown')))
            ->name('*.md')
            ->sortByName();
    }
}
