<?php

namespace App\Landing\Controllers;

use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Spatie\SiteSearch\Search;

#[Layout('components.layouts.app')]
class SearchController extends Page
{
    public function mount(): void
    {
        // $this->seo()->setTitle(__('About'));
        // $this->seo()->setDescription(__('About Foxws'));

        $results = Search::onIndex('foxws')
            ->query('wireui')
            ->get();

        dd($results);
    }

    public function render(): View
    {
        return view('landing.about');
    }
}
