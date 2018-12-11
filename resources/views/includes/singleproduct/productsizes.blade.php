<div class="radio-wrap d-flex kss_sizes wo-image mb-4 single-radio">
    @php
    foreach ($params['variant_group']->{$selected_color_id}->variants as $size_set) {
    	if(isset($params['size'])) {
		    $price_set = get_price_set($size_set, $params['size']);
        }
        else {
        	$price_set = get_price_set($size_set);
        }
    	@endphp
    	<input class="d-none radio-input" type="radio" name="kss-sizes" id="size-{{$size_set->size->id}}" {{$price_set['checked']}} data-variant_id="{{$size_set->id}}" {{$price_set['disabled']}} data-list_price="{{$price_set['list_price']}}" data-sale_price="{{$price_set['sale_price']}}" data-discount_per="{{$price_set['discount_per']}}" data-title="{{$size_set->size->slug}}" />
	    <label class="radio-label" for="size-{{$size_set->size->id}}" @php if($price_set['disabled']) { @endphp title="{{$size_set->size->display_name}}. Out of Stock" @php } else { @endphp title="{{$size_set->size->display_name}}" @php } @endphp>
	      <div class="radio-option"> @php if(isNotProd()) echo $size_set->id." : "; @endphp {{$size_set->size->display_name}}</div>
	    </label>
    	@php
     } @endphp
</div>