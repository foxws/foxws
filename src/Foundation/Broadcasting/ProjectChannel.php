<?php

declare(strict_types=1);

namespace Foundation\Broadcasting;

use Domain\Projects\Models\Project;
use Domain\Users\Models\User;

class ProjectChannel
{
    public function join(User $user, Project $model): bool
    {
        return true;
    }
}
