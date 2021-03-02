<?php

namespace App\Console;

use App\Console\Commands\ImportCatalog;
use App\Console\Commands\OptimizationImages;
use App\Console\Commands\ResizeImages;
use App\Console\Commands\UpdateCatalogPrices;
use App\Console\Commands\SetInvisibleImages;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ImportCatalog::class,
        UpdateCatalogPrices::class,
        ResizeImages::class,
        OptimizationImages::class,
        SetInvisibleImages::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('parser:import-catalog')
             ->weeklyOn(1, '00:00')
             ->withoutOverlapping()
             ->appendOutputTo(storage_path('logs/cron.log'));

        $schedule->command('parser:update-prices')
            ->dailyAt('00:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/cron.log'));

        $schedule->command('images:resize-images')
            ->hourly()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/resize-images.log'));

        $schedule->command('images:optimization-images')
            ->dailyAt('02:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/optimization-images.log'));

        $schedule->command('images:set-invisible-images')
            ->hourlyAt(10)
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/set-invisible-images.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
