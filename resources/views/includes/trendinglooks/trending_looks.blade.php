<!-- 1st grid -->
@foreach(array_chunk($trending, 4) as $trending_row)
<div id="card-list" class="overflow-m row productGrid">
  @foreach($trending_row as $trending_product)
    @include('includes.trendinglooks.product', ['trending_product' => $trending_product])
  @endforeach
</div>
@endforeach