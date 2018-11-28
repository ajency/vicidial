@php
 $overflow = true; 
 $sectionnotfound = true;
@endphp

@extends('layouts.default')

@php
  $delaycss = true;
@endphp

@section('headjs')
  @include('includes.abovethefold.productlistingcss')
@stop

@section('content')
  <!-- Loader on load -->
  <div class="pl-loader">
    <div class="loader block-loader"></div>
  </div>
	<section class="productlist">
    <div class="container mt-2 mt-md-4">
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
    
    <br>
    <br>
    <!-- Filters, Sort for mobile Blade -->
    @include('includes.productlisting.filtersmobile', ['sort_on' => $params->sort_on])
  </section>

@stop

@section('footjs')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.12/handlebars.min.js"></script>
  <?php
    $facet_display_data = config('product.facet_display_data');
    $config_facet_names_arr = array_keys($facet_display_data);
    $facet_value_slug_assoc = json_encode($params->search_result_assoc);
    $facet_display_data_arr = json_encode($facet_display_data);
    $checkboxTemplate = View::make('includes.productlisting.productfilters.common.checkbox');
    $radioTemplate = View::make('includes.productlisting.productfilters.common.radio');
  ?>
  <script type="text/javascript">
      var config_facet_names_arr = <?= json_encode($config_facet_names_arr);?>;
      var facet_value_slug_assoc = <?= $facet_value_slug_assoc ?>;
      var facet_display_data_arr = <?= $facet_display_data_arr ?>;
      var product_list_items = {};
      Handlebars.registerPartial(
        'checkboxTemplate', '<?= $checkboxTemplate ?>'
        
      ); 
      Handlebars.registerPartial(
        'radioTemplate', '<?= $radioTemplate ?>'
        
      );
  </script>
   <script type="text/javascript" src="{{CDN::mix('/js/productlisting.js') }}"></script>
  @yield('footjs-color')
  @yield('footjs-availability')
  @yield('footjs-price')
  @yield('footjs-gender')
  @yield('footjs-age')
  @yield('footjs-subtype')
  @yield('footjs-category')
  @yield('footjs-filter-tags')
  @yield('footjs-products-list')

 

@stop