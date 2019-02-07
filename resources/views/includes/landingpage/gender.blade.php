@extends('layouts.default')

@php
  if ($gendername == 'boys') {
  	$title = 'Boys';
  	$years = '2 - 7 Years';
  } else if ($gendername == 'girls') {
  	$title = 'Girls';
  	$years = '2 - 7 Years';
  }
  else{
	$title = 'Infants';
	$years = '0 - 2 Years';
  }
@endphp


@section('content')


<div class="container sublanding-container pt-md-4">
   <!-- Breadcrumbs -->
   <div class="row d-none d-md-block">
      <div class="col-12">
         <div class="mb-4">
            @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
         </div>
      </div>
   </div>
   <div class="row">
   	<div class="col-12 gender m-heading text-center">
   		<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach"><span>{{$title}}</span></h3>
		<p class="gender__years text-dark m-detach d-md-none">{{$years}}</p>
   	</div>
   </div>
   @if (isset($static_elements['landing'])) 
   @foreach($static_elements['landing'] as $landing)
		<div static_element-id="{{$landing['sequence']}}" static_element-display_type="Section" static_element-type="{{$landing['type']}}" class="row mb-md-4 pb-md-4 kss-extension position-relative" page_slug="{{$gendername}}" >
			<div class="col-md-7 pr-md-0 img-hero">
				@include('includes.landingpage.gender_banner', ['landing' => $landing])
			</div>
			<div class="col-md-5 d-flex">
				<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
					<div class="product-group d-flex mb-md-3">
						@foreach($landing['products'] as $product)
							@include('includes.landingpage.gender_product', ['product' => $product])
						@endforeach
					</div>	
					<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
					<p class="gender__years text-dark m-detach">{{$landing['element_data']['text']['text1']}}</p>				
						<a href="{{$landing['element_data']['image']['href']}}" class="btn kss-btn kss-btn--dark">{{$landing['element_data']['text']['text2']}}</a>
				</div>
			</div>
		</div>
	@endforeach	
	@endif	
</div>

@stop

@section('footjs')
<script type="text/javascript">  
  $(function(){ 
    // Tooltip for chrome extension  
      if($('.update-element-btn')){ 
        $(document).on('click',".update-element-btn",function(){ 
            setTimeout(function() { 
                $('[data-toggle="tooltip"]').tooltip() 
             }, 1800); 
        }); 
      } 
  })
</script>

@stop