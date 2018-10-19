<!-- Loop all products -->
@php
foreach ($items as $product) {
@endphp
  <!-- Single Product Blade -->
  @include('includes.productlisting.product', ['product' => $product])
@php
} @endphp