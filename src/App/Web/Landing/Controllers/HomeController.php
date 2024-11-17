<?php

declare(strict_types=1);

namespace App\Web\Landing\Controllers;

use Domain\Projects\Models\Project;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;

class HomeController extends Page
{
    public function render(): View
    {
        return view('landing.index');
    }

    #[Computed(cache: false)]
    protected function items(): Collection
    {
        return Project::all();
    }

    protected function getTitle(): string
    {
        return __('Home');
    }

    protected function getDescription(): string
    {
        return __('Projects, documentation, and news.');
    }
}
