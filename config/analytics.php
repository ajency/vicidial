<?php

return [
    'google_id' => env("GOOGLE_ANALYTICS_ID"),
    'pixel_id'  => env("FACEBOOK_PIXEL_ANALYTICS_ID"),
    'js_dsn'  => env("SENTRY_JS_DSN"),
    'hotjar' =>
    [
    	'id' => env("HOTJAR_ID"),
    	'version' => env("HOTJAR_VERSION")
    ]
     
];
