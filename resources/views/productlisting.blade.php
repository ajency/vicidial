@php
 $overflow = true; 
 $sectionnotfound = true;
@endphp

@extends('layouts.default')

@section('headjs')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.12/handlebars.min.js"></script>
@stop

@section('content')
  <!-- Loader on load -->
  <div class="pl-loader">
    <div class="loader block-loader"></div>
  </div>
	<section class="productlist">
    <div class="container mt-2 mt-md-4 productlist__row">
     	<div class="row">
     	  <!-- Filters Blade -->
    	  @include('includes.productlisting.filters', ['filters' => $params->filters])
    	  <div class="col-sm-12 col-md-9 bl-1">
    	    <!-- Title, breadcrumbs, sort Blade -->
    	  	@include('includes.productlisting.listingtitle', ['headers' => $params->headers, 'breadcrumbs' => $params->breadcrumbs, 'sort_on' => $params->sort_on])

    	    <!-- List of products Blade -->
            @include('includes.productlisting.listingproducts', ['items' => $params->items,'page' => $params->page])

    	  </div>
    	</div>
    </div>
    <div class="d-none productlist__na">
      @include('includes.no-products-content')
    </div>
    <br>
    <br>
    <!-- Filters, Sort for mobile Blade -->
    @include('includes.productlisting.filtersmobile', ['sort_on' => $params->sort_on])
  </section>

@stop

@section('footjs')
  <?php
    $facet_display_data = config('product.facet_display_data');

    // usort($facet_display_data, function($a, $b) {
    //       return $a["order"] > $b["order"] ? 1 : -1;
    //   });

    $config_facet_names_arr = array_keys($facet_display_data);
    $facet_value_slug_assoc = json_encode($params->search_result_assoc);
    $facet_display_data_arr = json_encode($facet_display_data);
  ?>
  <script type="text/javascript">
      var config_facet_names_arr = <?= json_encode($config_facet_names_arr);?>;
      var facet_value_slug_assoc = <?= $facet_value_slug_assoc ?>;
      var facet_display_data_arr = <?= $facet_display_data_arr ?>;
      var product_list_items = {};
  </script>
   <script type="text/javascript" src="{{CDN::mix('/js/productlisting.js') }}"></script>
  @yield('footjs-color')
  @yield('footjs-price')
  @yield('footjs-gender')
  @yield('footjs-age')
  @yield('footjs-subtype')
  @yield('footjs-category')
  @yield('footjs-filter-tags')
  @yield('footjs-products-list')

 

@stop