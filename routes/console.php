<?php

use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Support\Facades\Schedule;
use Laravel\Horizon\Console\SnapshotCommand;
use Laravel\Sanctum\Console\Commands\PruneExpired;
use Spatie\SiteSearch\Commands\CrawlCommand;
use Support\Sitemap\Commands\GenerateSitemap;


Schedule::command(PruneStaleTagsCommand::class)
    ->withoutOverlapping(600)
    ->hourly()
    ->runInBackground();

Schedule::command(ClearResetsCommand::class)
    ->withoutOverlapping(600)
    ->everyFifteenMinutes()
    ->runInBackground();

Schedule::command(SnapshotCommand::class)
    ->withoutOverlapping(240)
    ->everyFiveMinutes()
    ->runInBackground();

Schedule::command(PruneExpired::class, ['--hours=24'])
    ->withoutOverlapping(1440)
    ->dailyAt('01:30')
    ->runInBackground();

Schedule::command(PruneCommand::class)
    ->withoutOverlapping(1440)
    ->dailyAt('02:00')
    ->runInBackground();

Schedule::command(GenerateSitemap::class)
    ->environments(['production'])
    ->withoutOverlapping(600)
    ->everySixHours()
    ->runInBackground();

Schedule::command(CrawlCommand::class)
    ->environments(['production'])
    ->withoutOverlapping(600)
    ->everyThreeHours()
    ->runInBackground();
