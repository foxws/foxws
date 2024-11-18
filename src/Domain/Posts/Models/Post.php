<?php

namespace Domain\Posts\Models;

use Domain\Posts\Actions\GetMarkdownPosts;
use Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use League\CommonMark\Extension\FrontMatter\Input\MarkdownInputWithFrontMatter;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use Sushi\Sushi;

class Post extends Model
{
    use Sushi;

    /**
     * @var array<int, string>
     */
    protected $with = [
        // 'project',
    ];

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
                'project_id' => data_get($meta, 'project'),
                'title' => data_get($meta, 'title'),
                'starts' => $document->getStartLine(),
                'content' => $html->getContent(),
                'created_at' => data_get($meta, 'created', now()),
                'updated_at' => data_get($meta, 'updated', now()),
            ];
        })->values()->all();
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

    protected function getDocuments(): Collection
    {
        return app(GetMarkdownPosts::class)->execute();
    }

    protected function sushiShouldCache(): bool
    {
        return true;
    }
}
