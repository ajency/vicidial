<?php

namespace App\Http\Controllers\v2;

use App\Cart;
use App\Http\Controllers\Controller;
use App\User;
use App\UserLogin;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function sendSMS(Request $request)
    {
        $data = $request->all();
        if ($data['token_verified']) {
            return response()->json(["message" => 'Token is already verified.', 'success' => false]);
        }

        $userObject = $request->user();

        $otp                   = generateOTP();
        $otp_expiry            = Carbon::now()->addMinutes(config('otp.expiry'));
        $userLogin             = UserLogin::firstOrNew(['phone' => $userObject->phone]);
        $userLogin->otp        = $otp;
        $userLogin->otp_expiry = $otp_expiry->toDateTimeString();
        $userLogin->attempts   = 0;
        $userLogin->save();

        sendSMS('send-otp', [
            'to'      => '91' . $userObject->phone,
            'message' => $otp . ' is the OTP to verify your number with KidSuperStore. It will expire in ' . config('otp.expiry') . ' minutes.',
        ], true);

        $response = ["message" => "OTP Sent successfully", 'success' => true];
        return response()->json(isNotProd() ? array_merge($response, ['OTP' => $otp]) : $response);
    }

    public function reSendSMS(Request $request)
    {
        $data = $request->all();
        if ($data['token_verified']) {
            return response()->json(["message" => 'Token is already verified.', 'success' => false]);
        }

        $userObject = $request->user();

        $userLogin = UserLogin::where(['phone' => $userObject->phone])->get()->first();
        if ($userLogin == null) {
            return response()->json(["message" => 'OTP not sent to this number. Please check the number.', 'success' => false]);
        }

        $otp_expiry            = Carbon::now()->addMinutes(config('otp.expiry'));
        $userLogin->otp_expiry = $otp_expiry->toDateTimeString();
        $userLogin->save();

        sendSMS('send-otp', [
            'to'      => '91' . $userObject->phone,
            'message' => $userLogin->otp . ' is the OTP to verify your number with KidSuperStore. It will expire in ' . config('otp.expiry') . ' minutes.',
        ], true);

        $response = ["message" => "OTP Sent successfully", 'success' => true];
        return response()->json(isNotProd() ? array_merge($response, ['OTP' => $userLogin->otp]) : $response);
    }

    public function verifyToken(Request $request)
    {
        $data = $request->all();
        if ($data['token_verified']) {
            return response()->json(["message" => 'Token is already verified.', 'success' => false]);
        }

        $validator = $this->validateOTP($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        $userObject = $request->user();

        $userLogin = UserLogin::where(['phone' => $userObject->phone])->get()->first();
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

        DB::table('oauth_access_tokens')->where('id', $data['token_id'])->update(['verified' => 1]);

        $cart = $this->userCart($data['active_cart'], $userObject, $data['token_id']);

        return response()->json(["message" => '', 'user' => ["id" => $userObject->id, 'active_cart_id' => $cart->id, 'user_info' => $userObject->userDetails()], 'permissions' => ['bag' => true, 'account' => true], 'success' => true]);
    }

    public function getToken(Request $request)
    {
        $data      = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        return $this->fetchUserDetails($data);
    }

    public function fetchUserDetails($data)
    {
        $authenticatedUser = $this->createAuthenticateUser($data);
        $userObject        = $authenticatedUser['userObject'];
        $tokenArr          = createAccessToken($userObject);
        $token             = $tokenArr->token;
        if ($userObject->api_token == null) {
            $userObject->api_token = $token->id;
            $userObject->save();
        }

        $user = ["id" => $userObject->id, 'active_cart_id' => $authenticatedUser['cart_id']];

        $token->cart_id = $authenticatedUser['cart_id'];
        $token->save();

        if ($authenticatedUser['new_user']) {
            $show_promt = false;
            $message    = '';
        } else {
            $show_promt = true;
            $message    = 'Looks like you already have an account with a save address. Sign in with OTP for faster checkout.';
        }

        return response()->json(["message" => $message, 'user' => $user, 'show_promt' => $show_promt, 'token' => $tokenArr->access_token, 'token_expires_at' => $token->expires_at->toDateTimeString(), 'permissions' => ['bag' => true, 'account' => false], 'success' => true]);
    }

    public function createAuthenticateUser($data)
    {
        $id = request()->session()->get('active_cart_id', false);

        $userObject = User::where('phone', '=', $data['phone'])->where('verified', '=', true)->first();

        $cart = ($id) ? Cart::find($id) : null;
        if ($cart == null || $cart->user_id != null) {
            $cart = new Cart;
            $cart->save();
        }

        if ($userObject) {
            $new_user = false;
        } else {
            $new_user = true;

            $userObject = User::create([
                'name'     => '',
                'phone'    => $data['phone'],
                'cart_id'  => $cart->id,
                'email'    => $data['phone'],
                'password' => bcrypt(defaultUserPassword($data['phone'])),
            ]);

            $userObject->verified = true;
            $userObject->assignRole('customer');
            $userObject->save();
        }

        $cart->user_id = $userObject->id;
        $cart->save();

        request()->session()->forget('active_cart_id');

        Auth::guard()->login($userObject);
        request()->session()->regenerate();

        return ['userObject' => $userObject, 'cart_id' => $cart->id, 'new_user' => $new_user];
    }

    public function userCart($id, $userObject, $token_id)
    {
        $cart = Cart::find($id);
        if ($cart->type != 'cart' || count($cartcheck->cart_data) > 0) {
            return $cart;
        }

        $tokenData = DB::table('oauth_access_tokens')->where('id', '!=', $token_id)->where('user_id', $userObject->id)->where('verified', 1)->orderBy('created_at', 'ASC')->get(['id', 'verified', 'cart_id'])->last;

        if ($tokenData != null) {
            $cartPrevious = Cart::find($tokenData['cart_id']);
            if ($cartPrevious->type != 'order-complete') {
                DB::table('oauth_access_tokens')->where('id', $token_id)->update(['cart_id' => $cartPrevious->id]);
                $cart->delete();
                $cart = $cartPrevious;
            }
        }
        return $cart;
    }

    public function validateOTP($data)
    {
        return $validator = Validator::make($data, [
            'otp' => 'required|digits:' . config('otp.length'),
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
            $tokenArr = $user->createPasswordGrantToken(defaultUserPassword($user->phone));
        }

        return response()->json(["message" => 'user token refreshed', 'token' => $tokenArr['access_token'], 'token_expires_at' => $tokenArr['expires_at'], 'success' => true]);
    }
}
