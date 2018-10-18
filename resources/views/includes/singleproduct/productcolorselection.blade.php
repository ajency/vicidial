<div class=" d-md-block mb-3">
	<div class="d-flex justify-content-between mt-3">
		<label class=""> <p  class="font-weight-bold kss-link" href="#color-options"  aria-expanded="false" aria-controls="color-options"> More color options</p></label>
	</div>
	<div class="collapse show" id="color-options">
		<div class="card card-body alert-light ">
			<div class="radio-wrap w-image kss_variants d-flex align-items-baseline">
			@php foreach ($params['variant_group'] as $color_id => $color_set) {
		    	$checked="";
		    	if($color_id == $selected_color_id) {$checked="checked";}
	    		foreach ($color_set->images as $image_set) {
			     	if($image_set->is_primary) {$selected_image = $image_set->res->desktop->small_thumb;}
			     } @endphp
			    <input class="d-none radio-input" type="radio" name="kss-variants" id="color-{{$color_id}}" {{$checked}} @php if($checked == ''){ @endphp onclick="location.href='/{{$params["slug_name"]}}/{{$params["slug_style"]}}/{{$color_set->slug_color}}/buy'" @php } @endphp/>
				<label class="radio-label" for="color-{{$color_id}}" data-toggle="tooltip" data-placement="bottom" title="{{$color_set->name}}">
					<img src="{{$selected_image}}" alt="">
					<div class="radio-option mt-1">{{$color_set->name}}</div>
				</label>
		    @php } @endphp
			</div>
		</div>
	</div>
</div>