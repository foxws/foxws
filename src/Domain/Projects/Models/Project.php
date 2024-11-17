<?php

namespace Domain\Projects\Models;

use Domain\Posts\Models\Post;
use Domain\Projects\Enums\ProjectType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
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
            'type' => ProjectType::class,
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getRows(): array
    {
        return [
            [
                'id' => 'wireuse',
                'name' => __('WireUse'),
                'description' => __('Collection of useful Livewire utilities.'),
                'github' => 'https://github.com/foxws/wireuse',
                'type' => ProjectType::Package,
                'created_at' => Carbon::make('2024-04-04 18:30'),
                'updated_at' => Carbon::make('2024-04-04 18:30'),
            ],
            [
                'id' => 'laravel-algos',
                'name' => __('Laravel Algos'),
                'description' => __('Create algorithms (algos) for your Laravel application.'),
                'github' => 'https://github.com/foxws/laravel-algos',
                'type' => ProjectType::Package,
                'created_at' => Carbon::make('2024-04-04 18:30'),
                'updated_at' => Carbon::make('2024-04-04 18:30'),
            ],
            [
                'id' => ' laravel-modelcache',
                'name' => __('Laravel Model Cache'),
                'description' => __('Cache helpers for Laravel Eloquent models.'),
                'github' => 'https://github.com/foxws/laravel-modelcache',
                'type' => ProjectType::Package,
                'created_at' => Carbon::make('2024-04-04 18:30'),
                'updated_at' => Carbon::make('2024-04-04 18:30'),
            ],
            [
                'id' => 'hub',
                'name' => __('Hub'),
                'description' => __('A personal project that offers a video-on-demand (VOD) platform.'),
                'github' => 'https://github.com/francoism90/hub',
                'type' => ProjectType::Personal,
                'created_at' => Carbon::make('2024-04-04 18:30'),
                'updated_at' => Carbon::make('2024-04-04 18:30'),
            ],
        ];
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

    protected function sushiShouldCache(): bool
    {
        return true;
    }
}
