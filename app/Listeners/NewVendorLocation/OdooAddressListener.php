<?php

namespace App\Listeners\NewVendorLocation;

use Ajency\Connections\OdooConnect;
use App\Events\NewVendorLocation;
use Illuminate\Contracts\Queue\ShouldQueue;

class OdooAddressListener implements ShouldQueue
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
        $location           = $event->location;
        $odoo               = new OdooConnect;
        $locDetails         = $odoo->defaultExec('res.partner', 'read', [[$location->odoo_id]], ['fields' => ['name', 'street2', 'street', 'zone', 'city', 'state_id', 'zip']])->first();
        $address            = [];
        $address['city']    = implode(' - ', [$locDetails['city'], $locDetails['zone']]);
        $address['state']   = trim($locDetails['state_id'][1]);
        $address['street']  = $locDetails['street'];
        $address['street2'] = $locDetails['street2'];
        $address['zip']     = $locDetails['zip'];
        $location->address  = $address;
        $location->save();

    }
}
