<?php

namespace App;

use Ajency\Connections\OdooConnect;
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

    public function shippingAddress($unset = false)
    {
        $address_data            = $this->address;
        $address_data["id"]      = $this->id;
        $address_data["default"] = $this->default;

        if($unset) {
            unset($address_data['state']);
        }

        unset($address_data['state_odoo_id']);

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
            "state_id"   => $this->address["state_odoo_id"],
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
            "state_id"   => $this->address["state_odoo_id"],
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
        $address = implode(", ", [
            $this->address["address"],
            $this->address["city"],
            $this->address["state"],
            'India'
        ]);
        $coordinates = app('geocoder')->geocode($address)->get()->first()->getCoordinates();
        $this->latitude = $coordinates->getLatitude();
        $this->longitude = $coordinates->getLongitude();
        parent::save($options);
    }

    public function checkPincodeServiceable(){
        $pincode = $this->address["pincode"];
        $default_shipment_service = config('pincode_serviceability.default_shipment_service');
        switch ($default_shipment_service) {
            case 'Delhivery':
                $pincode_data = checkDelhiveryPincodeServiceability($pincode);
                if($pincode_data["success"]){
                    $postal_code_data = $pincode_data['data']['delivery_codes'][0]['postal_code'];
                    $pre_paid = ($postal_code_data['pre_paid'] == 'Y')?true:false;
                    $cod = ($postal_code_data['cod'] == 'Y')?true:false;
                    if($postal_code_data['pre_paid'] == 'N' && $postal_code_data['cod'] == 'N')
                        abort(403, "Pincode not serviceable!!");
                    else
                        return ["pre_paid"=>$pre_paid,"cod"=>$cod];
                }
                else{
                    abort(403, $pincode_data["error"]);
                }
                break;
            
            default:
                break;
        }
        abort(403, "Delivery service not configured!!");
    }
}
