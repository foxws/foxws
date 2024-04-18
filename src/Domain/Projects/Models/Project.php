<?php

namespace Domain\Projects\Models;

use Domain\Posts\Models\Post;
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

    public function getRows(): array
    {
        return [
            [
                'id' => 'wireuse',
                'name' => __('WireUse'),
                'summary' => __('Collection of essential Livewire utilities.'),
                'description' => __('Collection of essential Livewire utilities.'),
                'github' => 'https://github.com/foxws/wireuse',
                'created_at' => Carbon::make('2024-04-04 18:30'),
                'updated_at' => Carbon::make('2024-04-04 18:30'),
            ],
            [
                'id' => 'wireui',
                'name' => __('WireUi'),
                'summary' => __('Collection of essential Livewire components and views.'),
                'description' => __('Collection of essential Livewire components and views.'),
                'github' => 'https://github.com/foxws/wireui',
                'created_at' => Carbon::make('2024-04-04 18:30'),
                'updated_at' => Carbon::make('2024-04-04 18:30'),
            ],
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
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

    protected function sushiShouldCache(): bool
    {
        return true;
    }
}
