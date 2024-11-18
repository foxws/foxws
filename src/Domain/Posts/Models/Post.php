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
use Illuminate\Support\Facades\Cache;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContent;
use Sushi\Sushi;

class Post extends Model
{
    use Sushi;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<int, string>
     */
    protected $with = [
        'project',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'project_id' => 'string',
            'name' => 'string',
            'content' => 'string',
            'summary' => 'string',
            'starts' => 'integer',
            'order' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function newEloquentBuilder($query): PostQueryBuilder
    {
        return new PostQueryBuilder($query);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getRows(): mixed
    {
        // TODO: testing remove this
        Cache::forget('posts');

        return Cache::remember('posts', now()->addMinutes(5),
            fn () => $this->getDocuments()->toArray()
        );
    }

    public function next(): Attribute
    {
        return Attribute::make(
            get: fn () => static::find($this->order + 1)
        )->shouldCache();
    }

    public function previous(): Attribute
    {
        return Attribute::make(
            get: fn () => static::find($this->order - 1)
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
        $collect = app(GetMarkdownDocuments::class)->execute();

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
                'order' => data_get($meta, 'order', 0),
                'starts' => $document->getStartLine(),
                'created_at' => data_get($meta, 'created', now()),
                'updated_at' => data_get($meta, 'updated', now()),
            ];
        })->values();
    }
}
