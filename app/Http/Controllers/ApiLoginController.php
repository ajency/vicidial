<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class ApiLoginController extends Controller
{
    public function verifyOTP(Request $request)
    {
        //$role = Role::create(['name' => 'customer']);
        //$role = Role::findByName('customer');
        $data = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) return json_encode(["message"=> $validator->errors()->first(), 'success'=> false]);

        $otp = $request->session()->get('otp', false);
        $otp_expiry = $request->session()->get('otp_expiry', false);
        if($otp != $data['otp']) return json_encode(["message"=> 'The entered OTP is invalid. Please try again.', 'success'=> false]);
        if($otp_expiry < Carbon::now()->timestamp) return json_encode(["message"=> 'The entered OTP is Expired', 'success'=> false]);

        $UserObject = $this->createAuthenticateUser($data);
        $token = $UserObject->tokens->first();
        $id = $request->session()->get('active_cart_id', false);
        if($id) {
            $user = ["id"=> $UserObject->id, 'active_cart_id'=> $id];
        }
        else {
            $user = ["id"=> $UserObject->id];
        }
        return json_encode(["message"=> 'user login successful', 'user'=> $user, 'token'=> $token, 'success'=> true]);
    }

    public function createAuthenticateUser($data)
    {
        $UserObject = $this->checkUserExists($data);

        if(!$UserObject) {
        	$UserObject = User::create([
	            'name' => '',
	            'phone' => $data['phone'],
	            'email' => $data['phone'],
	            'password' => Hash::make(str_random(10)),
	        ]);

            $UserObject->assignRole('customer');

            $UserObject->createToken('KSS_USER')->accessToken;
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
}
