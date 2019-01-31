<?php

namespace App\Console;

use App\Jobs\ProductMoveSync;
use App\Jobs\ProductSync;
use App\Jobs\IndexInactiveProducts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\ProductColor;
use App\Coupon;

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
            } else {
                $schedule->job(new ProductSync, 'create_jobs')->everyTenMinutes();
                $schedule->job(new ProductMoveSync, 'create_jobs')->everyMinute();
            }
            $schedule->call(function(){
                ProductColor::productXMLData();
            })->dailyAt('21:30');
            $schedule->job(new IndexInactiveProducts,'create_jobs')->daily();
            $schedule->call(function(){
                Variant::updateVariantDiffFile();
            })->dailyAt('19:30');
            $schedule->call(function(){ 
                ProductColor::getProductsFromOdooDiscounts(); 
            })->dailyAt('22:00');
            $schedule->call(function (){
                Coupon::updateCouponLeft();
            })->everyTenMinutes();
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
