<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $casts = [
        'address' => 'array',
    ];

    public function locations()
    {
        return $this->hasMany('App\Location', 'warehouse_odoo_id', 'odoo_id');
    }

    public static function getAllWarehousesFromOdoo()
    {

        $odoo       = new OdooConnect();
        $max        = self::max('odoo_id');
        $max        = ($max == null) ? 0 : $max;
        $warehouses = $odoo->defaultExec("stock.warehouse", "search_read", [[['id', '>', $max]]], ["fields" => config('odoo.model_fields.warehouse')]);
        foreach ($warehouses as $warehouse) {
            $wh               = new Warehouse;
            $wh->odoo_id      = $warehouse["id"];
            $wh->name         = $warehouse["name"];
            $wh->company_name = $warehouse["company_id"][1];
            $wh->company_id   = $warehouse["company_id"][0];
            $wh->carpet_area  = $warehouse['carpet_area'];
            $wh->retail_area  = $warehouse['retail_area'];
            $wh->latitude     = $warehouse['latitude'];
            $wh->longitude    = $warehouse['longitude'];
            $wh->save();

        }
    }

    public function getAddress()
    {
        if (empty($this->address)) {
            return null;
        } else {
            return array('store_name' => $this->address['store_name'], 'locality' => $this->address['locality'], 'city' => $this->address['city']);
        }

    }
}
