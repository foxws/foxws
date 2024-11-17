<?php

declare(strict_types=1);

namespace Foundation\Providers;

use Domain\Media\Models\Media;
use Domain\Posts\Models\Post;
use Domain\Projects\Models\Project;
use Domain\Users\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureModelBinding();
        $this->configureRateLimiting();
    }

    protected function configureModelBinding(): void
    {
        Route::bind('media', fn (string $value) => Media::findByUuidOrFail($value));
        Route::bind('post', fn (string $value) => Post::findOrFail($value));
        Route::bind('project', fn (string $value) => Project::findOrFail($value));
        Route::bind('user', fn (string $value) => User::findByPrefixedIdOrFail($value));
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by(
                $request->user()?->getKey() ?: $request->ip()
            );
        });

        RateLimiter::for('none', function (Request $request) {
            return Limit::none();
        });
    }
}
