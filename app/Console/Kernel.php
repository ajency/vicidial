<?php

namespace App\Console;

use App\Coupon;
use App\Jobs\GenerateSitemap;
use App\Jobs\GenerateSitemapProductList;
use App\Jobs\IndexInactiveProducts;
use App\Jobs\ProductMoveSync;
use App\Jobs\ProductSync;
use App\Jobs\VariantSync;
use App\Jobs\FetchWarehouse;
use App\ProductColor;
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
            if (!isNotProd()) {
                $schedule->job(new ProductSync, 'create_jobs')->name('ProductSync')->cron('0 */4 * * *')->onOneServer();
                $schedule->job(new VariantSync, 'create_jobs')->cron('0 */2 * * *')->onOneServer();
                $schedule->job(new FetchWarehouse, 'process_details')->name('FetchWarehouse')->weekly()->onOneServer();
            } else {
                $schedule->job(new ProductSync, 'create_jobs')->name('ProductSyncProd')->everyTenMinutes()->onOneServer();
                $schedule->job(new VariantSync, 'create_jobs')->everyTenMinutes()->onOneServer();
            }
            $schedule->job(new ProductMoveSync, 'create_jobs')->name('ProductMoveSync')->dailyAt('21:00')->onOneServer();
            $schedule->call(function () {
                ProductColor::productXMLData();
            })->name('productXMLData')->dailyAt('21:30')->onOneServer();
            //$schedule->job(new IndexInactiveProducts, 'create_jobs')->name('IndexInactiveProducts')->daily()->onOneServer();
            $schedule->call(function () {
                Variant::updateVariantDiffFile();
            })->name('updateVariantDiffFile')->dailyAt('19:30')->onOneServer();
            $schedule->call(function () {
                ProductColor::getProductsFromOdooDiscounts();
            })->name('getProductsFromOdooDiscounts')->dailyAt('22:00')->onOneServer();
            $schedule->call(function () {
                Coupon::updateCouponLeft();
            })->name('updateCouponLeft')->everyFifteenMinutes()->onOneServer();
            $schedule->call(function () {
                GenerateSitemapProductList::dispatch()->onQueue('process_sitemap_product_list');
                GenerateSitemap::dispatch()->onQueue('process_sitemap_parent');
            })->name('GenerateSitemapProductList')->dailyAt('04:00')->onOneServer();
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
