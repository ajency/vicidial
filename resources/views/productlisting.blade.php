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
            @include('includes.productlisting.listingproducts', ['items' => $params->items])
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
  @yield('footjs-gender')
  @yield('footjs-age')
  @yield('footjs-subtype')
  @yield('footjs-category')
  <script type="text/javascript">
      var facet_list = {}
      
     $('.facet-category').on('change', function() { 
      // From the other examples
      console.log("change===")
      var call_ajax = false;
      var facet_name = $(this).data('facet-name')
      console.log(facet_name)
      console.log(this.checked+"==="+this.value);
      if(this.checked){
        if(facet_list.hasOwnProperty(facet_name)){
          if(facet_list[facet_name].indexOf(this.value) == -1){
            facet_list[facet_name].push(this.value)
            call_ajax = true;
          }
        }
        else
          facet_list[facet_name] = [this.value]
          call_ajax = true;
      }
      else{
        console.log("else==")
        if(facet_list.hasOwnProperty(facet_name)){
          console.log("hasproperty=="+this.value+"====="+facet_list[facet_name].indexOf(this.value))
          console.log(facet_list[facet_name])
          if(facet_list[facet_name].indexOf(this.value) > -1){
            console.log("len=="+facet_list[facet_name].length)
            if(facet_list[facet_name].length == 1){
              delete facet_list[facet_name];
              call_ajax = true;
            }
            else{
                var index = facet_list[facet_name].indexOf(this.value);
                if (index !== -1) facet_list[facet_name].splice(index, 1);
                call_ajax = true;
              }
            }
        }
      }
      console.log(facet_list);
      var data = {"search_object":facet_list}
      if(call_ajax == true){
        $.ajax({
        method: "POST",
        url: "/api/rest/v1/product-list",
        data: data
      })
        .done(function( msg ) {
          alert( "Data Saved: " + msg );
        });
      }
      
  });
     $( "input[name='age']" ).trigger( "change" );
      $( "input[name='gender']" ).trigger( "change" );
      $( "input[name='category']" ).trigger( "change" );
      $( "input[name='subtype']" ).trigger( "change" );
  </script> 

@stop