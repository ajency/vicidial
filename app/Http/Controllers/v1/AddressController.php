<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Address;
use App\User;
use App\Defaults;
use App\Variant;
use App\Cart;
use App\Pincode;

class AddressController extends Controller
{
    public function userAddAddress(Request $request)
    {
    	$request->validate(['default' => 'required', 'name' => 'required', 'phone' => 'required|digits:10', 'pincode' => 'required|digits:6', 'state_id' => 'required|numeric', 'address' => 'required', 'landmark' => 'present', 'city' => 'required']);
    	$params  = $request->all();
    	$user_id = User::getUserByToken($request->header('Authorization'))->id;

    	$default = $this->defaultAddressSet($user_id, $params["default"]);

        $state = Defaults::find($params["state_id"]);
        if ($state == null) abort(403);

    	$address = new Address;
        $address->address = ["name" => $params["name"], "phone" => $params["phone"], "pincode" => $params["pincode"], "state_id" => $state->id, "state_odoo_id" => $state->meta_data['odoo_id'], "state" => $state->label, "address" => $params["address"], "landmark" => $params["landmark"], "city" => $params["city"]];
        $address->default = $default;
        $address->user_id = $user_id;
        $address->save();

        return json_encode(["address"=> $address->shippingAddress(true), "message"=> "Address Added successfully", 'success'=> true]);
    }

    public function userEditAddress(Request $request)
    {
        $request->validate(['default' => 'required', 'name' => 'required', 'phone' => 'required|digits:10', 'pincode' => 'required|digits:6', 'state_id' => 'required|numeric', 'address' => 'required', 'landmark' => 'present', 'city' => 'required']);
        $params  = $request->all();
        $user_id = User::getUserByToken($request->header('Authorization'))->id;

        $address = Address::find($params["id"]);
        if($address->user_id != $user_id) abort(403);

        $state = Defaults::find($params["state_id"]);
        if ($state == null) abort(403);

        $default = $this->defaultAddressSet($user_id, $params["default"], $address->id);

        $address->address = ["name" => $params["name"], "phone" => $params["phone"], "pincode" => $params["pincode"], "state_id" => $state->id, "state_odoo_id" => $state->meta_data['odoo_id'], "state" => $state->label, "address" => $params["address"], "landmark" => $params["landmark"], "city" => $params["city"]];
        $address->default = $default;
        $address->user_id = $user_id;
        $address->save();

        return json_encode(["address"=> $address->shippingAddress(true), "message"=> "Address Updated successfully", 'success'=> true]);
    }

    public function userFetchAddresses(Request $request)
    {
        $user = User::getUserByToken($request->header('Authorization'));

        $params  = $request->all();
        if(isset($params['cart_id'])) {
            $cart = Cart::find($params['cart_id']);
            validateCart($user, $cart, 'cart');
            foreach ($cart->cart_data as $variant_id => $variant_details) {
                $variant = Variant::find($variant_id);
                if ($variant->getQuantity() < $variant_details['quantity']) {
                    abort(404, "Quantity not available");
                }
            }
            
            if(!$cart->isPromotionApplicable($cart->promotion)) {
                abort(404, "Promotion not applicable");
            }
        }

        $addresses = Address::where('user_id', '=', $user->id)->where('active', '=', true)->get();

        $address_data = array();

        foreach ($addresses as $address) {
            $address_data[] = $address->shippingAddress(true);
        }

        return json_encode(["addresses"=> $address_data, "user_info" = $user->userDetails()]);
    }

    public function userDeleteAddress(Request $request)
    {
        $request->validate(['address_id' => 'required|exists:addresses,id']);
        $params  = $request->all();
        $user = User::getUserByToken($request->header('Authorization'));

        $address = Address::find($params["address_id"]);
        validateAddress($user, $address);

        $address->active = false;
        $address->save();

        $default = $this->defaultAddressFirst($user->id);

        return json_encode(["default_id"=> $default, "message"=> "Address Deleted successfully", 'success'=> true]);
    }

    public function defaultAddressSet($user_id, $default, $address_id = null)
    {
    	$address = Address::where('user_id', '=', $user_id)->where('active', '=', true)->where('default', '=', true)->first();
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
        $address = Address::where('user_id', '=', $user_id)->where('active', '=', true)->where('default', '=', true)->first();
        if($address == null) {
            $address = Address::where('user_id', '=', $user_id)->where('active', '=', true)->first();
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

    public function fetchStates(Request $request)
    {
        $states = Defaults::where('type', '=', 'state')->get();
        $statesArr = array();
        foreach ($states as $state) {
            $statesArr[] = array('id' => $state->id, 'state' => $state->label);
        }
        
        return $statesArr;
    }

    public function fetchPincode($pincode, Request $request)
    {
        $pincode_entry = Pincode::where('pincode', '=', $pincode)->where('deliverable', '=', true)->get()->first();
        if($pincode_entry == null){
            abort(403);
        }
        
        return json_encode(['district' => $pincode_entry['district'], 'state_id' => $pincode_entry['state_id']]);
    }
}
