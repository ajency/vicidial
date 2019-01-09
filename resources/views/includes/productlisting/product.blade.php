@php
//URL Generation
$url = createUrl([$product->slug_name, 'buy']);
@endphp
<div class="col-lg-4 col-md-6 mb-sm-4 col-6  ">

  <div class="card h-100 product-card">
  
  	<!-- Wishlist -->
    <!-- <i class="fas fa-heart kss_heart"></i> -->
    <!-- Product Image Display -->
    <a href="{{$url}}" class="position-relative">
      <div class="product-card__wrapper loading d-flex align-items-center justify-content-center mb-2 mb-sm-3">
        <div class="overlay"></div>
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
        <img src="{{$load_10x}}" data-srcset="{{$image_1x}} 270w, {{$image_2x}} 540w, {{$image_3x}} 810w" sizes="(min-width: 992px) 33.33vw,50vw" class="lazyload card-img-top blur-up @php if(empty((array)$product->images)){ @endphp placeholder-img @php } @endphp" />

        <!-- Size Selection Blade -->
        {{-- @include('includes.productlisting.sizeselection', ['product' => $product]) --}}
      </div>      
    </a>
    <!-- Product Info -->
    <div class="card-body">
      <a href="{{$url}}" class="text-dark">
        <h5 class="card-title">
          {{$product->title}}
        </h5>      
      </a>
      <!-- Calculate & Display Price -->
      @php
        $default_price = setDefaultPrice($product->variants);
        if($default_price['list_price'] == $default_price['sale_price']) { @endphp
        <div id="kss-price-{{$product->product_id}}-{{$product->color_id}}" class="kss-price kss-price--smaller">₹{{$default_price['sale_price']}}</div>
      @php } else { @endphp
        <div id="kss-price-{{$product->product_id}}-{{$product->color_id}}" class="kss-price kss-price--smaller">₹{{$default_price['sale_price']}} <small class="kss-original-price text-muted">₹{{$default_price['list_price']}}</small><span class="kss-discount text-danger">{{$default_price['discount_per']}}% OFF</span></div>
      @php } @endphp
    </div>
  </div>
</div>