<?php

declare(strict_types=1);

namespace App\Web\Landing\Controllers;

use App\Web\Landing\Forms\SearchForm;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Spatie\SiteSearch\Search;
use Spatie\SiteSearch\SearchResults\SearchResults;

class SearchController extends Page
{
    public SearchForm $form;

    public function mount(): void
    {
        $this->form->restore();
    }

    public function render(): View
    {
        return view('landing.search');
    }

    public function updatedForm(): void
    {
        $this->submit();
    }

    #[Computed]
    public function results(): SearchResults
    {
        return Search::onIndex('foxws')
            ->query($this->form->getQuery() ?: '*')
            ->limit(5)
            ->get();
    }

    public function submit(): void
    {
        $this->form->submit();

        $this->refresh();
    }

    public function clear(): void
    {
        $this->form->forget();

        $this->form->clear();
    }

    public function refresh(): void
    {
        unset($this->items);

        $this->dispatch('$refresh');
    }

    protected function getTitle(): string
    {
        return __('Search');
    }

    protected function getDesciption(): string
    {
        return __('Search for articles, posts and projects.');
    }
}
