@isset($delaycss)
<noscript id="deferred-styles">
	<link rel="stylesheet" type="text/css" href="{{CDN::mix('/css/kss.css') }}">
</noscript>
<script>
  var loadDeferredStyles = function() {
    var addStylesNode = document.getElementById("deferred-styles");
    var replacement = document.createElement("div");
    replacement.innerHTML = addStylesNode.textContent;
    document.body.appendChild(replacement)
    addStylesNode.parentElement.removeChild(addStylesNode);
  };
  var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
  else window.addEventListener('load', loadDeferredStyles);
</script>
@endisset

<script type="text/javascript">
  // Google pixel tracking id
  var google_pixel_id = "{{config('analytics.google_pixel_id')}}";
  var google_conversion_id = "{{config('analytics.conversion_id')}}";
</script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-url-parser/2.3.1/purl.min.js"></script>
<script src="https://apis.google.com/js/platform.js"></script>
<script type="text/javascript" src="{{CDN::mix('/js/cart.js') }}"></script>

<!-- sentry code -->
<script src="https://browser.sentry-cdn.com/4.4.1/bundle.min.js" crossorigin="anonymous"></script>
<script>Sentry.init({ dsn: '{{config("analytics.js_dsn")}}', environment : '{{config("app.env")}}' });</script>

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

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{config('analytics.google_id')}}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', "{{config('analytics.google_id')}}");
</script>

<!-- Google pixel tracking -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{config('analytics.google_pixel_id')}}"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', "{{config('analytics.google_pixel_id')}}");
</script>

<!-- Hotjar Tracking Code -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:'{{config("analytics.hotjar.id")}}',hjsv:'{{config("analytics.hotjar.version")}}'};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

@yield('footjs')
<script type="text/javascript">
	window.lazySizesConfig = window.lazySizesConfig || {};
	lazySizesConfig.loadMode = 3;
  lazySizesConfig.loadHidden = false;
</script>


<script type="text/javascript" src="{{CDN::mix('/js/kss.js') }}"></script>

