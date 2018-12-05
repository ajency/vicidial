<!-- Loop all products -->
<script id="products-list-template" type="text/x-handlebars-template">
 <div id="card-list" class="row">
  @{{#each products}}
  <div class="col-lg-4 col-md-6 mb-sm-4 col-6  ">

	  <div class="card h-100 product-card">

	  	<!-- Wishlist -->
	    <!-- <i class="fas fa-heart kss_heart"></i> -->
	    <!-- Product Image Display -->
	    <a href="/@{{slug_name}}/buy" class="position-relative" title="@{{title}}">
	      <div class="product-card__wrapper loading d-flex align-items-center justify-content-center mb-2 mb-sm-3">
	        <div class="overlay"></div>
	        @{{assign "image_1x" '/img/placeholder.svg'}}
	        @{{assign "image_2x" '/img/placeholder.svg'}}
	        @{{assign "image_3x" '/img/placeholder.svg'}}
	        @{{assign "load_10x" '/img/placeholder-10x.jpg'}}
	        @{{assign "default_placeholder_cls" "placeholder-img" }}
	        @{{#ifImagesExist images }}
	        	@{{assign "image_1x" images.1x }}
		        @{{assign "image_2x" images.2x }}
		        @{{assign "image_3x" images.3x }}
		        @{{assign "load_10x" images.load }}
		        @{{assign "default_placeholder_cls" "" }}
	        @{{/ifImagesExist}}
	        <img src="@{{@root.load_10x}}" data-srcset="@{{@root.image_1x}} 270w, @{{@root.image_2x}} 540w, @{{@root.image_3x}} 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="lazyload card-img-top blur-up @{{@root.default_placeholder_cls}}"  title="@{{title}}" alt="@{{title}}" />

	      </div>
	    </a>
	    <!-- Product Info -->
	    <div class="
	    -body">
	      @{{#if title}}
	      <a href="/@{{slug_name}}/buy" class="text-dark">
	        <h5 class="section-heading section-heading--list mb-1 mb-sm-2">
	          @{{title}}
	        </h5>
	      </a>
	      @{{/if}}
	      <!-- Calculate & Display Price -->
	        @{{#each variants}}
		        @{{#if is_default}}
		        	<div class="d-sm-flex align-items-sm-center mb-2 mb-sm-0">
		        		@{{#ifEquals ../product_availability false}}
		        			<div class="out-of-stock out-of-stock--list p-0 text-left">Currently unavailable</div>
		        		@{{else}}
				        	@{{#ifEquals list_price sale_price }}
				        		<div id="kss-price-@{{../product_id}}-@{{../color_id}}" class="kss-price kss-price--smaller">₹@{{sale_price}}</div>
				        	@{{else}}
				        		<div id="kss-price-@{{../product_id}}-@{{../color_id}}" class="kss-price kss-price--smaller">₹@{{sale_price}} <small class="kss-original-price text-muted">₹@{{list_price}}</small><span class="kss-discount text-danger">@{{discount_per}}% OFF</span></div>
				        	@{{/ifEquals}}
			        	@{{/ifEquals}}
		        	</div>
		        @{{/if}}
	        @{{/each}}
	    </div>
	  </div>
	</div>
  @{{/each}}
  </div>
  <p class="my-4 product-view text-center d-none">You've viewed 42 of 45 products</p>
  <div class="text-center mt-4 mb-0 mb-sm-4 pt-4 pb-0 pb-sm-4 @{{#if show_more }} @{{else}} d-none @{{/if}}">
  	<button href="javascript:void(0);" class="d-flex align-items-center justify-content-center btn more-products-btn m-auto" id="showMoreProductsBtn">
		<i class="load-icon-cls align-middle fa-circle-notch fa-lg fa-spin fas mr-2 d-none"></i> Show more products 
	</button>
  </div>
</script>

<div id="products-list-template-content" class="productlist__row"></div>
<div class="@if(count((array)$items)>0) d-none @endif productlist__na">
  @include('includes.no-products-content')
</div>

@section('footjs-products-list')
  <script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("products-list-template").innerHTML;
   var template = Handlebars.compile(source);
   Handlebars.registerHelper('assign', function (varName, varValue, options) {
		    if (!options.data.root) {
		        options.data.root = {};
		    }
		    options.data.root[varName] = varValue;
		});
   Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
	    return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
	});
   Handlebars.registerHelper('ifImagesExist', function(arg1, options) {
   		var count = Object.keys(arg1).length;
	    return (count > 0) ? options.fn(this) : options.inverse(this);
	});
   var context = {};
   context["products"] = <?= json_encode($items); ?>;
   console.log("products====")
   console.log(context["products"])
   product_list_items = $.extend(product_list_items, context["products"]);
   console.log("product_list_items====")
   console.log(product_list_items) 
   context["show_more"] = <?= json_encode($page->has_next) ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("products-list-template-content").innerHTML = html;
 </script>
 @stop
