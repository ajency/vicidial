@php
	if(count((array)$params['variant_group']) > 1){
	$color_obj = $params['variant_group']->{$selected_color_id};
	$hexcode = ($color_obj->html != '') ? $color_obj->html : implode('', explode(" ",$color_obj->name));
@endphp

<div class="colorOptions d-md-block mb-3 d-none d-sm-block">
	<div class="d-flex justify-content-between mt-3">
		<label class="align-items-center d-flex colorOptions__trigger cursor-pointer collapsed" href="#color-options"  aria-expanded="false" aria-controls="color-options" data-toggle="collapse"> 
				<ul class="product-color product-color--single px-1"  data-toggle="tooltip" data-placement="bottom" title="{{$color_obj->name}}">
					<li class="d-inline-flex align-middle">
				    	<!-- <input type="checkbox" name="color" checked=true disabled> -->
				    	
				    	<label class="mb-0" style="background-color:{{$hexcode}};"></label>
				  	</li>
				</ul>
			<p class="font-weight-bold kss-link mb-0"> Color options</p>
			
				<i class="fas fa-chevron-down cursor-pointer icon-md down-arrow "></i>
		</label>
	</div>
	<div class="collapse" id="color-options">
		<div class="card card-body border-0 p-0 mt-3 ">
			<div class="radio-wrap w-image kss_variants d-flex align-items-baseline flex-wrap">
			@php foreach ($params['variant_group'] as $color_id => $color_set) {
		    	$checked="";
		    	if($color_id == $selected_color_id) {$checked="checked";}
		    		$image_1x = $image_2x = $image_3x = CDN::asset('/img/placeholder.svg');
		    	if(count((array)$color_set->images)>0){
		    		$image_1x = $color_set->images->{'1x'};
		    		$image_2x = $color_set->images->{'2x'};
		    		$image_3x = $color_set->images->{'3x'};
		    	}
			    $url = createUrl([$color_set->slug_name, 'buy']);
			    $hexcode = ($color_set->html != '') ? $color_set->html : implode('', explode(" ",$color_set->name));
			@endphp
			    <input class="d-none radio-input" type="radio" name="kss-variants" id="color-{{$color_id}}" {{$checked}} />
				<label class="radio-label position-relative variant-wrapper" for="color-{{$color_id}}" data-toggle="tooltip" data-placement="bottom" title="{{$color_set->name}}" @php if($checked == ''){ @endphp onclick="location.href='{{$url}}'" @php } @endphp>
					<ul class="product-color product-color--single product-color--sm position-absolute color-custom-radio p-0 @php if($checked == ''){ @endphp no-check @php } else { @endphp checked @php } @endphp">
						<li class="d-inline-flex align-middle" @php if($checked == ''){ @endphp onclick="location.href='{{$url}}'" @php } @endphp>
					    	<!-- <input type="radio" name="color" id="{{$color_set->name}}" {{$checked}} /> -->
					    	<label for="{{$color_set->name}}" class="m-0" style="background-color:{{$hexcode}};"></label>
					  	</li>
					</ul>
					<div class="variant-img-wrapper @php if(count((array)$color_set->images)==0) { @endphp variant-placeholder @php } @endphp">
						<img src="{{$image_1x}}" class="lazyload blur-up w-100" data-srcset="{{$image_1x}} 50w, {{$image_2x}} 100w, {{$image_3x}} 150w" sizes="50px"  alt="">
					</div>
					<!-- <div class="radio-option mt-1" >{{$color_set->name}}</div> -->
				</label>
		    @php } @endphp
			</div>
		</div>
	</div>
</div>
@php } @endphp