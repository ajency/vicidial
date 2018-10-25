<div class="colorOptions d-md-block mb-3 d-none d-sm-block">
	<div class="d-flex justify-content-between mt-3">
		<label class="align-items-center d-flex"> 
			<p class="font-weight-bold kss-link mb-0"> Color options</p>
			<ul class="product-color product-color--single px-1">
				<li class="d-inline-flex align-middle">
			    	<input type="checkbox" name="color" id="red" checked=true disabled>
			    	@php
			    		$color_obj = $params['variant_group']->{$selected_color_id};
			    		$hexcode = ($color_obj->html != '') ? $color_obj->html : implode('', explode(" ",$color_obj->name));
			      	@endphp
			    	<label for="red" class="mb-0 cursor-auto" style="background-color:{{$hexcode}};"></label>
			  	</li>
			</ul>
			<i class="fas fa-chevron-down cursor-pointer icon-md down-arrow collapsed" href="#color-options"  aria-expanded="false" aria-controls="color-options" data-toggle="collapse"></i>
		</label>
	</div>
	<div class="collapse" id="color-options">
		<div class="card card-body alert-light ">
			<div class="radio-wrap w-image kss_variants d-flex align-items-baseline">
			@php foreach ($params['variant_group'] as $color_id => $color_set) {
		    	$checked="";
		    	if($color_id == $selected_color_id) {$checked="checked";}
	    		foreach ($color_set->images as $image_set) {
			     	if($image_set->is_primary) {$selected_image = $image_set->res->desktop->small_thumb;}
			     }
			     $url = create_url([$color_set->slug_name, 'buy']);
			     $hexcode = ($color_set->html != '') ? $color_set->html : implode('', explode(" ",$color_set->name));
			@endphp
			    <input class="d-none radio-input" type="radio" name="kss-variants" id="color-{{$color_id}}" {{$checked}} @php if($checked == ''){ @endphp onclick="location.href='{{$url}}'" @php } @endphp/>
				<label class="radio-label position-relative" for="color-{{$color_id}}" data-toggle="tooltip" data-placement="bottom" title="{{$color_set->name}}">
					<ul class="product-color product-color--single product-color--sm position-absolute color-custom-radio p-0 @php if($checked == ''){ @endphp no-check @php } else { @endphp checked @php } @endphp">
						<li class="d-inline-flex align-middle">
					    	<input type="radio" name="color" id="{{$color_set->name}}" {{$checked}} @php if($checked == ''){ @endphp onclick="location.href='{{$url}}'" @php } @endphp/>
					    	<label for="{{$color_set->name}}" class="m-0" style="background-color:{{$hexcode}};"></label>
					  	</li>
					</ul>
					<img src="{{$selected_image}}" alt="">
					<div class="radio-option mt-1">{{$color_set->name}}</div>
				</label>
		    @php } @endphp
			</div>
		</div>
	</div>
</div>