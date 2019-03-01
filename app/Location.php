<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected const MODEL = "stock.location";
    protected $casts      = [
        'address'          => 'array',
        'use_in_inventory' => 'boolean',
        'business_pref_wt' => 'double',
        'dist_wt'          => 'double',
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
                $loc->company_name    = $location["company_id"][1];
                $loc->company_odoo_id = $location["company_id"][0];
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
            if ($location['usage'] == 'internal') {
                $loc->use_in_inventory = true;
            }

            $loc->store_code    = $location['store_code'];
            $address            = [];
            $address['city']    = $location['city'];
            $address['state']   = $location['state_name'];
            $address['street']  = $location['street'];
            $address['street2'] = $location['street2'];
            $address['zip']     = $location['zip'];
            $loc->address       = $address;
            $loc->save();

        }
    }

    public static function addVendorLocation($params){
        
    }

    public function getAddress()
    {
        if (empty($this->address)) {
            return null;
        } else {
            return array('store_name' => $this->warehouse_name, 'locality' => $this->address['street2'], 'city' => $this->address['city'] . ', ' . $this->address['state'] . ' - ' . $this->address['zip']);
        }
    }

    public function warehouseCoordinates()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_odoo_id', 'odoo_id')->select(['latitude', 'longitude']);
    }

    public static function getLocationScores($latitude, $longitude)
    {
        $destination       = implode(',', [$latitude, $longitude]);
        $locations         = Location::where('use_in_inventory', true)->get();
        $mappedCoordinates = $locations->map(function ($item, $key) {
            $coor = $item->warehouseCoordinates;
            return implode(',', [$coor->latitude, $coor->longitude]);
        });
        $distanceMatrix = array_dot(array_only(json_decode(\GoogleMaps::load('distancematrix')->setParamByKey('destinations', $destination)->setParamByKey('origins', $mappedCoordinates->toArray())->get(), true), ['rows']));
        $filtered       = array_where($distanceMatrix, function ($value, $key) {return strpos($key, 'distance.value') !== false;});
        $distancesArray = $locations->pluck('odoo_id')->combine(collect(range(0, $locations->count() - 1))->map(function ($item, $key) use ($filtered) {return isset($filtered['rows.' . $item . '.elements.0.distance.value']) ? $filtered['rows.' . $item . '.elements.0.distance.value'] : 10000000000;}));
        $weights = $locations->map(function ($loc) use ($distancesArray) {return ['id' => $loc->odoo_id, 'distance' => $distancesArray[$loc->odoo_id], 'business_wt' => $loc->business_pref_wt, 'loc_wt' => $loc->dist_wt];});
        $scores = $weights->keyBy('id')->map(function ($item) {return (config('orders.location_scores.distance') - $item['distance']) * $item['loc_wt'] / config('orders.location_scores.distance') + $item['business_wt'];});
        return $scores;
    }

}
