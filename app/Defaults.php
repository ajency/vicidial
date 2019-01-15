<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Carbon\Carbon;
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
        self::where('type', 'state')->delete();
        foreach (self::getStatesFromOdoo() as $state) {
            $defaults            = new self;
            $defaults->type      = 'state';
            $defaults->label     = $state["name"];
            $defaults->meta_data = ['name' => $state["name"], 'code' => $state['code'], 'odoo_id' => $state["id"]];
            $defaults->save();
        }
    }

    public static function getLastProductMoveSync()
    {
        $move = self::where('type', 'sync')->where('label', 'product_move')->first();
        if ($move == null) {
            $move            = new self;
            $move->type      = 'sync';
            $move->label     = 'product_move';
            $move->meta_data = ['time' => Carbon::now()->subDay()->startOfDay()->toDateTimeString(), 'id' => 0];
            $move->save();
        }
        return $move->meta_data;
    }

    public static function setLastProductMoveSync($id)
    {
        $move = self::where('type', 'sync')->where('label', 'product_move')->first();
        if (!isset($move->meta_data['id']) || $id > $move->meta_data['id']) {
            $move->meta_data = ['time' => Carbon::now()->subSeconds(15)->toDateTimeString(), 'id' => $id];

        } else {
            $move->meta_data = ['time' => Carbon::now()->subSeconds(15)->toDateTimeString(), 'id' => $move->meta_data['id']];
        }
        $move->save();
    }

    public static function getLastProductSync()
    {
        $sync = self::where('type', 'sync')->where('label', 'product')->first();
        if ($sync == null) {
            $sync            = new self;
            $sync->type      = 'sync';
            $sync->label     = 'product';
            $sync->meta_data = ['time' => Carbon::now()->subDay()->startOfDay()->toDateTimeString()];
            $sync->save();
        }
        return $sync->meta_data['time'];

    }

    public static function setLastProductSync()
    {
        $sync            = self::where('type', 'sync')->where('label', 'product')->first();
        $sync->meta_data = ['time' => Carbon::now()->toDateTimeString()];
        $sync->save();
    }

    public static function getLastCatalogDiscountSync()
    {
        $sync = self::where('type', 'sync')->where('label', 'product')->first();
        if ($sync == null) {
            $sync            = new self;
            $sync->type      = 'sync';
            $sync->label     = 'catalog_discount';
            $sync->meta_data = ['time' => Carbon::now()->subDay()->startOfDay()->toDateTimeString()];
            $sync->save();
        }
        return $sync->meta_data['time'];

    }

    public static function setLastCatalogDiscountSync()
    {
        $sync            = self::where('type', 'sync')->where('label', 'catalog_discount')->first();
        $sync->meta_data = ['time' => Carbon::now()->toDateTimeString()];
        $sync->save();
    }

    public static function getLastInactiveProductSync()
    {
        $sync = self::where('type', 'sync')->where('label', 'inactive_product')->first();
        if ($sync == null) {
            $sync            = new self;
            $sync->type      = 'sync';
            $sync->label     = 'inactive_product';
            $sync->meta_data = ['time' => Carbon::now()->subYear()->startOfDay()->toDateTimeString()];
            $sync->save();
        }
        return $sync->meta_data['time'];

    }

    public static function setLastInactiveProductSync()
    {
        $sync            = self::where('type', 'sync')->where('label', 'inactive_product')->first();
        $sync->meta_data = ['time' => Carbon::now()->toDateTimeString()];
        $sync->save();
    }

    public static function getEmailExtras($type, $orig = [], $for = null)
    {
        if (!is_array($orig)) {
            $orig = [$orig];
        }
        $extras = self::where('type', 'email')->where('label', $type)->first();
        if ($extras == null) {
            return $orig;
        }
        if ($for == null) {
            foreach ($extras->meta_data as $email) {
                $orig[] = $email;
            }
        } else {
            if (isset($extras->meta_data[$for])) {
                foreach ($extras->meta_data[$for] as $email) {
                    $orig[] = $email;
                }
            }
        }
        return array_unique($orig);
    }

    public static function addElasticAlternateIndex($index, $name)
    {
        $indexes = self::where('type', 'index')->where('label', $index)->first();
        if ($indexes == null) {
            $indexes            = new self;
            $indexes->type      = 'index';
            $indexes->label     = $index;
            $indexes->meta_data = [];
        }
        $names              = $indexes->meta_data;
        $names[]            = $name;
        $indexes->meta_data = array_unique($names);
        $indexes->save();
    }

    public static function getElasticAlternateIndexes($index)
    {
        $indexes = self::where('type', 'index')->where('label', $index)->first();
        if ($indexes == null) {
            return [];
        } else {
            return $indexes->meta_data;
        }
    }

}
