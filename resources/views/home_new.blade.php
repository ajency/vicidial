<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Kidsuperstore</title>
  <base href="/">

  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0 shrink-to-fit=no'/>
  <link  rel="icon" type="image/x-icon" href="/img/kss_favicon.png" />
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#707279"/>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
  <link rel="stylesheet" href="views/kss-pwa/styles.css">
</head>
<body>
	<app-root></app-root>
	<noscript>Please enable JavaScript to continue using this application.</noscript>
	<script type="text/javascript" src="/views/kss-pwa/runtime.js"></script>
	<script type="text/javascript" src="/views/kss-pwa/polyfills.js"></script>
  <!-- <script type="text/javascript" src="/views/kss-pwa/scripts.js"></script> -->
	<script type="text/javascript" src="/views/kss-pwa/main.js"></script>

    <script>
          if ('serviceWorker' in navigator ) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
  </script>

  @include('includes.angular-foot')
</body>
</html>
