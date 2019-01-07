<?php

namespace App\Providers;

use App\Elastic\ElasticQuery;
use Carbon\Carbon;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
            \Log::notice('Queue : ' . $event->job->getQueue());
            \Log::notice('Job : ' . $event->job->resolveName());
            sendEmail('failed-job', [
                'from'          => config('communication.failed-job.from'),
                'subject'       => 'Failed Job : ' . $event->job->getQueue() . ' [' . config('app.env') . ']',
                'template_data' => [
                    'queue'     => $event->job->getQueue(),
                    'job'       => $event->job->resolveName(),
                    'exception' => $event->exception->getMessage(),
                    'body'      => $event->job->getRawBody(),
                    'trace'     => $event->exception->getTraceAsString(),
                ],
                'priority'      => 'default',
            ]);
        });

        Queue::after(function (JobProcessed $event) {
            \Log::notice('Job Processed');
            \Log::notice('Queue : ' . $event->job->getQueue());
            \Log::notice('Job : ' . $event->job->resolveName());
            $json      = $event->job->getRawBody();
            $js        = str_replace('\\', '\\\\', $json);
            $arr       = json_decode(str_replace('\\\\"', '\\"', $js), true);
            $command   = $arr['data']['command'];
            $name      = $arr['data']['commandName'];
            $timestamp = Carbon::now()->timestamp;
            $id        = $event->job->getJobId();
            $data      = [
                'id'           => $id,
                'type'         => 'db_job',
                'job'          => $name,
                'command_data' => $command,
                'payload'      => $json,
                'timestamp'    => $timestamp,
                'success'      => true,
            ];
            $q = new ElasticQuery;
            $q->setIndex('queue_jobs')->createIndexParams($id, $data)->index();
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
