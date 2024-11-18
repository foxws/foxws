<?php

namespace Domain\Projects\Models;

use Domain\Posts\Models\Post;
use Domain\Projects\Actions\GetMarkdownDocuments;
use Domain\Projects\Enums\ProjectType;
use Domain\Projects\QueryBuilders\ProjectQueryBuilder;
use Foxws\ModelCache\Concerns\InteractsWithModelCache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContent;
use Sushi\Sushi;

class Project extends Model
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

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'content' => 'string',
            'summary' => 'string',
            'github' => 'string',
            'starts' => 'integer',
            'order' => 'integer',
            'type' => ProjectType::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function newEloquentBuilder($query): ProjectQueryBuilder
    {
        return new ProjectQueryBuilder($query);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getRows(): mixed
    {
        // TODO: increase cache time
        return Cache::remember('projects', now()->addSecond(1),
            fn () => $this->getDocuments()->toArray()
        );
    }

    public function dateCreated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::make($this->created_at)->toDateTimeString()
        )->shouldCache();
    }

    public function dateUpdated(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::make($this->updated_at)->toDateTimeString()
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

        return str($value('name') ?: $value('title'))->slug();
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
}
