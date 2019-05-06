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

	<noscript>Please enable JavaScript to continue using this application.</noscript>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/runtime.js') }}"></script>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/polyfills.js') }}"></script>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/scripts.js') }}"></script>
	<script type="text/javascript" src="{{CDN::asset('/js/kss-pwa/main.js') }}"></script>
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

	@include('includes.ng-foot')

</body>
</html>