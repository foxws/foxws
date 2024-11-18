<?php

declare(strict_types=1);

namespace Domain\Posts\Policies;

use Domain\Posts\Models\Post;
use Domain\Users\Models\User;

class PostPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, Post $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, Post $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function restore(User $user, Post $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function forceDelete(User $user, Post $model): bool
    {
        return $user->hasRole('super-admin');
    }
}
