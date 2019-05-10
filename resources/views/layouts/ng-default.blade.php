<!doctype html>
<html>
<head>
    @include('includes.ng-head')
</head>
<body>

	<app-root></app-root>
	<script type="text/javascript">
		var published_home = true;
	</script>

	@include('includes.ng-scripts')

	@php
		$fileHashes = json_decode(file_get_contents(public_path().'/angular_file_hash.json'),true);
	@endphp

	<noscript>Please enable JavaScript to continue using this application.</noscript>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/runtime.'.$fileHashes['runtime'].'.js') }}"></script>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/polyfills.'.$fileHashes['polyfills'].'.js') }}"></script>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/scripts.'.$fileHashes['scripts'].'.js') }}"></script>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/main.'.$fileHashes['main'].'.js') }}"></script>
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
	<script> window._peq = window._peq || []; window._peq.push(["init"]); </script>
	<script src="https://clientcdn.pushengage.com/core/c9eafc08eddfe6530ece153bdd5f12c3.js" async></script>

	@include('includes.ng-foot')

</body>
</html>