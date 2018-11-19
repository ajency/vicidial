<?php

namespace App;

use App\Elastic\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected const MODEL = "stock.location";
    protected $casts = [
        'address'          => 'array',
        'use_in_inventory' => 'boolean',
    ];
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_odoo_id', 'odoo_id');
    }

    public static function getAllLocationsFromOdoo()
    {

        $odoo      = new OdooConnect();
        $max       = self::max('odoo_id');
        $max       = ($max == null) ? 0 : $max;
        $locations = $odoo->defaultExec(self::MODEL, "search_read", [[['id', '>', $max]]], ["fields" => config('odoo.model_fields.location')]);
        foreach ($locations as $location) {
            $loc          = new self;
            $loc->odoo_id = $location["id"];
            $loc->name    = $location["name"];
            if ($location["company_id"]) {
                $loc->company_name = $location["company_id"][1];
                $loc->company_odoo_id   = $location["company_id"][0];
            }
            if ($location["warehouse_id"]) {
                $loc->warehouse_odoo_id = $location["warehouse_id"][0];
                $loc->warehouse_name    = $location["warehouse_id"][1];
            }
            if ($location["location_id"]) {
                $loc->location_odoo_id = $location["location_id"][0];
                $loc->location_name    = $location["location_id"][1];
            }
            $loc->display_name = $location['display_name'];
            $loc->type         = $location['usage'];
            if($location['usage'] == 'internal') $loc->use_in_inventory = true;
            $loc->store_code   = $location['store_code'];
            $address = [];
            $address['city'] = $location['city'];
            $address['state'] = $location['state_name'];
            $address['street'] = $location['street'];
            $address['street2'] = $location['street2'];
            $address['zip'] = $location['zip'];
            $loc->address = $address;
            $loc->save();

        }
    }
}
