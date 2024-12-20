<?php

declare(strict_types=1);

namespace App\Web\Projects\Controllers;

use App\Web\Projects\Concerns\WithProject;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;

class ProjectViewController extends Page
{
    use WithProject;

    public function render(): View
    {
        return view('projects.view');
    }

    #[Computed(cache: false)]
    public function items(): Collection
    {
        return $this
            ->project
            ->posts()
            ->ordered()
            ->get();
    }

    protected function getTitle(): string
    {
        return (string) $this->project->name;
    }

    protected function getDescription(): string
    {
        return (string) $this->project->summary;
    }

    public function getListeners(): array
    {
        return [
            ...$this->getProjectListeners(),
        ];
    }
}
