<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SMSController extends Controller
{
    public function generateOTP()
    {
        $min = str_pad(1, config('otp.length'), 0);
        $max = str_pad(9, config('otp.length'), 9);
        $token = random_int($min, $max);
        return $token;
    }

    public function sendSMS(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) return json_encode(["message"=> $validator->errors()->first(), 'success'=> false]);

    	$otp = $this->generateOTP();
        $otp_expiry = Carbon::now()->addMinutes(config('otp.expiry'));
        $request->session()->put('otp', $otp);
        $request->session()->put('otp_expiry', $otp_expiry->timestamp);

    	/*$sms = new \Ajency\Comm\Models\SmsRecipient();
        $sms->setTo(['91'.$data['phone']]);
        $sms->setMessage($otp.' is the OTP to verify your number with KidSuperStore. It will expire in '.config('otp.expiry').' minutes.');
        $sms->setOverride(true);// to send to DND numbers
        $notify = new \Ajency\Comm\Communication\Notification();
        $notify->setEvent('send-otp');
        $notify->setRecipientIds([$sms]);
        \AjComm::sendNotification($notify);*/
        $data = array('name' => 'KSS Ajency', 'email' => 'kss@ajency.in', 'otp' => $otp, 'otp_expiry' => config('otp.expiry'));

        \Mail::send('email', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('OTP '.$data['otp'].' - time '.$data['otp_expiry']);
        });

        return json_encode(["message"=> "OTP Sent successfully", 'success'=> true]);
    }

    public function validateNumber($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
            //'otp' => 'required|digits:'.config('otp.length'),
        ]);
    }
}
