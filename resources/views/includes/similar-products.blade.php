<div id="similar" class="container">
	<hr class="mt-5">
	<h3 class="text-left my-4 font-weight-bold">Similar Products</h3>
   <div id="card-list" class="row">
          @php
          foreach ($items as $product) {
          $url = create_url([$product->slug_name, 'buy']);
          @endphp
          <div class="col">
            <div class="card h-100 product-card">
            	<!-- <i class="fas fa-heart kss_heart"></i> -->
              <a href="{{$url}}" >
                <div class="image oh loading loading-01">
                  @php
                    $image_1x = $image_2x = $image_3x = '/img/placeholder.svg';
                    $load_10x = '/img/placeholder-10x.jpg';
                    if(count((array)$product->images)>0){
                      $load_10x = $product->images->{'load'};
                      $image_1x = $product->images->{'1x'};
                      $image_2x = $product->images->{'2x'};
                      $image_3x = $product->images->{'3x'};
                    }
                  @endphp
                	<img src="{{$load_10x}}" data-srcset="{{$image_1x}} 270w, {{$image_2x}} 540w, {{$image_3x}} 978w" class="lazyload card-img-top blur-up @php if(empty((array)$product->images)){ @endphp placeholder-img @php } @endphp" sizes="(min-width: 992px) 25vw,50vw" alt="Cotton Rich Super Skinny Fit Jeans" title="Cotton Rich Super Skinny Fit Jeans" />
               </div>
              </a>
              <div class="card-body">
                <a href="/kss/product/" class="text-dark">
                  <h5 class="card-title">
                    {{$product->title}}
                  </h5>
                </a>
                @php
                  $default_price = set_default_price($product->variants);
                  if($default_price['list_price'] == $default_price['sale_price']) { 
                @endphp
                <div id="kss-price-{{$product->product_id}}-{{$product->color_id}}" class="kss-price kss-price--smaller">₹{{$default_price['sale_price']}}</div>
                @php } else { @endphp
                <div id="kss-price-{{$product->product_id}}-{{$product->color_id}}" class="kss-price kss-price--smaller">₹{{$default_price['sale_price']}} <small class="kss-original-price text-muted">₹{{$default_price['list_price']}}</small><span class="kss-discount text-danger">{{$default_price['discount_per']}}% OFF</span></div>
                @php } @endphp
              </div>
            </div>
          </div>

          @php
          } @endphp

<!--           <div class="col-lg-3 col-md-6 mb-4 col-6  ">
         	  <div class="card h-100 product-card">
              <a href="#">
                 <div class="image oh loading loading-02">
                <img src="/img/10px/orange-tshirt-10px.jpg" data-srcset="/img/1x/orange-tshirt@1x.jpg 270w, /img/2x/orange-tshirt@2x.jpg 540w, /img/3x/orange-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" alt="Cotton Rich Super Skinny Fit Jeans" title="Cotton Rich Super Skinny Fit Jeans" />
              </div>
              </a>
              <div class="card-body">
                <a href="/kss/product/" class="text-dark">
                  <h5 class="card-title">
                    Cotton Rich Super Skinny Fit Jeans
                  </h5>
                </a>
                <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4 col-6   ">
            <div class="card h-100 product-card">
              <a href="#">
                 <div class="image oh loading loading-03">
                      <img src="/img/10px/red-tshirt-10px.jpg" data-srcset="/img/1x/red-tshirt@1x.jpg 270w, /img/2x/red-tshirt@2x.jpg 540w, /img/3x/red-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" alt="Cotton Rich Super Skinny Fit Jeans" title="Cotton Rich Super Skinny Fit Jeans" />
                  </div>
              </a>
              <div class="card-body">
                <a href="/kss/product/" class="text-dark">
                  <h5 class="card-title">
                    Cotton Rich Super Skinny Fit Jeans
                  </h5>
                </a>
                <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
              </div>
            </div>
          </div>
              <div class="col-lg-3 col-md-6 mb-4 col-6 ">
            <div class="card h-100 product-card">
              <a href="#">
              	<div class="image oh loading loading-04">
              		<img src="/img/10px/mix-tshirt-10px.jpg" data-srcset="/img/1x/mix-tshirt@1x.jpg 270w, /img/2x/mix-tshirt@2x.jpg 540w, /img/3x/mix-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" alt="Cotton Rich Super Skinny Fit Jeans" title="Cotton Rich Super Skinny Fit Jeans" />
               	</div>
              </a>
              <div class="card-body">
                <a href="/kss/product/" class="text-dark">
                  <h5 class="card-title">
                    Cotton Rich Super Skinny Fit Jeans
                  </h5>
           	    </a>
                <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
              </div>
            </div> -->
          </div>
   </div>
</div>