<?php

namespace App\Console;

use App\Jobs\ProductMoveSync;
use App\Jobs\ProductSync;
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
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (config('app.run_cron')) {
            if (config('app.env') == 'production') {
                $schedule->job(new ProductSync, 'create_jobs')->daily();
                $schedule->job(new ProductMoveSync, 'create_jobs')->everyMinute();
            } else {
                $schedule->job(new ProductSync, 'create_jobs')->everyTenMinutes();
                $schedule->job(new ProductMoveSync, 'create_jobs')->everyMinute();
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
