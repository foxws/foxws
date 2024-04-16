<?php

namespace App\Landing\Controllers;

use Domain\Projects\Models\Project;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class HomeController extends Page
{
    public function mount(): void
    {
        $this->seo()->setTitle(__('Home'));
        $this->seo()->setDescription(__('Home'));
    }

    public function render(): View
    {
        return view('landing.index');
    }

    #[Computed]
    public function projects(): Collection
    {
        return Project::all();
    }
}
