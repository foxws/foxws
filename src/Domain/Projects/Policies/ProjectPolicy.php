<?php

namespace Domain\Projects\Policies;

use Domain\Projects\Models\Project;
use Domain\Users\Models\User;

class ProjectPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Project $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, Project $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, Project $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function restore(User $user, Project $model): bool
    {
        return $user->hasRole('super-admin');
    }

    public function forceDelete(User $user, Project $model): bool
    {
        return $user->hasRole('super-admin');
    }
}
