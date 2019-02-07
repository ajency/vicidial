<?php

namespace App\Console;

use App\Coupon;
use App\Jobs\IndexInactiveProducts;
use App\Jobs\ProductMoveSync;
use App\Jobs\ProductSync;
use App\Jobs\VariantSync;
use App\Jobs\FetchWarehouse;
use App\ProductColor;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\ProductColor;
use App\Coupon;
use App\Jobs\GenerateSitemapProductList;
use App\Jobs\GenerateSitemap;

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
                //$schedule->job(new VariantSync, 'create_jobs')->hourly();
                $schedule->job(new FetchWarehouse, 'process_details')->weekly();
            } else {
                $schedule->job(new ProductSync, 'create_jobs')->everyTenMinutes();
                //$schedule->job(new VariantSync, 'create_jobs')->everyTenMinutes();
            }
            $schedule->job(new ProductMoveSync, 'create_jobs')->hourly();
            $schedule->call(function () {
                ProductColor::productXMLData();
            })->dailyAt('21:30');
            $schedule->job(new IndexInactiveProducts, 'create_jobs')->daily();
            $schedule->call(function () {
                Variant::updateVariantDiffFile();
            })->dailyAt('19:30');
            $schedule->call(function () {
                ProductColor::getProductsFromOdooDiscounts();
            })->dailyAt('22:00');
            $schedule->call(function () {
                Coupon::updateCouponLeft();
            })->everyTenMinutes();
            $schedule->call(function(){
                GenerateSitemapProductList::dispatch()->onQueue('process_sitemap_product_list');
                GenerateSitemap::dispatch()->onQueue('process_sitemap_parent');
            })->dailyAt('04:00');
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
