<?php

namespace Foundation\Providers;

use Domain\Media\Models\Media;
use Domain\Posts\Models\Post;
use Domain\Projects\Models\Project;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Spatie\PrefixedIds\PrefixedIds;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureUrlScheme();
        $this->configureStrictness();
        $this->configureMorphMap();
        $this->configurePrefixedIds();
        $this->configureJsonResource();
    }

    protected function configureUrlScheme(): void
    {
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');
    }

    protected function configureStrictness(): void
    {
        Model::shouldBeStrict(! $this->app->environment('production'));
    }

    protected function configureMorphMap(): void
    {
        Relation::enforceMorphMap([
            'media' => Media::class,
            'post' => Post::class,
            'project' => Project::class,
            'user' => User::class,
        ]);
    }

    protected function configurePrefixedIds(): void
    {
        PrefixedIds::generateUniqueIdUsing(fn () => Str::random(10));

        PrefixedIds::registerModels([
            'user-' => User::class,
        ]);
    }

    protected function configureJsonResource(): void
    {
        JsonResource::withoutWrapping();
    }
}
