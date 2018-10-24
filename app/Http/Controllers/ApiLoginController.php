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
        if ($validator->fails()) return json_encode(["message"=> $validator->errors()->first(), 'success'=> false]);

        $otp = $request->session()->get('otp', false);
        $otp_expiry = $request->session()->get('otp_expiry', false);
        if($otp != $data['otp']) return json_encode(["message"=> 'The entered OTP is invalid. Please try again.', 'success'=> false]);
        if($otp_expiry < Carbon::now()->timestamp) return json_encode(["message"=> 'The entered OTP is Expired', 'success'=> false]);

        return $this->fetchUserDetails($data, $request);
    }

    public function fetchUserDetails($data, $request)
    {
        $UserObject = $this->createAuthenticateUser($data, $request);
        $token = $this->fetchAccessToken($UserObject);
        $UserObject->api_token = $token->id;
        $UserObject->save();
        
        $id = $request->session()->get('active_cart_id', false);
        if($id) {
            $user = ["id"=> $UserObject->id, 'active_cart_id'=> $id];
        }
        else {
            $user = ["id"=> $UserObject->id];
        }
        return json_encode(["message"=> 'user login successful', 'user'=> $user, 'token'=> $token->id, 'success'=> true]);
    }

    public function createAuthenticateUser($data, $request)
    {
        $id = $request->session()->get('active_cart_id', false);

        $UserObject = $this->checkUserExists($data);

        if($UserObject) {
            $cart = Cart::find($UserObject->cart_id);
        	if ($cart != null && count($cart->cart_data) == 0 && $id) {
                if($id != $cart->id) $cart->delete();
                $cart = Cart::find($id);
            }
            elseif ($id) {
                $cart = Cart::find($id);
                if($cart->user_id == null) {
                    $cart->user_id = $UserObject->id;
                    $cart->save();
                    $UserObject->cart_id = $cart->id;
                    $UserObject->save();
                }
                else {
                    $cart = new Cart;
                    $cart->save();
                }
            }
            elseif ($cart == null) {
                $cart = new Cart;
                $cart->save();
            }
            $request->session()->put('active_cart_id', $cart->id);
        }
        else {
            $cart = ($id) ? Cart::find($id) : null;
            if($cart == null || $cart->user_id != null) {
                $cart = new Cart;
                $cart->save();
            }
            $cart->save();

            $UserObject = User::create([
                'name' => '',
                'phone' => $data['phone'],
                'cart_id' => $cart->id,
            ]);

            $cart->user_id = $UserObject->id;
            $cart->save();

            $request->session()->put('active_cart_id', $cart->id);

            $UserObject->assignRole('customer');

            $this->createAccessToken($UserObject);
        }

        Auth::guard()->login($UserObject);

        return $UserObject;
    }

    /*public function login() {
    	Auth::guard()->login($user);
    }*/

    public function checkUserExists($data)
    {
        $user = NULL;
        try {
            $user = User::where('phone', '=', $data['phone'])->first();
        } catch (Exception $e) {
            $user = NULL;
        }

        return $user;
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
