<div class="row center" >

	<div class="col-12 order-2 col-sm-12 col-md-12 order-sm-1 px-0 item">
		@php if(count((array)$params['images'])>0) { @endphp 
		<img src="/img/arrow.png" class="swipe-arrow d-block d-md-none">
		@php } @endphp 
		<div class="loader"></div>
			@php  if(count((array)$params['images'])>0) {
				$divclass = 'prod-slides';
			}
			else {
				$divclass = 'slider-placeholder-img';
			}
			@endphp
		<ul id="aniimated-thumbnials" class="d-flex d-sm-block list-unstyled m-0 m-md-2 {{$divclass}} hidden">

			@php
			if(count((array)$params['images'])>0) {
				foreach ($params['images'] as $image_set) {
					$image_1x = $image_set->{'main'}->{'1x'};
					$image_2x = $image_set->{'main'}->{'2x'};
					$image_3x = $image_set->{'main'}->{'3x'};
					$image_zoom = $image_set->{'zoom'}->{'1x'};
					$image_thumb = $image_set->{'thumb'}->{'1x'};
			@endphp
				<li class="mx-2 mb-2" >
					<a href="{{$image_zoom}}" class="custom-selector">
						<img data-src="{{$image_thumb}}" class="lazyload" data-srcset="{{$image_1x}} 326w, {{$image_2x}} 652w, {{$image_3x}} 978w" sizes="(max-width: 767px) 76vw, (min-width: 768px) and (max-width: 991px) 45vw, (min-width: 992px) 26vw">
					</a>
				</li>
			@php
			}
			} else  {
			@endphp
				<li class="mb-3 w-100">
					<img src="/img/placeholder.svg" class="lazyload" >
				</li>
			@php
			}
			@endphp

		</ul>

	</div>
</div>