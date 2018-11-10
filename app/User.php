<?php

namespace App;

use App\Cart;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'cart_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function carts()
    {
        return $this->hasMany('App\Cart');
    }

    public function activeCart()
    {
        return Cart::find($this->cart_id);
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public static function getUserByToken(string $token)
    {
        $token = explode('Bearer ', $token)[1];
        $user  = self::where('api_token', $token)->first();
        return $user;
    }

    public function newCart($replicate = false)
    {
        // $cart = Cart::create(['user_id' => $this->id, 'active' => 1, 'type' => 'cart']);
        $cart = new Cart;
        $cart->user_id = $this->id;
        $cart->save();
        $ac = $this->activeCart();
        if($replicate){
            $cart->cart_data = $ac->cart_data;
            $cart->save();
        }
        $ac->active = 0;
        $ac->save();
        if($ac->type == 'cart' && empty($ac->cart_data)){
            $ac->delete();
        }
        $this->cart_id = $cart->id;
        $this->save();
    }
}
