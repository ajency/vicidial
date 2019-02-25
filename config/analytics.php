<?php

return [
    'google_id' => env("GOOGLE_ANALYTICS_ID",""),
    'google_pixel_id' => env("GOOGLE_PIXEL_TRACKING_ID",""),
    'conversion_id' => env("GOOGLE_CONVERSION_ID",""),
    'conversion_label' => env("GOOGLE_CONVERSION_LABEL",""),
    'pixel_id'  => env("FACEBOOK_PIXEL_ANALYTICS_ID",""),
    'fb_pixel_catalog_id' => env("FACEBOOK_PIXEL_PRODUCT_CATALOG_ID",""),
    'js_dsn'  => env("SENTRY_JS_DSN",""),
    'google_optimize'  => env("GOOGLE_OPTIMIZE_ID",""),
    'google_tag_manager'  => env("GOOGLE_TAGMANAGER_ID",""),
    'hotjar' =>
    [
    	'id' => env("HOTJAR_ID",""),
    	'version' => env("HOTJAR_VERSION","")
    ]

];
