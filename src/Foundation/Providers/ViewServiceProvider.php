<?php

namespace Foundation\Providers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Foxws\WireUse\Facades\WireUse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureComponents();
        $this->configurePaginators();
        $this->configureSeo();
    }

    protected function configureSeo(): void
    {
        SEOMeta::setTitleDefault(config('app.name'));
        SEOMeta::setRobots('index,follow');
    }

    protected function configureComponents(): void
    {
        WireUse::registerComponents(
            path: app_path(),
            prefix: 'app'
        );
    }

    protected function configurePaginators(): void
    {
        Paginator::defaultView('pagination.default');
        Paginator::defaultSimpleView('pagination.simple');
    }
}
