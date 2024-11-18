<?php

namespace Domain\Posts\Models;

use Domain\Posts\Actions\GetMarkdownDocuments;
use Domain\Posts\QueryBuilders\PostQueryBuilder;
use Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContent;
use Sushi\Sushi;

class Post extends Model
{
    use Sushi;

    /**
     * @var array<int, string>
     */
    protected $with = [
        'project',
    ];

    public function newEloquentBuilder($query): PostQueryBuilder
    {
        return new PostQueryBuilder($query);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getRows(): array
    {
        return $this->getDocuments()->map(function (RenderedContentWithFrontMatter $html) {
            $document = $html->getDocument();
            $meta = $html->getFrontMatter();

            return [
                'slug' => $this->generateSlug($html),
                'project_id' => data_get($meta, 'project'),
                'name' => data_get($meta, 'title'),
                'starts' => $document->getStartLine(),
                'content' => $html->getContent(),
                'created_at' => data_get($meta, 'created', now()),
                'updated_at' => data_get($meta, 'updated', now()),
            ];
        })->values()->all();
    }

    public function next(): Attribute
    {
        return Attribute::make(
            get: fn () => static::find($this->id + 1)
        )->shouldCache();
    }

    public function previous(): Attribute
    {
        return Attribute::make(
            get: fn () => static::find($this->id - 1)
        )->shouldCache();
    }

    public function dateCreated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::make($this->created_at)->toDateString()
        )->shouldCache();
    }

    public function dateUpdated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::make($this->updated_at)->toDateString()
        )->shouldCache();
    }

    public function diffCreated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::make($this->created_at)->diffForHumans()
        )->shouldCache();
    }

    public function diffUpdated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::make($this->updated_at)->diffForHumans()
        )->shouldCache();
    }

    protected function generateSlug(RenderedContent $html): string
    {
        /** @var RenderedContentWithFrontMatter $html */
        $meta = $html->getFrontMatter();

        $value = fn (string $key) => data_get($meta, $key, '');

        return str("{$value('project')} {$value('title')}")->slug();
    }

    protected function getDocuments(): Collection
    {
        return app(GetMarkdownDocuments::class)->execute();
    }

    protected function sushiShouldCache(): bool
    {
        return true;
    }
}
