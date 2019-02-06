<div class="product-group__col">							
	<a href="/{{$product['product-slug']}}" class="w-100">
		<img src="{{$product['images']['load']}}" 
		data-srcset="{{$product['images']['1x']}} 270w, 
					{{$product['images']['2x']}} 540w, 
					{{$product['images']['3x']}} 810w" 
		data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
		class="card-img-top blur-up lazyload d-block w-100" 
		title="{{$product['title']}}" 
		alt="{{$product['title']}}">
	</a>
</div>