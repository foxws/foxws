<?php

namespace Foundation\Broadcasting;

use Domain\Projects\Models\Project;
use Domain\Users\Models\User;

class PostChannel
{
    public function join(User $user, Project $model): bool
    {
        return true;
    }
}
