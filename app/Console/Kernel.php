<?php

namespace App\Console;

use App\Jobs\ProductMoveSync;
use App\Jobs\ProductSync;
use App\Product;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\ProductColor;

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
            if (!isNotProd()) {
                $schedule->job(new ProductSync, 'create_jobs')->hourly();
                $schedule->job(new ProductMoveSync, 'create_jobs')->everyMinute();
                $schedule->call(function(){
                    ProductColor::getProductsFromOdooDiscounts();
                })->dailyAt('21:30');
            } else {
                $schedule->job(new ProductSync, 'create_jobs')->everyTenMinutes();
                $schedule->job(new ProductMoveSync, 'create_jobs')->everyMinute();
                $schedule->call(function(){
                    ProductColor::getProductsFromOdooDiscounts();
                })->dailyAt('21:30');
            }
            $schedule->call(function() {
                Product::startInactiveSync();
            })->daily();
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
