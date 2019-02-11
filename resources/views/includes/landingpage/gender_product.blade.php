<div class="product-group__col">							
	<a href="{{$product['product-slug']}}" class="w-100">
		@php
        if(count((array)$product->images)>0){
          $load_10x = $product['images']['load'];
          $image_1x = $product['images']['1x'];
          $image_2x = $product['images']['2x'];
          $image_3x = $product['images']['3x'];
        } else {
          $load_10x = CDN::asset('/img/placeholder-10x.jpg');
          $image_1x = $image_2x = $image_3x = CDN::asset('/img/placeholder.svg');
        }
        @endphp
		<img src="{{$load_10x}}" 
		data-srcset="{{$image_1x}} 270w, 
					{{$image_2x}} 540w, 
					{{$image_3x}} 810w" 
		data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
		class="card-img-top blur-up lazyload d-block w-100" 
		title="{{$product['title']}}" 
		alt="{{$product['title']}}">
	</a>
</div>