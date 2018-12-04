<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
<meta charset="utf-8">
<meta
 name='viewport'
 content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'
/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="theme-color" content="#707279" />
<link  rel="icon" type="image/x-icon" href="/img/kss_favicon.png" />

@empty($delaycss)
	<link rel="stylesheet" type="text/css" href="{{ mix('/css/kss.css') }}">
@endempty

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{{config("analytics.pixel_id")}}');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id={{config('analytics.pixel_id')}}&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

@yield('headjs')
{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}