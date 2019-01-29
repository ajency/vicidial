<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $casts = [
        'has_expression' => 'boolean',

    ];

    protected $fillable = ['odoo_id'];
    
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

    public function validate($userID = null)
    {
        if ($this->left_uses <= 0) {
            return false;
        }

        if ($this->has_expression) {

        }

        return true;
    }
}
