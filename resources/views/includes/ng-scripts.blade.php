<script type="text/javascript">
  // Google pixel tracking id
  /* <![CDATA[ */
  var google_pixel_id = "{{config('analytics.google_pixel_id')}}";
  var google_conversion_id = @php echo config('analytics.conversion_id'); @endphp;
  var google_conversion_label = "{{config('analytics.conversion_label')}}";
  var google_conversion_value = 1.0;
  var google_conversion_data = "AW-{{config('analytics.conversion_id')}}/{{config('analytics.conversion_label')}}";
  // var product_catalog_id = "{{config('analytics.fb_pixel_catalog_id')}}"
    /* ]]> */
</script>

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
	// fbq('track', 'PageView');

	var product_catalog_id = "{{config('analytics.fb_pixel_catalog_id')}}"

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	function fbTrackViewContent(default_price, parent_id, selected_color_id){
		console.log("fbTrackViewContent ==>", default_price, parent_id, selected_color_id);
		fbq('track', 'ViewContent', {
			value: default_price,
			currency: 'INR',
			content_ids: parent_id+'-'+selected_color_id,
			content_type: 'product_group'
		});
	}

	// Google analytic pixel tracking
	function gtagTrackPageView(default_price, parent_id, selected_color_id){
		console.log("gtagTrackPageView ==>", default_price, parent_id, selected_color_id)
		gtag('event', 'page_view', {
			'send_to': google_pixel_id,
			'ecomm_pagetype': 'list',
			'ecomm_prodid': parent_id+'-'+selected_color_id,
			'ecomm_totalvalue': default_price,
			'user_id': getCookie('user_id')
		});
	}

	function runMicrodataScript(product, price, in_stock = true){
		console.log("runMicrodataScript function", product);
		var el = document.createElement('script');
		el.type = 'application/ld+json';
		var productMicrodata = {
			"@context":"https://schema.org",
			"@type":"Product",
			"productID": product.attributes.product_id+'-'+product.facets.product_color_html.id,
			"name": product.attributes.product_title,
			"description": product.attributes.product_description,
			"url": window.location.href,
			"image": product.images.length ? product.images[0].main['1x'] : 'https://kidsuperstore.in/img/placeholder.svg',
			"brand": product.facets.product_brand.slug,
			"offers":[
				{
					"@type":"Offer",
					"price": price,
					"priceCurrency":"INR",
					"itemCondition":"new",
					"availability": in_stock ? 'in stock' : 'out of stock'
				}
			]
		}
		el.text = JSON.stringify(productMicrodata);
		document.querySelector('body').appendChild(el);
	}

	function gtagTrackListPage(){
		gtag('event', 'page_view', {
		  'send_to': google_pixel_id,
		  'ecomm_pagetype': 'category',
		  'ecomm_prodid': '',
		  'ecomm_totalvalue': '',
		  'user_id': getCookie('user_id')
		});
	}


	function fbTrackAddToCart(sale_price,parent_id,selected_color_id){    
	    fbq('track', 'AddToCart', {
	        value: sale_price,
	        currency: 'INR',
	        content_ids: parent_id+'-'+selected_color_id
	    });
	}	
</script>

<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{config('analytics.pixel_id')}}&ev=PageView&noscript=1"
/></noscript>

<script async src="https://www.googletagmanager.com/gtag/js?id={{config('analytics.google_pixel_id')}}"></script>

<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', "{{config('analytics.google_pixel_id')}}");
</script>