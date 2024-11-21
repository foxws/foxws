<?php

declare(strict_types=1);

namespace Domain\Posts\Actions;

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
                'project_id' => data_get($meta, 'project'),
                'name' => data_get($meta, 'title'),
                'summary' => data_get($meta, 'summary'),
                'content' => $item->getContent(),
                'type' => data_get($meta, 'type'),
                'tags' => implode(', ', data_get($meta, 'tags', [])),
                'order' => data_get($meta, 'order', 0),
                'starts' => $document->getStartLine(),
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

        return str("{$value('project')} {$value('title')}")->slug()->value();
    }
}
