<div class="d-flex">
    <div class="mt-2">
            <!-- Product Title -->

            <h1 class="kss-title mb-2 mb-sm-2 text-black w-100">{{$params['title']}}</h1>

            <!-- Product Default/Selected Price -->
            @php
            if(isset($params['size'])) {
                $default_price = set_default_price($params['variant_group']->{$selected_color_id}->variants, $params['size']);
            }
            else {
                $default_price = set_default_price($params['variant_group']->{$selected_color_id}->variants);
            }

            if($default_price['list_price'] == $default_price['sale_price']) { @endphp
                <h4 id="kss-price" class="kss-price">₹{{$default_price['sale_price']}}</h4>
            @php } else { @endphp
                <h4 id="kss-price" class="kss-price">₹{{$default_price['sale_price']}} <small class="kss-original-price text-muted">₹{{$default_price['list_price']}}</small> <span class="kss-discount text-danger">{{$default_price['discount_per']}}% OFF</span></h4>
            @php } @endphp

    </div>


</div>