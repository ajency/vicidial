<?php

namespace App;

use App\Elastic\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{

    public static function getAllWarehouses()
    {

        $odoo       = new OdooConnect();
        $warehouses = $odoo->defaultExec("stock.warehouse", "search_read", [[]], ["fields" => ['company_id', 'name']]);
        foreach ($warehouses as $warehouse) {
            if (is_null(self::where('odoo_id', $warehouse["id"])->first())) {
                $wh               = new Warehouse;
                $wh->odoo_id      = $warehouse["id"];
                $wh->name         = $warehouse["name"];
                $wh->company_name = $warehouse["company_id"][1];
                $wh->company_id   = $warehouse["company_id"][0];
                $wh->save();
            }
        }
        return $warehouses;
    }
}
