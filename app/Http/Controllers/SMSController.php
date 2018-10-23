<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AjComm;

class SMSController extends Controller
{
    public function generateOTP()
    {
        $min = str_pad(1, 6, 0);
        $max = str_pad(9, 6, 9);
        $token = random_int($min, $max);
        return $token;
    }

    public function sendSMS()
    {
    	$otp = generateOTP();
    	$sms = new \Ajency\Comm\Models\SmsRecipient();
        $sms->setTo(['919766519526']);
        $sms->setMessage('Hi, KSS');
        $sms->setOverride(true);// to send to DND numbers
        $notify = new \Ajency\Comm\Communication\Notification();
        $notify->setEvent('send-otp');
        $notify->setRecipientIds([$sms]);
        AjComm::sendNotification($notify);
    }
}
