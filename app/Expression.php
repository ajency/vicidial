<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expression extends Model
{
	protected $casts = [
		'value' => 'array',
	];
    public function parent()
    {
        return $this->morphTo();
    }
}
