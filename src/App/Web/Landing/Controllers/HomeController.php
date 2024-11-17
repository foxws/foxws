<?php

namespace App\Landing\Controllers;

use Domain\Projects\Models\Project;
use Foxws\WireUse\Actions\Support\Action;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class HomeController extends Page
{
    public function mount(): void
    {
        $this->seo()->setTitle(__('Home'));
        $this->seo()->setDescription(__('Our projects, documentation, and more.'));
    }

    public function render(): View
    {
        return view('landing.index')->with([
            'items' => $this->items(),
        ]);
    }

    protected function items(): Collection
    {
        return Project::all()
            ->map(fn (Project $item) => fluent([
                ...$item->getAttributes(),
                ...[
                    'action' => $this->viewAction($item),
                    'view' => $this->documentAction($item),
                ],
            ]));
    }

    protected function documentAction(Project $model): Action
    {
        return Action::make($model->getKey())
            ->label(__('Documentation'))
            ->icon('heroicon-o-document')
            ->route('projects.view', $model);
    }

    protected function viewAction(Project $model): Action
    {
        return Action::make($model->getKey())
            ->label($model->name)
            ->route('projects.view', $model);
    }
}
