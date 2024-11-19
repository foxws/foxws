<?php

declare(strict_types=1);

namespace Domain\Posts\Models;

use Domain\Posts\Actions\GetMarkdownDocuments;
use Domain\Posts\QueryBuilders\PostQueryBuilder;
use Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
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
        return Cache::remember('posts', config('settings.cache_duration', 60 * 60),
            fn () => app(GetMarkdownDocuments::class)->execute()->toArray()
        );
    }

    public function next(): Attribute
    {
        return Attribute::make(
            get: fn () => static::firstWhere('order', $this->order + 1)
        )->shouldCache();
    }

    public function previous(): Attribute
    {
        return Attribute::make(
            get: fn () => static::firstWhere('order', $this->order - 1)
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
}
