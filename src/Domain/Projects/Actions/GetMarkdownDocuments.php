<?php

declare(strict_types=1);

namespace Domain\Projects\Actions;

use Illuminate\Support\Collection;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContent;

class GetMarkdownDocuments
{
    public function execute(): Collection
    {
        $collect = app(FindMarkdownDocuments::class)->execute();

        return $collect->map(function (RenderedContentWithFrontMatter $item) {
            $document = $item->getDocument();
            $meta = $item->getFrontMatter();

            return [
                'id' => $this->generateSlug($item),
                'name' => data_get($meta, 'title'),
                'summary' => data_get($meta, 'summary'),
                'content' => $item->getContent(),
                'github' => data_get($meta, 'github'),
                'type' => data_get($meta, 'type'),
                'starts' => $document->getStartLine(),
                'order' => data_get($meta, 'order', 0),
                'created_at' => data_get($meta, 'created', now()),
                'updated_at' => data_get($meta, 'updated', now()),
            ];
        })->values();
    }

    protected function getDocuments(): Collection
    {
        $collect = app(GetMarkdownDocuments::class)->execute();

        return $collect->map(function (RenderedContentWithFrontMatter $item) {
            $document = $item->getDocument();
            $meta = $item->getFrontMatter();

            return [
                'id' => $this->generateSlug($item),
                'name' => data_get($meta, 'title'),
                'summary' => data_get($meta, 'summary'),
                'content' => $item->getContent(),
                'github' => data_get($meta, 'github'),
                'type' => data_get($meta, 'type'),
                'starts' => $document->getStartLine(),
                'order' => data_get($meta, 'order', 0),
                'created_at' => data_get($meta, 'created', now()),
                'updated_at' => data_get($meta, 'updated', now()),
            ];
        })->values();
    }

    protected function generateSlug(RenderedContent $html): string
    {
        /** @var RenderedContentWithFrontMatter $html */
        $meta = $html->getFrontMatter();

        $value = fn (string $key) => data_get($meta, $key, '');

        return str($value('name') ?: $value('title'))->slug()->value();
    }
}
