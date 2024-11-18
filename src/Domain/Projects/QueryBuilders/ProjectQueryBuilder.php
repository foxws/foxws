<?php

declare(strict_types=1);

namespace Domain\Projects\QueryBuilders;

use Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Builder;

class ProjectQueryBuilder extends Builder
{
    public function findBySlugOrFail(string $slug): Project
    {
        return $this->where('slug', $slug)->firstOrFail();
    }
}
