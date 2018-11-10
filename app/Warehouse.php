<?php

namespace App;

use App\Elastic\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{

    public static function getAllWarehousesFromOdoo()
    {

        $odoo       = new OdooConnect();
        $max        = self::max('odoo_id');
        $max        = ($max == null) ? 0 : $max;
        $warehouses = $odoo->defaultExec("stock.warehouse", "search_read", [[['id', '>', $max]]], ["fields" => ['company_id', 'name']]);
        foreach ($warehouses as $warehouse) {
            $wh               = new Warehouse;
            $wh->odoo_id      = $warehouse["id"];
            $wh->name         = $warehouse["name"];
            $wh->company_name = $warehouse["company_id"][1];
            $wh->company_id   = $warehouse["company_id"][0];
            $wh->save();

        }
    }
}
