<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function model()
    {
        return $this->morphTo();
    }
}
