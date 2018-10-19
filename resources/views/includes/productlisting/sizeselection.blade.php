<div class="select-size alert alert-light">
  <label class="ml-2"> Sizes</label>
  <div class="radio-wrap d-flex kss_sizes wo-image mb-4">
  <!-- Calculate & Display Price & Discount -->
  @php
  foreach ($product->variants as $size_set) {
    $price_set = get_price_set($size_set);
  @endphp
    <!-- Size Selection -->
    <input class="d-none radio-input" type="radio" name="kss-sizes-{{$product->product_id}}-{{$product->color_id}}" id="size-{{$product->product_id}}-{{$product->color_id}}-{{$size_set->size->size_id}}" {{$price_set['checked']}} data-product_id="{{$product->product_id}}" data-color_id="{{$product->color_id}}" data-variant_id="{{$size_set->variant_id}}" {{$price_set['disabled']}} data-list_price="{{$price_set['list_price']}}" data-sale_price="{{$price_set['sale_price']}}" data-discount_per="{{$price_set['discount_per']}}"/>
    <label class="radio-label" for="size-{{$product->product_id}}-{{$product->color_id}}-{{$size_set->size->size_id}}" title="{{$size_set->size->size_name}}">
      <div class="radio-option">{{$size_set->size->size_name}}</div>
    </label>
  @php
  } @endphp
  </div>
  <!-- Add to cart button -->
  <button type="button" class="btn btn-lg btn-block btn-warning disabled" disabled>Select Size</button>
</div>