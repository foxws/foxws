<?php

declare(strict_types=1);

namespace Domain\Projects\Models;

use Domain\Posts\Models\Post;
use Domain\Projects\Actions\GetMarkdownDocuments;
use Domain\Projects\Enums\ProjectType;
use Domain\Projects\QueryBuilders\ProjectQueryBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
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
        return Cache::remember('projects', config('settings.cache_duration', 60 * 60),
            fn () => app(GetMarkdownDocuments::class)->execute()->toArray()
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
}
