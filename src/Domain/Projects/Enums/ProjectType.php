<?php

declare(strict_types=1);

namespace Domain\Projects\Enums;

enum ProjectType: string
{
    case Package = 'package';
    case Personal = 'personal';

    public function label(): string
    {
        return match ($this) {
            self::Package => __('Package'),
            self::Personal => __('Personal'),
        };
    }
}
