<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $casts = [
        'address' => 'array',
    ];

    protected $fillable = ['odoo_id'];

    public function locations()
    {
        return $this->hasMany('App\Location', 'warehouse_odoo_id', 'odoo_id');
    }

    public static function getAllWarehousesFromOdoo()
    {

        $odoo       = new OdooConnect();
        $warehouses = $odoo->defaultExec("stock.warehouse", "search_read", [[['id', '>', 0]]], ["fields" => config('odoo.model_fields.warehouse')]);
        foreach ($warehouses as $warehouse) {
            $wh               = Warehouse::firstOrNew(['odoo_id' => $warehouse["id"]]);
            $wh->name         = $warehouse["name"];
            $wh->company_name = $warehouse["company_id"][1];
            $wh->company_id   = $warehouse["company_id"][0];
            $wh->carpet_area  = $warehouse['carpet_area'];
            $wh->retail_area  = $warehouse['retail_area'];
            $wh->latitude     = $warehouse['latitude'];
            $wh->longitude    = $warehouse['longitude'];
            if ($warehouse['store_manager_phone'] && config('app.env') == 'production') {
                $wh->phone_number = $warehouse['store_manager_phone'];
            }
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
