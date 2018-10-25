<?php
return [
    "email" => ["provider" => "laravel" , "password" => "" , "username" => "", 'from_address'=>'', 'from_name'=>'Example'],
    "sms" => ["provider" => "smsgupshup" , "password" => env('SMS_GUPSHUP_PASSWORD','') , "username" => env('SMS_GUPSHUP_USERNAME','')],
    "web-push" => ["provider" => "pushcrew" , "password" => "" , "username" => ""],
    "email-internal" => ["provider" => false , "password" => "" , "username" => ""],
    "email-promotional" => ["provider" => false , "password" => "" , "username" => ""],
    "sms-promotional" => ["provider" => false , "password" => "" , "username" => ""]
];
