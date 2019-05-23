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

	function removeURLParameter(url, parameter) {
		//prefer to use l.search if you have a location/link object
		var urlparts = url.split('?');
		if (urlparts.length >= 2) {

			var prefix = encodeURIComponent(parameter) + '=';
			var pars = urlparts[1].split(/[&;]/g);

			//reverse iteration as may be destructive
			for (var i = pars.length; i-- > 0;) {
				//idiom for string.startsWith
				if (pars[i].lastIndexOf(prefix, 0) !== -1) { 
					pars.splice(i, 1);
				}
			}

			return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
		}
		return url;
	}

	function redirTo() {
		var strReturn = "";
		var strHref = document.location.href;
		if ( strHref.indexOf("&url=") > -1 ) {
			strReturn = strHref.substr(strHref.indexOf("&url=")+5);
		} else {
			// Change URL to the default landing page/homepage.
			strReturn = removeURLParameter(document.location.href, 'tduid') ;
		}
		return strReturn;
	}

	var new_cookie_name =  '{{ config("orders.cash_back_world.cookie_name") }}';
	var tduid_url_param = getUrlVars()["tduid"];
	if(tduid_url_param && tduid_url_param.match("^[A-z0-9]+$")){
		set_new_cookie(new_cookie_name, tduid_url_param, 10);
		window.location = redirTo();
	}

</script>
