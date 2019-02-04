<?php

return [
    'google_id' => env("GOOGLE_ANALYTICS_ID"),
    'google_pixel_id' => env("GOOGLE_PIXEL_TRACKING_ID"),
    'conversion_id' => env("GOOGLE_CONVERSION_ID"),
    'conversion_label' => env("GOOGLE_CONVERSION_LABEL"),
    'pixel_id'  => env("FACEBOOK_PIXEL_ANALYTICS_ID"),
    'js_dsn'  => env("SENTRY_JS_DSN"),
    'hotjar' =>
    [
    	'id' => env("HOTJAR_ID"),
    	'version' => env("HOTJAR_VERSION")
    ]
     
];
