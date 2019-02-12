<div class="col-lg-3 col-md-6 col-6 kss-extension" static_element-id="{{$sequence}}" static_element-display_type="Trending Products" static_element-type="{{$type}}" page_slug="home">
  <div class="card h-100 product-card position-relative">
    <a href="{{$trending_product['product-slug']}}">
      <div class="">
          @php
          if(count((array)$trending_product['images'])>0){
            $load_10x = $trending_product['images']['load'];
            $image_1x = $trending_product['images']['1x'];
            $image_2x = $trending_product['images']['2x'];
            $image_3x = $trending_product['images']['3x'];
          } else {
            $load_10x = CDN::asset('/img/placeholder-10x.jpg');
            $image_1x = $image_2x = $image_3x = CDN::asset('/img/placeholder.svg');
          }
          @endphp
          <img 
            src="{{$load_10x}}" 
            data-srcset="{{$image_1x}} 270w,
                          {{$image_2x}}  540w,
                          {{$image_3x}} 810w" 
            data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
            class="card-img-top blur-up lazyload" 
            title="{{$trending_product['title']}}" 
            alt="{{$trending_product['title']}}">
     </div>
    </a>
    <div class="kss-price kss-price--medium">₹{{$trending_product['sale_price']}}</div>
  </div>
</div>