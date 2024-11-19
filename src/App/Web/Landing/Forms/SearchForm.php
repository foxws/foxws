<?php

declare(strict_types=1);

namespace App\Web\Landing\Forms;

use Foxws\WireUse\Forms\Support\Form;
use Livewire\Attributes\Validate;

class SearchForm extends Form
{
    protected static bool $store = true;

    protected static bool $recoverable = true;

    #[Validate('nullable|string|max:255')]
    public string $query = '';

    public function getQuery(): string
    {
        return str($this->get('query', ''))
            ->title()
            ->squish()
            ->value();
    }
}
