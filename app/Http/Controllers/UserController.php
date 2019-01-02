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

class UserController extends Controller
{
    public function sendSMS(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) return response()->json(["message"=> $validator->errors()->first(), 'success'=> false]);

    	$otp = generateOTP();
        $otp_expiry = Carbon::now()->addMinutes(config('otp.expiry'));
        $request->session()->put('otp', $otp);
        $request->session()->put('otp_expiry', $otp_expiry->timestamp);

    	$sms = new \Ajency\Comm\Models\SmsRecipient();
        $sms->setTo(['91'.$data['phone']]);
        $sms->setMessage($otp.' is the OTP to verify your number with KidSuperStore. It will expire in '.config('otp.expiry').' minutes.');
        $sms->setOverride(true);// to send to DND numbers
        $notify = new \Ajency\Comm\Communication\Notification();
        $notify->setEvent('send-otp');
        $notify->setRecipientIds([$sms]);
        \AjComm::sendNotification($notify);

        return response()->json(["message"=> "OTP Sent successfully", 'success'=> true]);
    }
    public function verifyOTP(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateOTP($data);
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
        $token = fetchAccessToken($UserObject);
        $UserObject->api_token = $token->id;
        $UserObject->save();
        
        $id = $UserObject->cart_id;
        $user = ["id"=> $UserObject->id, 'user_info'=> $UserObject->userDetails(), 'active_cart_id'=> $id];
        
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

            createAccessToken($UserObject);
        }

        request()->session()->forget('active_cart_id');

        Auth::guard()->login($UserObject);
        request()->session()->regenerate();

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

    public function validateOTP($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
            'otp' => 'required|digits:'.config('otp.length'),
        ]);
    }

    public function validateNumber($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
        ]);
    }

    public function saveUserDetails(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email']);
        $data			= $request->all();

        $user			= User::getUserByToken($request->header('Authorization'));
        $user->name		= $data['name'];
        $user->email	= $data['email'];
        $user->save();

        return response()->json(["message"=> "User info saved successfully", 'success'=> true]);
    }

    public function fetchUserInfo(Request $request)
    {
        $user                  = User::getUserByToken($request->header('Authorization'));
        $response['user_info'] = $user->userDetails();

        return response()->json($response);
    }
}
