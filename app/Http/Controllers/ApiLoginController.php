<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends Controller
{
    public function createAuthenticateUser(Request $request)
    {
        $data = $request->all();

        $UserObject = $this->checkUserExists($data);

        if(!$UserObject) {
        	$validator = $this->validateUser($data);

        	if ($validator->fails()) return json_encode($validator->errors());

        	$UserObject = User::create([
	            'name' => '',
	            'phone' => $data['phone'],
	            'email' => $data['phone'],
	            'password' => Hash::make(str_random(10)),
	        ]);
        }

        Auth::guard()->login($UserObject);
        return json_encode($UserObject);
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

    public function validateUser($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10|unique:users',
        ]);
    }
}
