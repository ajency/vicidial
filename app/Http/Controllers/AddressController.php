<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
    public function userAddAddress(Request $request)
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

        $address_data = $this->addressObj($address);

        return json_encode(["address"=> $address_data, "message"=> "Address Added successfully", 'success'=> true]);
    }

    public function userEditAddress(Request $request)
    {
        $params  = $request->all();
        $user_id = fetchUserFromToken($request->header('Authorization'));

        $address = Address::find($params["id"]);
        if($address->user_id != $user_id) abort(403);

        $default = $this->defaultAddressSet($user_id, $params["default"], $address->id);

        $address->address = ["name" => $params["name"], "phone" => $params["phone"], "pincode" => $params["pincode"], "state" => $params["state"], "address" => $params["address"], "locality" => $params["locality"], "landmark" => $params["landmark"], "city" => $params["city"]];
        $address->type = $params["type"];
        $address->default = $default;
        $address->user_id = $user_id;
        $address->save();

        $address_data = $this->addressObj($address);

        return json_encode(["address"=> $address_data, "message"=> "Address Added successfully", 'success'=> true]);
    }

    public function userFetchAddresses(Request $request)
    {
        $user_id = fetchUserFromToken($request->header('Authorization'));

        $addresses = Address::where('user_id', '=', $user_id)->get();

        $address_data = array();

        foreach ($addresses as $address) {
            $address_data[] = $this->addressObj($address);
        }

        return json_encode(["addresses"=> $address_data]);
    }

    public function userDeleteAddress(Request $request)
    {
        $params  = $request->all();
        $user_id = fetchUserFromToken($request->header('Authorization'));

        $address = Address::find($params["address_id"]);
        if($address->user_id != $user_id) abort(403);

        $address->delete();

        $default = $this->defaultAddressFirst($user_id);

        return json_encode(["default_id"=> $default, "message"=> "Address Deleted successfully", 'success'=> true]);
    }

    public function defaultAddressSet($user_id, $default, $address_id = null)
    {
    	$address = Address::where('user_id', '=', $user_id)->where('default', '=', true)->first();
        if($address_id != null && $address != null && $address_id == $address->id) {
            $default = true;
        }
        elseif($address == null) {
    		$default = true;
    	}
    	elseif($address != null && $default) {
    		$address->default = false;
    		$address->save();
    	}

    	return $default;
    }

    public function defaultAddressFirst($user_id)
    {
        $address = Address::where('user_id', '=', $user_id)->where('default', '=', true)->first();
        if($address == null) {
            $address = Address::where('user_id', '=', $user_id)->first();
            if($address != null) {
                $address->default = true;
                $address->save();
            }
            else {
                return false;
            }
        }

        return $address->id;
    }

    public function addressObj($address)
    {
        $address_data = $address->address;
        $address_data["id"] = $address->id;
        $address_data["type"] = $address->type;
        $address_data["default"] = $address->default;

        return $address_data;
    }
}
