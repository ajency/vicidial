<div class=" d-md-block mb-3">
	<div class="d-flex justify-content-between mt-3">
		<label class=""> <p  class="font-weight-bold kss-link" href="#color-options"  aria-expanded="false" aria-controls="color-options"> More color options</p></label>
	</div>
	<div class="collapse show" id="color-options">
	  <div class="card card-body alert-light ">
	    <div class="radio-wrap w-image kss_variants ">
		    <!-- <input class="d-none radio-input" type="radio" name="kss-variants" id="green" checked="checked"/>
		    <label class="radio-label" for="green" style="background-image: url(/img/thumbnail/6front@thumb.jpg)">
		      <div class="radio-option">green</div>
		    </label>
		    <input class="d-none radio-input" type="radio" name="kss-variants" id="yellow"/>
		    <label class="radio-label" for="yellow" style="background-image: url(/img/thumbnail/1front@thumb.jpg)">
		      <div class="radio-option">yellow</div>
		    </label>
		    <input class="d-none radio-input" type="radio" name="kss-variants" id="blue"/>
		    <label class="radio-label" for="blue" style="background-image: url(/img/thumbnail/3front@thumb.jpg)">
		      <div class="radio-option">blue</div>
		    </label>
		    <input class="d-none radio-input" type="radio" name="kss-variants" id="red"/>
		    <label class="radio-label" for="red" style="background-image: url(/img/thumbnail/10front@thumb.jpg)">
		      <div class="radio-option">red</div>
		    </label> -->
		    @php foreach ($params['variant_group'] as $color_id => $color_set) {
			    	$checked="";
			    	if($color_id == $selected_color_id) {$checked="checked";}
		    		foreach ($color_set->images as $image_set) {
				     	if($image_set->is_primary) {$selected_image = $image_set->res->desktop->small_thumb;}
				     } @endphp
				    <input class="d-none radio-input" type="radio" name="kss-variants" id="color-{{$color_id}}" {{$checked}} @php if($checked == ''){ @endphp onclick="location.href='/{{$params["slug_name"]}}/{{$params["slug_style"]}}/{{$color_set->slug_color}}/buy'" @php } @endphp/>
				    <label class="radio-label" for="color-{{$color_id}}" style="background-image: url({{$selected_image}})">
				      <div class="radio-option">{{$color_set->name}}</div>
				    </label>
			    @php } @endphp
		</div>
	  </div>
	</div>
</div>