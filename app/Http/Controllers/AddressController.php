<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
    public function userAddItem(Request $request)
    {
    	$params  = $request->all();
    	$user_id = fetchUserFromToken($request->header('Authorization'));

    	$default = $this->defaultAddressSet($user_id, $params["default"]);

    	$address = new Address;
        $address->address = ["name" => $params["name"], "phone" => $params["phone"], "pincode" => $params["pincode"], "state" => $params["state"], "address" => $params["address"], "locality" => $params["locality"], "landmark" => $params["landmark"], "city" => $params["city"]];
        $address->type = $params["type"];
        $address->default = $default;
        $address->user_id = $user_id;
        $address->save();

        $address_data = $address->address;
        $address_data["id"] = $address->id;
        $address_data["type"] = $address->type;
        $address_data["default"] = $address->default;

        return json_encode(["address"=> $address_data, "message"=> "Address Added successfully", 'success'=> true]);
    }

    public function defaultAddressSet($user_id, $default)
    {
    	$address = Address::where('user_id', '=', $user_id)->where('default', '=', true)->first();
    	if($address == null) {
    		$default = true;
    	}
    	elseif($address != null && $default) {
    		$address->default = false;
    		$address->save();
    	}

    	return $default;
    }
}
