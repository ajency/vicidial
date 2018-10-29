@extends('layouts.default')

@section('headjs')

 <script type="text/javascript" src="/js/handlebars.min.js"></script>
 
@stop

@section('content')
    
	<section>
    <div class="container mt-2 mt-md-4">
     	<div class="row">
     	  <!-- Filters Blade -->
    	  @include('includes.productlisting.filters', ['filters' => $params->filters])
    	  <div class="col-sm-12 col-md-9 bl-1">
    	    <!-- Title, breadcrumbs, sort Blade -->
    	  	@include('includes.productlisting.listingtitle', ['headers' => $params->headers, 'breadcrumbs' => $params->breadcrumbs, 'sort_on' => $params->sort_on])
          <div id="card-list" class="row">
    	    <!-- List of products Blade -->
            @include('includes.productlisting.listingproducts', ['items' => $params->items,'singleton'])
          </div>
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

  <script type="text/javascript" src="/js/productlisting.js"></script>


@stop