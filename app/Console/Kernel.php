<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Psy\Command\Command;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\getDataForBitcoin::class,
        Commands\getDataForCoins::class,
        Commands\getDataForExchanges::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //        $schedule->command('get-bitcoins-data')->everyMinute()->then(function () {
        //            $this->call('get-coins-data');
        //        });
        //$schedule->command('get-exchanges-data')->everyMinute();
        $schedule->command('get-bitcoins-data')->everyMinute();
        //$schedule->command('get-coins-data')->everyFiveMinutes()->withoutOverlapping()->appendOutputTo(storage_path() .'/logs/laravel.log');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
