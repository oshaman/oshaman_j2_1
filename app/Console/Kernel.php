<?php

namespace App\Console;

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
//        Commands\GetGreen::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('\App\Repositories\GetStatistic@getExmo')
                    ->everyMinute()->name('get-from-exmo')->withoutOverlapping();
        $schedule->call('\App\Repositories\GetStatistic@getBitfinex')
                    ->everyMinute()->name('get-from-bitfinex')->withoutOverlapping();

        $schedule->call('\App\Repositories\LandingsRepository@everyMinute')
                    ->everyMinute()->name('get-from-landings')->withoutOverlapping();
        $schedule->call('\App\Repositories\LandingsRepository@everyFiveMinutes')
                    ->everyFiveMinutes()->name('get-from-5landings')->withoutOverlapping();
        $schedule->call('\App\Repositories\LandingsRepository@everyTenMinutes')
                    ->everyTenMinutes()->name('get-from-10landings')->withoutOverlapping();
        $schedule->call('\App\Repositories\LandingsRepository@everyFifteenMinutes')
                    ->everyFifteenMinutes()->name('get-from-15landings')->withoutOverlapping();
        $schedule->call('\App\Repositories\LandingsRepository@everyThirtyMinutes')
                    ->everyThirtyMinutes()->name('get-from-30landings')->withoutOverlapping();
        $schedule->call('\App\Repositories\LandingsRepository@hourly')
                    ->hourly()->name('get-from-hourlylandings')->withoutOverlapping();

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
