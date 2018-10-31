<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Cart;

class ApiLoginController extends Controller
{
    public function verifyOTP(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) return response()->json(["message"=> $validator->errors()->first(), 'success'=> false]);

        $otp = $request->session()->get('otp', false);
        $otp_expiry = $request->session()->get('otp_expiry', false);
        if($otp != $data['otp']) return response()->json(["message"=> 'The entered OTP is invalid. Please try again.', 'success'=> false]);
        if($otp_expiry < Carbon::now()->timestamp) return response()->json(["message"=> 'The entered OTP is Expired', 'success'=> false]);

        return $this->fetchUserDetails($data);
    }

    public function fetchUserDetails($data)
    {
        $UserObject = $this->createAuthenticateUser($data);
        $token = $this->fetchAccessToken($UserObject);
        $UserObject->api_token = $token->id;
        $UserObject->save();
        
        $id = request()->session()->get('active_cart_id', false);
        if($id) {
            $user = ["id"=> $UserObject->id, 'active_cart_id'=> $id];
        }
        else {
            $user = ["id"=> $UserObject->id];
        }
        return response()->json(["message"=> 'user login successful', 'user'=> $user, 'token'=> $token->id, 'success'=> true]);
    }

    public function createAuthenticateUser($data)
    {
        $id = request()->session()->get('active_cart_id', false);

        $UserObject = User::where('phone', '=', $data['phone'])->first();

        if($UserObject) {
            $cart = $this->userCart($id, $UserObject);
        }
        else {
            $cart = ($id) ? Cart::find($id) : null;
            if($cart == null || $cart->user_id != null) {
                $cart = new Cart;
                $cart->save();
            }

            $UserObject = User::create([
                'name' => '',
                'phone' => $data['phone'],
                'cart_id' => $cart->id,
            ]);

            $cart->user_id = $UserObject->id;
            $cart->save();

            $UserObject->assignRole('customer');

            $this->createAccessToken($UserObject);
        }

        request()->session()->put('active_cart_id', $cart->id);

        Auth::guard()->login($UserObject);

        return $UserObject;
    }

    public function userCart($id, $UserObject)
    {
        $cart = null;
        $user_cart_id = $UserObject->cart_id;
        if($id) {
            $cart = Cart::find($id);
            if($cart != null && $cart->user_id != null) {
                $cart = null;
            }
            elseif($cart != null) {
                $cart->user_id = $UserObject->id;
                $cart->save();
                $UserObject->cart_id = $cart->id;
                $UserObject->save();
            }
        }

        if($cart == null) {
            $cart = Cart::find($user_cart_id);
        }
        else {
            $cartcheck = Cart::find($user_cart_id);
            if(count($cartcheck->cart_data) == 0) {
                $cartcheck->delete();
            }
        }

        return $cart;
    }

    public function validateNumber($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
            'otp' => 'required|digits:'.config('otp.length'),
        ]);
    }

    public function createAccessToken($UserObject)
    {
        $UserObject->createToken('KSS_USER')->accessToken;
    }

    public function fetchAccessToken($UserObject)
    {
        return $token = $UserObject->tokens->first();
    }
}
