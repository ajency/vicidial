<!-- 1st grid -->
@foreach(array_chunk($trending, 4) as $trending_row)
<div id="card-list" class="overflow-m row productGrid">
  @foreach($trending_row as $trending_product)
    @if($trending_product['products'][0]['product_found'])
		@include('includes.trendinglooks.product', ['trending_product' => $trending_product['products'][0], 'type' => $trending_product['type'], 'sequence' => $trending_product['sequence']])
  	@else
   		@include('includes.trendinglooks.no-product', ['trending_product' => $trending_product['products'][0], 'type' => $trending_product['type'], 'sequence' => $trending_product['sequence']])
  	@endif
  @endforeach
</div>
@endforeach