<?php

declare(strict_types=1);

namespace Domain\Users\Actions;

use Domain\Users\Models\User;

class RegenerateUser
{
    public array $actions = [
        //
    ];

    public function execute(User $model): void
    {
        foreach ($this->actions as $action) {
            app($action)->execute($model);
        }
    }
}
