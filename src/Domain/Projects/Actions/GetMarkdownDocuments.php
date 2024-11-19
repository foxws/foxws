<?php

declare(strict_types=1);

namespace Domain\Projects\Actions;

use Illuminate\Support\Collection;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContentInterface;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class GetMarkdownDocuments
{
    public function execute(): Collection
    {
        return collect($this->getDocuments())
            ->map(fn (SplFileInfo $file) => $this->parseMarkdown($file))
            ->filter(fn (RenderedContentInterface $html) => $html instanceof RenderedContentWithFrontMatter);
    }

    protected function parseMarkdown(SplFileInfo $file): RenderedContentInterface
    {
        return app(MarkdownRenderer::class)->convertToHtml($file->getContents());
    }

    protected function getDocuments(): Finder
    {
        return (new Finder)
            ->files()
            ->depth('< 5')
            ->in(config('settings.markdown.projects_path', resource_path('markdown/projects')))
            ->name('*.md')
            ->sortByName();
    }
}
