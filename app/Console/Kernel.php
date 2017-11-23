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
        //
        'App\Console\Commands\UpdateCache1',
        'App\Console\Commands\UpdateCache2'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();


        // UpdateCache1  6小时 更新一次
        $schedule->command('ling:updateCache1')
            ->cron("0 */6 * * *")
            ->runInBackground()
            ->sendOutputTo("./updateCache1.log")
            ->withoutOverlapping()
        ;
        // UpdateCache2  1小时 更新一次
        $schedule->command('ling:updateCache2')
            ->hourly()
            ->runInBackground()
            ->sendOutputTo("./updateCache2.log")
            ->withoutOverlapping()
        ;
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
