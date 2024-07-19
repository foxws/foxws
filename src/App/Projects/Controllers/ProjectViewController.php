<?php

namespace App\Projects\Controllers;

use App\Projects\Concerns\WithProject;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ProjectViewController extends Page
{
    use WithProject;

    public function render(): View
    {
        return view('projects.view');
    }

    public function getTitle(): string
    {
        return (string) $this->project->name;
    }

    public function getDescription(): string
    {
        return (string) $this->project->description;
    }

    #[Computed]
    public function posts(): Collection
    {
        return $this
            ->project
            ->posts()
            ->orderBy('order_column')
            ->orderBy('created_at')
            ->get();
    }

    public function getListeners(): array
    {
        return [
            // ...$this->getProjectListeners(),
        ];
    }
}
