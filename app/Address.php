<?php

namespace App;

use App\Elastic\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $casts = [
        'address' => 'array',
        'default' => 'boolean',
        'active'  => 'boolean',
    ];

    protected $odooModel =  "res.partner";

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function shippingAddress()
    {
        $address_data            = $this->address;
        $address_data["id"]      = $this->id;
        $address_data["type"]    = $this->type;
        $address_data["default"] = $this->default;

        return $address_data;
    }

    private function writeAddressToOdoo()
    {
        $odoo          = new OdooConnect;
        return $odoo->defaultExec($this->odooModel, 'create', [[
            "customer"   => true,
            "parent_id"  => $this->user->odoo_id,
            "type"       => "invoice",
            "is_company" => false,

            "name"       => $this->address["name"],
            "phone"      => $this->address["phone"],
            "city"       => $this->address["city"],
            "street"     => $this->address["address"],
            "street2"    => $this->address["locality"],
            // "state_id"   => $this->address["state_id"],
            "state_id"   => 586,
            "zip"        => $this->address["pincode"],

        ]], null)->first();
    }

    private function updateAddressOnOdoo(){
        $odoo          = new OdooConnect;
        $odoo->defaultExec($this->odooModel, 'write', [[$this->odoo_id],[
            "name"       => $this->address["name"],
            "phone"      => $this->address["phone"],
            "city"       => $this->address["city"],
            "street"     => $this->address["address"],
            "street2"    => $this->address["locality"],
            // "state_id"   => $this->address["state_id"],
            "state_id"   => 586,
            "zip"        => $this->address["pincode"],

        ]], null);
    }

    private function odooSync()
    {
        if ($this->odoo_id == null) {
            $this->odoo_id = $this->writeAddressToOdoo();
        } else {
            //update the customer if the customer already exists
            $this->updateAddressOnOdoo();
        }
    }

    public function save(array $options = [])
    {
        $this->odooSync();
        parent::save($options);
    }
}
