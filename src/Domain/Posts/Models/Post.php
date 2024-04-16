<?php

namespace Domain\Posts\Models;

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

    public function getRows(): array
    {
        return [
            // WireUse
            [
                'id' => 'introduction-to-wireuse',
                'project_id' => 'wireuse',
                'name' => __('Introduction to WireUse'),
                'category' => __('Getting Started'),
                'order_column' => 1,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-04 14:30'),
            ],
            [
                'id' => 'installing-wireuse',
                'project_id' => 'wireuse',
                'name' => __('Installing WireUse'),
                'category' => __('Getting Started'),
                'order_column' => 2,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-04 14:30'),
            ],
            [
                'id' => 'property-synthesizers',
                'project_id' => 'wireuse',
                'name' => __('Property Synthesizers'),
                'category' => __('Properties'),
                'order_column' => 3,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-04 14:30'),
            ],
            [
                'id' => 'components',
                'project_id' => 'wireuse',
                'name' => __('Components'),
                'category' => __('Components'),
                'order_column' => 4,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-11 17:30'),
            ],
            [
                'id' => 'css-classes',
                'project_id' => 'wireuse',
                'name' => __('CSS Classes'),
                'category' => __('Components'),
                'order_column' => 5,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-11 17:30'),
            ],
            [
                'id' => 'forms',
                'project_id' => 'wireuse',
                'name' => __('Forms'),
                'category' => __('Forms'),
                'order_column' => 6,
                'created_at' => Carbon::make('2024-04-15 14:30'),
                'updated_at' => Carbon::make('2024-04-15 15:30'),
            ],
            // WireUi
            [
                'id' => 'introduction-to-wireui',
                'project_id' => 'wireui',
                'name' => __('Introduction to WireUi'),
                'category' => __('Getting Started'),
                'order_column' => 1,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-04 14:30'),
            ],
            [
                'id' => 'installing-wireui',
                'project_id' => 'wireui',
                'name' => __('Installing WireUi'),
                'category' => __('Getting Started'),
                'order_column' => 2,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-04 14:30'),
            ],
            [
                'id' => 'usage',
                'project_id' => 'wireui',
                'name' => __('Using WireUi'),
                'category' => __('Getting Started'),
                'order_column' => 3,
                'created_at' => Carbon::make('2024-04-04 14:30'),
                'updated_at' => Carbon::make('2024-04-04 14:30'),
            ],
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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
