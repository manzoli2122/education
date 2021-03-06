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
    ];

    /**
     * Define the application's command schedule.  
     * * * * * cd /var/www/html/education && php artisan schedule:run >> /dev/null 2>&1
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */  
    protected function schedule(Schedule $schedule)
    {
        //$schedule->exec('php artisan queue:work --once')->everyMinute();
         //$schedule->command('queue:work --once')->everyMinute();
         //$schedule->command('queue:work --once')->dailyAt('16:41');

        // $schedule->command('inspire')
        //          ->hourly();
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
