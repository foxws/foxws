<?php

namespace App\Landing\Controllers;

use App\Landing\Forms\SearchForm;
use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Spatie\SiteSearch\Search;
use Spatie\SiteSearch\SearchResults\SearchResults;

#[Layout('components.layouts.app')]
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

    public function updated(): void
    {
        $this->submit();
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

    #[Computed]
    public function results(): SearchResults
    {
        return Search::onIndex('foxws')
            ->query($this->form->getQuery() ?: '*')
            ->limit(5)
            ->get();
    }

    public function getTitle(): string
    {
        return __('Search');
    }

    public function getDescription(): string
    {
        return __('Search for articles, posts and projects.');
    }
}
