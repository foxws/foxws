<?php

declare(strict_types=1);

namespace Domain\Projects\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ProjectQueryBuilder extends Builder
{
    public function ordered(): self
    {
        return $this
            ->orderBy('order')
            ->orderBy('created_at');
    }
}
