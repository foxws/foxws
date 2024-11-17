<?php

namespace App\Projects\Concerns;

use Domain\Projects\Models\Project;
use Livewire\Attributes\Locked;

trait WithProject
{
    #[Locked]
    public Project $project;

    public function bootWithProject(): void
    {
        $this->authorize('view', $this->project);
    }

    protected function getProjectKey(): int
    {
        return $this->project->getKey();
    }

    protected function getProjectId(): string
    {
        return $this->project->getRouteKey();
    }

    protected function refreshProject(): void
    {
        $this->project->refresh();

        $this->dispatch("project-updated.{$this->getProjectId()}");
    }

    public function onProjectDeleted(): void
    {
        $this->refreshProject();
    }

    public function onProjectUpdated(): void
    {
        $this->refreshProject();
    }

    protected function getProjectListeners(): array
    {
        return [
            "echo-private:projects.{$this->getProjectId()},.project.deleted" => 'onProjectDeleted',
            "echo-private:projects.{$this->getProjectId()},.project.updated" => 'onProjectUpdated',
        ];
    }
}
