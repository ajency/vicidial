<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
<meta charset="utf-8">
<meta
 name='viewport'
 content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'
/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="google-site-verification" content="SntaXthhmMlR2wlwpcynb3PYim7wcDSpSpq2rrx8t0I" />
<meta name="theme-color" content="#707279" />
<link  rel="icon" type="image/x-icon" href="/img/kss_favicon.png" />

<!-- <meta name="ng-inline" content="{{CDN::asset('/js/cart/inline.bundle.js') }}">
<meta name="ng-vendor" content="{{CDN::asset('/js/cart/vendor.bundle.js') }}">
<meta name="ng-polyfills" content="{{CDN::asset('/js/cart/polyfills.bundle.js') }}">
<meta name="ng-main" content="{{CDN::asset('/js/cart/main.bundle.js') }}"> -->

@empty($delaycss)
	<link rel="stylesheet" type="text/css" href="{{CDN::mix('/css/kss.css') }}">
@endempty

@yield('headjs')
{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}