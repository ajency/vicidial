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
				        		<div id="kss-price-@{{../product_id}}-@{{../color_id}}" class="kss-price kss-price--smaller">
				        		<!-- @{{#ifEquals ../display_price.max ../display_price.min}}
				        			₹@{{../display_price.max}}
				        		@{{else}}
				        			₹@{{../display_price.min}} - ₹@{{../display_price.max}}
				        		@{{/ifEquals}} -->
				        		₹@{{../display_price.min}}
				        		</div>
				        	@{{else}}
				        		<div id="kss-price-@{{../product_id}}-@{{../color_id}}" class="kss-price kss-price--smaller">
				        		<!-- @{{#ifEquals ../display_price.max ../display_price.min}}
				        			₹@{{../display_price.max}}
				        		@{{else}}
				        			₹@{{../display_price.min}} - ₹@{{../display_price.max}}
				        		@{{/ifEquals}} -->
				        		₹@{{../display_price.min}}
				        		</div>
				        		<small class="kss-original-price text-muted">₹@{{list_price}}</small><span class="kss-discount text-danger">@{{discount_per}}% OFF</span>
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

  @{{#ifEquals page.total 1}}
  @{{assign "viewed_products" (multiply display_limit current)}}
	  <p class="my-4 product-view text-center">You've viewed @{{item_count}} @{{#ifEquals item_count 1}}product@{{else}}products@{{/ifEquals}} of  @{{total_item_count}} @{{#ifEquals total_item_count 1}}product @{{else}}products@{{/ifEquals}}</p>
	  <!-- progress loader -->
	  <div class="kss-progress-bar">
	  	<div class="kss-progress-bar__loader" style="width:@{{percent item_count total_item_count}}%;"></div>
	  </div>
	@{{/ifEquals}}
 	@{{#if show_pagination}}
  	<div class="kss-pagination mt-5">
		<span class="kss-pagination__prev controls pr-md-4 d-flex  @{{#if load_prev }} @{{else}} disabled @{{/if}}">
			<a href="javascript:loadProductListing((@{{page.current}}),false,true);">
				<span class="pr-2"><i class="fas fa-chevron-left"></i></span>
				<span class="d-flex">Previous <span class="d-none d-md-block">Page</span></span>
			</a>
		</span>
		<div class="page-numbers d-none d-md-flex">
			@{{#if show_first_page}}
			<span class="kss-pagination__link">
				<a href="javascript:loadProductListing(2,false,true);">1</a>
			</span>
			<span class="dot-more">...</span>
			@{{/if}}
			@{{#each display_pages}}
				@{{#ifEquals ../page.current this }}
					<span class="current">@{{this}}</span>
				@{{else}}
					<span class="kss-pagination__link">
						@{{#ifGreater ../page.current this }}
						<a href="javascript:loadProductListing(@{{this}}+1,false,true);">@{{this}}</a>
						@{{else}}
						<a href="javascript:loadProductListing(@{{this}}-1);">@{{this}}</a>
						@{{/ifGreater}}
					</span>
				@{{/ifEquals}}	
			@{{/each}}
			@{{#if show_last_page}}
			<span class="dot-more">...</span>
			<span class="kss-pagination__last disabled">@{{page.total}}</span>
			@{{/if}}
		</div>
		<span class="kss-pagination__next controls pl-md-4 d-flex @{{#if show_more }} @{{else}} disabled @{{/if}}">
			<a href="javascript:loadProductListing(@{{page.current}});">
				<span class="d-flex">Next <span class="d-none d-md-block">Page</span></span>
				<span class="pl-2"><i class="fas fa-chevron-right"></i></span>
			</a>
		</span>
	</div>
	@{{/if}}
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
   context["page"] = <?= json_encode($page); ?>;
   product_list_items = $.extend(product_list_items, context["products"]);
   context["show_more"] = <?= json_encode($page->has_next) ?>;
   context["load_prev"] = <?= json_encode($page->has_previous) ?>;
   context["page_val"] = page_no_val;
   context["first_page_loaded"] = first_page_loaded;
   context["item_count"] = prod_items_count;
   context["total_item_count"] = <?= json_encode($page->total_item_count) ?>;
   context["display_limit"] = <?= json_encode($page->display_limit) ?>;
   context["current"] = <?= json_encode($page->current) ?>;
   console.log("curr=="+context["current"])
   context["pagination"] = <?= json_encode($pagination) ?>;
   context["display_pages"] = [];
   var page_display_limit = 3
   var endCounter = page_display_limit
   if(parseInt(context["current"]) >= page_display_limit)
   		endCounter = (parseInt(context["current"])+1)
   	if((parseInt(context["page"]["total"])-parseInt(context["current"]))<(context["pagination"]["show_previous_after"])-1)
   		endCounter = context["page"]["total"]
   	var startCounter = 1;
  	if((parseInt(context["current"])) >= context["pagination"]["show_previous_after"]){
  		if(endCounter == parseInt(context["page"]["total"]) && endCounter == parseInt(context["current"]))
  			startCounter = ((parseInt(context["current"]))-(parseInt(page_display_limit)-1))
  		else
  			startCounter = ((parseInt(context["current"])+1)-(parseInt(page_display_limit)-1))
  	}
   	
  	
    for (let i = startCounter; i <= endCounter; i++) {
        context["display_pages"].push(i)
    }
    context["show_first_page"] = (startCounter == 1)?false:true
    context["show_last_page"] = (endCounter == parseInt(context["page"]["total"]))?false:true
    context["show_pagination"] = ((context["show_more"] == false && context["load_prev"] == false) || (context["page"]["total"]<page_no_val))?false:true
   var html    = template(context);
   document.getElementById("products-list-template-content").innerHTML = html;
 </script>
 @stop
