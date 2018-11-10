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

    public static function getStatesFromOdoo()
    {
        $odoo   = new OdooConnect;
        $states = $odoo->defaultExec('res.country.state', 'search_read', [[['country_id', '=', 104]]], ["limit" => 60, "fields" => ['name', 'code']])->reject(function ($value, $key) {return $value['name'] != trim($value['name']);});
        return $states;
    }

    public static function saveOdooStates()
    {
        Defaults::where('type', 'state')->delete();
        foreach (self::getStatesFromOdoo() as $state) {
            $defaults            = new Defaults;
            $defaults->type      = 'state';
            $defaults->label     = $state["name"];
            $defaults->meta_data = ['name' => $state["name"], 'code' => $state['code'], 'odoo_id' => $state["id"]];
            $defaults->save();
        }
    }

}
