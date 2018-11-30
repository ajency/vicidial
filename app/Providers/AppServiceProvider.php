<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!(\App::environment('local'))) {
           // The environment is not local
           \Illuminate\Support\Facades\URL::forceScheme('https');
           Schema::defaultStringLength(191);
        }

        Queue::failing(function (JobFailed $event) {
            \Log::notice('Job failed');
            \Log::notice('Queue : '.$event->job->getQueue());
            \Log::notice('Job : '.$event->job->resolveName());
            sendEmail('failed-job', [
                'from'          => config('communication.failed-job.from'),
                'subject'       => 'Failed Job : '.$event->job->getQueue(),
                'template_data' => [
                    'queue' => $event->job->getQueue(),
                    'job' => $event->job->resolveName(),
                    'exception' => $event->exception->getMessage(),
                    'trace' => $event->exception->getTraceAsString(),
                ],
                'priority'      => 'default',
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
