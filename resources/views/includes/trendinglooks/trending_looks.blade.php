<!-- 1st grid -->
@foreach(array_chunk($trending, 4) as $trending_row)
<div id="card-list" class="overflow-m row productGrid">
  @foreach($trending_row as $trending_product)
    @if($product['product_found'])
		@include('includes.trendinglooks.product', ['trending_product' => $trending_product])
  	@else
   		@include('includes.trendinglooks.no-product', ['trending_product' => $trending_product])
  	@endif
  @endforeach
</div>
@endforeach