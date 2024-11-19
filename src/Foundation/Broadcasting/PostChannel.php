<?php

declare(strict_types=1);

namespace Foundation\Broadcasting;

use Domain\Posts\Models\Post;
use Domain\Users\Models\User;

class PostChannel
{
    public function join(User $user, Post $model): bool
    {
        return true;
    }
}
