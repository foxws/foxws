<?php

use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Support\Facades\Schedule;
use Laravel\Horizon\Console\SnapshotCommand;
use Laravel\Sanctum\Console\Commands\PruneExpired;
use Spatie\Activitylog\CleanActivitylogCommand;
use Spatie\DbSnapshots\Commands\Cleanup as DbCleanupCommand;
use Spatie\DbSnapshots\Commands\Create as DbSnapshotCommand;
use Spatie\SiteSearch\Commands\CrawlCommand;
use Support\Sitemap\Commands\GenerateSitemap;

Schedule::command(ClearResetsCommand::class)
    ->withoutOverlapping(600)
    ->everyFifteenMinutes()
    ->runInBackground();

Schedule::command(SnapshotCommand::class)
    ->withoutOverlapping(240)
    ->everyFiveMinutes()
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

Schedule::command(PruneExpired::class, ['--hours=24'])
    ->withoutOverlapping(1440)
    ->dailyAt('01:30')
    ->runInBackground();

Schedule::command(CleanActivitylogCommand::class)
    ->withoutOverlapping(1440)
    ->dailyAt('02:30')
    ->runInBackground();

Schedule::command(DbSnapshotCommand::class)
    ->environments(['production'])
    ->withoutOverlapping(1440)
    ->dailyAt('03:30')
    ->runInBackground();

Schedule::command(DbCleanupCommand::class, ['--keep=15'])
    ->environments(['production'])
    ->withoutOverlapping(1440)
    ->dailyAt('04:00')
    ->runInBackground();
