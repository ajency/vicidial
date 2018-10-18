<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function getElasticName()
    {
        return $this->elastic_name;
    }
}
