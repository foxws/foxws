<?php

namespace App\Landing\Forms;

use Foxws\WireUse\Forms\Support\Form;
use Livewire\Attributes\Validate;

class SearchForm extends Form
{
    protected static bool $store = true;

    #[Validate('nullable|string|max:255')]
    public string $search = '';

    public function getQuery(): string
    {
        return str($this->get('search', ''))
            ->headline()
            ->squish()
            ->value();
    }
}
