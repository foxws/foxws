<?php

namespace Domain\Posts\Models;

use Domain\Posts\Actions\GetMarkdownPosts;
use Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getRows(): array
    {
        $posts = app(GetMarkdownPosts::class)->execute();

        dd($posts);

        return [];
    }

    public function bladeView(): Attribute
    {
        return Attribute::make(
            get: fn () => implode('.', ['posts', $this->project_id, $this->id])
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

    protected function sushiShouldCache(): bool
    {
        return true;
    }
}
