<div class="row center" >

	<div class="col-12 order-2 col-sm-12 col-md-12 order-sm-1 px-0 item">
		@php if(count((array)$params['images'])>0) { @endphp
		<img src="/img/arrow.png" class="swipe-arrow d-block d-md-none" alt="Swipe arrow">
		@php } @endphp
		<div class="loader"></div>
			@php  if(count((array)$params['images'])>0) {
				$divclass = 'prod-slides';
			}
			else {
				$divclass = 'slider-placeholder-img';
			}
			@endphp
		<ul id="aniimated-thumbnials" class="list-unstyled m-0 m-md-2 {{$divclass}} carousel">

			@php
			if(count((array)$params['images'])>0) {
				foreach ($params['images'] as $image_set) {
					$image_1x = $image_set->{'main'}->{'1x'};
					$image_2x = $image_set->{'main'}->{'2x'};
					$image_3x = $image_set->{'main'}->{'3x'};
					$image_zoom = $image_set->{'zoom'}->{'1x'};
					$image_thumb = $image_set->{'thumb'}->{'1x'};
			@endphp
				<li class="carousel-cell">
					<a href="{{$image_zoom}}" class="custom-selector" title="{{$params['title']}}">
						<img data-flickity-lazyload-src="{{$image_thumb}}" class="carousel-image" data-flickity-lazyload-srcset="{{$image_1x}} 1x, {{$image_2x}} 2x, {{$image_3x}} 3x" alt="{{$params['title']}}" title="{{$params['title']}}">
					</a>
				</li>
			@php
			}
			} else  {
			@endphp
				<li class="mb-3 w-100">
					<img src="/img/placeholder.svg" class="lazyload" alt="No image" title="No image">
				</li>
			@php
			}
			@endphp

		</ul>

	</div>
</div>