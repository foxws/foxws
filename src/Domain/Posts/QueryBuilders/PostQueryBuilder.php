<?php

declare(strict_types=1);

namespace Domain\Posts\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    public function ordered(): self
    {
        return $this
            ->orderBy('order')
            ->orderBy('created_at');
    }
}
