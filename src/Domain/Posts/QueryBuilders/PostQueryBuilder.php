<?php

declare(strict_types=1);

namespace Domain\Posts\QueryBuilders;

use Domain\Posts\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    public function findBySlugOrFail(string $slug): Post
    {
        return $this->where('slug', $slug)->firstOrFail();
    }
}
