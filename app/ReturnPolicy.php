<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
   
    {
        return $this->belongsToMany('App\Facet');
    }
}
