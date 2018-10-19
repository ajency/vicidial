@php
//URL Generation
$url = create_url([$product->slug_name, $product->slug_style, $product->slug_color, 'buy']);
@endphp
<div class="col-lg-4 col-md-6 mb-4 col-6  ">

  <div class="card h-100 product-card">
  
  	<!-- Wishlist -->
    <!-- <i class="fas fa-heart kss_heart"></i> -->
    <!-- Product Image Display -->
    <a href="{{$url}}" >
      <div class="image oh loading loading-01">
      <div class="overlay"></div>
      <img data-src="{{$product->images->desktop->one_x}}" data-srcset="{{$product->images->desktop->one_x}} 1x, {{$product->images->desktop->two_x}} 2x" class="lazyload card-img-top" />
     </div>
    </a>
    <!-- Product Info & Size Display -->
    <div class="card-body">
      <a href="{{$url}}" class="text-dark">
        <h5 class="card-title">
          {{$product->title}}
        </h5>
      </a>
      <!-- Calculate & Display Price -->
      @php
        $default_price = set_default_price($product->variants);
        if($default_price['list_price'] == $default_price['sale_price']) { @endphp
        <div id="kss-price-{{$product->product_id}}-{{$product->color_id}}" class="kss-price kss-price--smaller">₹{{$default_price['sale_price']}}</div>
      @php } else { @endphp
        <div id="kss-price-{{$product->product_id}}-{{$product->color_id}}" class="kss-price kss-price--smaller">₹{{$default_price['sale_price']}} <small class="kss-original-price text-muted">₹{{$default_price['list_price']}}</small><span class="kss-discount text-danger">{{$default_price['discount_per']}}% OFF</span></div>
      @php } @endphp
    </div>
    <!-- Size Selection Blade -->
    @include('includes.productlisting.sizeselection', ['product' => $product])
  </div>
</div>