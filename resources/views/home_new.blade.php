@extends('layouts.ng-default')

<script type="text/javascript">

	function getUrlVars() {
    var params = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        params[key] = value;
    });
    return params;
	}

	function getCookie(name) {
    var cookie_found = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return cookie_found ? cookie_found[2] : null;
	}

	function set_new_cookie(cookie_name, cookie_value, expiration_in_days) {
		var new_cookie_string = '';
		// Build the expiration date string:
		var cookie_expiration_date = new Date();
		// cookie_expiration
		cookie_expiration_date.setTime(cookie_expiration_date.getTime() + (expiration_in_days*24*60*60*1000));
		// Build the set-cookie string:
		new_cookie_string = cookie_name + "=" + cookie_value + "; path=/; expires=" + cookie_expiration_date.toUTCString();
		// Create or update new KSS cookie:
		document.cookie = new_cookie_string;

		return;
	}

	window.onload = function() {
	  // do stuff to load your page
		var tduid_url_param = getUrlVars()["tduid"];
		if(tduid_url_param){
			set_new_cookie("TRADEDOUBLER", tduid_url_param, 10);
		}
	};

</script>
