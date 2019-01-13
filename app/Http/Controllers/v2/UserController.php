<?php

namespace App\Http\Controllers\v2;

use App\Cart;
use App\Http\Controllers\Controller;
use App\User;
use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function sendSMS(Request $request)
    {
        $data      = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        $otp                   = generateOTP();
        $otp_expiry            = Carbon::now()->addMinutes(config('otp.expiry'));
        $userLogin             = UserLogin::firstOrNew(['phone' => $data['phone']]);
        $userLogin->otp        = $otp;
        $userLogin->otp_expiry = $otp_expiry->toDateTimeString();
        $userLogin->attempts   = 0;
        $userLogin->save();

        sendSMS('send-otp', [
            'to'      => '91' . $data['phone'],
            'message' => $otp . ' is the OTP to verify your number with KidSuperStore. It will expire in ' . config('otp.expiry') . ' minutes.',
        ], true);

        $response = ["message" => "OTP Sent successfully", 'success' => true];
        return response()->json(isNotProd() ? array_merge($response, ['OTP' => $otp]) : $response);
    }

    public function reSendSMS(Request $request)
    {
        $data      = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        $userLogin = UserLogin::where(['phone' => $data['phone']])->get()->first();
        if ($userLogin == null) {
            return response()->json(["message" => 'OTP not sent to this number. Please check the number.', 'success' => false]);
        }

        $otp_expiry            = Carbon::now()->addMinutes(config('otp.expiry'));
        $userLogin->otp_expiry = $otp_expiry->toDateTimeString();
        $userLogin->save();

        sendSMS('send-otp', [
            'to'      => '91' . $data['phone'],
            'message' => $userLogin->otp . ' is the OTP to verify your number with KidSuperStore. It will expire in ' . config('otp.expiry') . ' minutes.',
        ], true);

        $response = ["message" => "OTP Sent successfully", 'success' => true];
        return response()->json(isNotProd() ? array_merge($response, ['OTP' => $userLogin->otp]) : $response);
    }

    public function verifyOTP(Request $request)
    {
        $data      = $request->all();
        $validator = $this->validateOTP($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        $userLogin = UserLogin::where(['phone' => $data['phone']])->get()->first();
        if ($userLogin == null) {
            return response()->json(["message" => 'OTP not sent to this number. Please check the number.', 'success' => false]);
        }

        if ((new Carbon($userLogin->otp_expiry))->timestamp < Carbon::now()->timestamp) {
            return response()->json(["message" => 'The entered OTP is Expired. Please send OTP again.', 'success' => false]);
        }

        if ($userLogin->attempts >= config('otp.attempts')) {
            return response()->json(["message" => 'You have exceeded the maximum number of attempts. Please send OTP again.', 'success' => false]);
        }

        if ($userLogin->otp != $data['otp']) {
            $userLogin->attempts += 1;
            $userLogin->save();
            return response()->json(["message" => 'The entered OTP is invalid. Please try again.', 'success' => false]);
        }

        $userLogin->delete();

        return $this->fetchUserDetails($data);
    }

    public function fetchUserDetails($data)
    {
        $UserObject = $this->createAuthenticateUser($data);
        if (isLocalSetup()) {
            $tokenArr = $UserObject->createPersonalAccessToken();
        } else {
            $tokenArr = $UserObject->createPasswordGrantToken(defaultUserPassword());
        }
        $UserObject->api_token = fetchAccessToken($UserObject)->id;
        $UserObject->save();

        $id   = $UserObject->cart_id;
        $user = ["id" => $UserObject->id, 'user_info' => $UserObject->userDetails(), 'active_cart_id' => $id];

        return response()->json(["message" => 'user login successful', 'user' => $user, 'token' => $tokenArr['access_token'], 'token_expires_at' => $tokenArr['expires_at'], 'success' => true]);
    }

    public function createAuthenticateUser($data)
    {
        $id = request()->session()->get('active_cart_id', false);

        $UserObject = User::where('phone', '=', $data['phone'])->first();

        if ($UserObject) {
            $cart = $this->userCart($id, $UserObject);
        } else {
            $cart = ($id) ? Cart::find($id) : null;
            if ($cart == null || $cart->user_id != null) {
                $cart = new Cart;
                $cart->save();
            }

            $UserObject = User::create([
                'name'     => '',
                'phone'    => $data['phone'],
                'cart_id'  => $cart->id,
                'email'    => $data['phone'],
                'password' => bcrypt(defaultUserPassword()),
            ]);

            $cart->user_id = $UserObject->id;
            $cart->save();

            $UserObject->assignRole('customer');
        }

        request()->session()->forget('active_cart_id');

        Auth::guard()->login($UserObject);
        request()->session()->regenerate();

        return $UserObject;
    }

    public function userCart($id, $UserObject)
    {
        $cart         = null;
        $user_cart_id = $UserObject->cart_id;
        if ($id) {
            $cart = Cart::find($id);
            if ($cart != null && $cart->user_id != null) {
                $cart = null;
            } elseif ($cart != null) {
                $cart->user_id = $UserObject->id;
                $cart->save();
                $UserObject->cart_id = $cart->id;
                $UserObject->save();
            }
        }

        if ($cart == null) {
            $cart = Cart::find($user_cart_id);
        } else {
            $cartcheck = Cart::find($user_cart_id);
            if (count($cartcheck->cart_data) == 0) {
                $cartcheck->delete();
            }
        }

        return $cart;
    }

    public function validateOTP($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
            'otp'   => 'required|digits:' . config('otp.length'),
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
        $data = $request->all();

        $user           = $request->user();
        $user->name     = $data['name'];
        $user->email_id = $data['email'];
        $user->save();

        return response()->json(["message" => "User info saved successfully", 'success' => true]);
    }

    public function fetchUserInfo(Request $request)
    {
        $user                  = $request->user();
        $response['user_info'] = $user->userDetails();

        return response()->json($response);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();

        if (isLocalSetup()) {
            $tokenArr = $user->createPersonalAccessToken();
        } else {
            $tokenArr = $user->createPasswordGrantToken(defaultUserPassword());
        }

        return response()->json(["message" => 'user token refreshed', 'token' => $tokenArr['access_token'], 'token_expires_at' => $tokenArr['expires_at'], 'success' => true]);
    }
}
