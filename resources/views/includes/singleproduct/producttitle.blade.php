<div class="d-flex">
    <div class="mt-sm-2">
            <!-- Product Title -->
            <a href="/{{$params['brand_href']}}" class="text-black"><h1 class="brands-title brands-title--single">{{$params['brand']}}</h1></a>
            <h1 class="section-heading section-heading--single">{{$params['title']}}</h1>

            <!-- Product Default/Selected Price -->
            @php
            if(isset($params['size'])) {
                $default_price = setDefaultPrice($params['variant_group']->{$selected_color_id}->variants, $params['size']);
            }
            else {
                $default_price = setDefaultPrice($params['variant_group']->{$selected_color_id}->variants);
            }

            if($default_price['list_price'] == $default_price['sale_price']) { @endphp
                <h4 id="kss-price" class="kss-price">₹{{$default_price['sale_price']}}</h4>
            @php } else { @endphp
                <h4 id="kss-price" class="kss-price">₹{{$default_price['sale_price']}} <small class="kss-original-price text-muted">₹{{$default_price['list_price']}}</small> <span class="kss-discount text-danger">{{$default_price['discount_per']}}% OFF</span></h4>
            @php } @endphp

    </div>
    @section('footjs-title')
        <script type="text/javascript">
            var default_price = {{$default_price['sale_price']}};
        </script>
    @stop

</div>