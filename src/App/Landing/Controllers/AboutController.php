<?php

namespace App\Landing\Controllers;

use Foxws\WireUse\Views\Support\Page;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class AboutController extends Page
{
    public function mount(): void
    {
        $this->seo()->setTitle(__('About'));
        $this->seo()->setDescription(__('About Foxws'));
    }

    public function render(): View
    {
        return view('landing.about');
    }
}
