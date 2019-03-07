<?php

namespace App\Listeners\NewVendorLocation;

use App\Events\NewVendorLocation;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackofficeLocationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewVendorLocation  $event
     * @return void
     */
    public function handle(NewVendorLocation $event)
    {
        $location = $event->location;
        \Ajency\ServiceComm\Comm\Sync::call('backoffice', 'createVendorLocation', [
            'location' => $location->id,
        ]);
    }
}
