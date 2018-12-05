<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facet extends Model
{
	protected $casts = [
        'display' => 'boolean',
    ];
	
}
