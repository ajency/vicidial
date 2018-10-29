<div class="row center" >

	<div class="col-12 order-2 col-sm-12 col-md-12 order-sm-1 px-0 item">

		<img src="/img/arrow.png" class="swipe-arrow  d-block d-md-none">
		<div class="loader"></div>
		<ul id="aniimated-thumbnials" class="d-flex d-sm-block list-unstyled m-0 m-md-2 prod-slides hidden">

			@php
			if(count((array)$params['images'])>0) {
				foreach ($params['images'] as $image_set) {
					$image_1x = $image_set->{'main'}->{'1x'};
					$image_2x = $image_set->{'main'}->{'2x'};
					$image_3x = $image_set->{'main'}->{'3x'};
			@endphp
					<li class="mx-2 mb-2" >
						<a href="{{$image_3x}}" class="custom-selector">
							<img data-src="{{$image_1x}}" class="lazyload"  data-srcset="{{$image_1x}} 1x, {{$image_2x}} 2x" >

						</a>
					</li>
			@php
					}
			} else  {
			@endphp
			<li class="mx-2 mb-2" >
				<a href="/img/3x/4front@3x.jpg" class="custom-selector">
					<img data-src="/img/1x/4front@1x.jpg" class="lazyload"  data-srcset="/img/1x/4front@1x.jpg 1x, /img/2x/4front@2x.jpg 2x" >

				</a>
			</li>
			@php
			}
			@endphp

		</ul>

	</div>
</div>