<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expression extends Model
{
	
    public function parent()
    {
        return $this->morphTo();
    }
}
