<?php

namespace App;

use App\Elastic\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Defaults extends Model
{
    protected $table = 'defaults';
    protected $casts = [
        'meta_data' => 'array',
    ];

    public static function getStateList()
    {
        $odoo   = new OdooConnect;
        $states = $odoo->defaultExec('res.country.state', 'search_read', [[['country_id', '=', 104]]], ["limit" => 60, "fields" => ['name', 'code']]);
        return $states;
    }

    public static function saveStateList()
    {
        foreach (self::getStateList() as $state) {
            $defaults            = new Defaults;
            $defaults->type      = 'state';
            $defaults->label     = $state["name"];
            $defaults->meta_data = ['name'=> $state["name"], 'code' => $state['code'], 'odoo_id' => $state["id"]];
            $defaults->save();
        }
    }

}
