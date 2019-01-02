<?php

namespace App;

use App\Cart;
use App\Elastic\OdooConnect;
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

    protected $odooModel = "res.partner";

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
        $cart          = new Cart;
        $cart->user_id = $this->id;
        $cart->save();
        $ac = $this->activeCart();
        if ($replicate) {
            $cart->cart_data    = $ac->cart_data;
            $cart->promotion_id = $ac->promotion_id;
            $cart->save();
        }
        $ac->active = 0;
        $ac->save();
        if ($ac->type == 'cart' && empty($ac->cart_data)) {
            $ac->delete();
        }
        $this->cart_id = $cart->id;
        $this->save();
        return $cart;
    }

    private function getOdooIdFromOdoo()
    {
        $odoo = new OdooConnect;
        return $odoo->defaultExec($this->odooModel, 'search_read', [[
            ['phone', '=', $this->phone],
            ['customer', '=', true],
            ['type', '=', 'contact'],
        ]], [
            "fields" => ['id'],
            'limit'  => 1,
        ])->first()['id'];
    }

    private function writeNewCustomerToOdoo()
    {
        $odoo = new OdooConnect;
        return $odoo->defaultExec($this->odooModel, 'create', [[
            "customer"   => true,
            "name"       => $this->name,
            "phone"      => $this->phone,
            "email"      => ($this->email) ? $this->email : "",
            "type"       => "contact",
            "is_company" => false,
        ]], null)->first();
    }

    private function updateCustomerOnOdoo()
    {
        $odoo = new OdooConnect;
        $odoo->defaultExec($this->odooModel, 'write', [[$this->odoo_id], [
            "customer"   => true,
            "name"       => $this->name,
            "phone"      => $this->phone,
            "email"      => ($this->email) ? $this->email : "",
            "type"       => "contact",
            "is_company" => false,

        ]], null);
    }

    private function odooSync()
    {
        if ($this->odoo_id == null) {
            //check if the id with that phone number exists
            $odoo_id = $this->getOdooIdFromOdoo();
            if ($odoo_id == null) {
                //if customer does not exist, create a new customer
                $this->odoo_id = $this->writeNewCustomerToOdoo();
            } else {
                $this->odoo_id = $odoo_id;
            }
        } else {
            //update the customer if the customer already exists
            $this->updateCustomerOnOdoo();
        }
    }

    public function save(array $options = [])
    {
        $this->odooSync();
        parent::save($options);
    }

    public function userInfo()
    {
        if ($this->email == null) {
            return null;
        } else {
            return array('name' => $this->name, 'email' => $this->email);
        }
    }

    public function userDetails()
    {
        $user_info = $this->userInfo();
        if ($user_info != null) {
            $response = $user_info;
        }
        $response['mobile'] = $this->phone;

        return $response;
    }
}
