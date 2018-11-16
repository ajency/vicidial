<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse', 'warehouse_odoo_id', 'odoo_id');
    }
}
