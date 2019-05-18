<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $casts = [
        'address'  => 'array',
        'default'  => 'boolean',
        'active'   => 'boolean',
        'verified' => 'boolean',
    ];

    protected $odooModel = "res.partner";

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function shippingAddress($unset = false, $verification = false)
    {
        $address_data            = $this->address;
        $address_data["id"]      = $this->id;
        $address_data["default"] = $this->default;

        if ($unset) {
            unset($address_data['state']);
        }

        unset($address_data['state_odoo_id']);

        if ($verification) {
            $address_data['verified'] = $this->verified;
        }

        return $address_data;
    }

    private function writeAddressToOdoo()
    {
        $odoo = new OdooConnect;
        return $odoo->defaultExec($this->odooModel, 'create', [[
            "customer"   => true,
            "parent_id"  => $this->user->odoo_id,
            "type"       => "invoice",
            "is_company" => false,

            "name"       => $this->address["name"],
            "phone"      => $this->address["phone"],
            "city"       => $this->address["city"],
            "street"     => $this->address["address"],
            "state_id"   => $this->address["state_odoo_id"],
            "zip"        => $this->address["pincode"],

        ]], null)->first();
    }

    private function updateAddressOnOdoo()
    {
        $odoo = new OdooConnect;
        $odoo->defaultExec($this->odooModel, 'write', [[$this->odoo_id], [
            "name"     => $this->address["name"],
            "phone"    => $this->address["phone"],
            "city"     => $this->address["city"],
            "street"   => $this->address["address"],
            "state_id" => $this->address["state_odoo_id"],
            "zip"      => $this->address["pincode"],

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
        $address = implode(", ", [
            $this->address["address"],
            $this->address["city"],
            $this->address["state"],
            'India',
        ]);
        $coordinates     = app('geocoder')->geocode($address)->get()->first()->getCoordinates();
        $this->latitude  = $coordinates->getLatitude();
        $this->longitude = $coordinates->getLongitude();
        parent::save($options);
    }

    public function checkPincodeServiceable()
    {
        $pincode = $this->address["pincode"];
        return checkPincodeServiceableHelper($pincode);
    }
}
