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
   @if (isset($static_elements['banner'])) 
   @foreach($static_elements['banner'] as $banner)
		<div static_element-id="{{$banner['sequence']}}" static_element-display_type="Section" static_element-type="{{$banner['type']}}" class="row mb-md-4 pb-md-4 kss-extension" page_slug="{{$gendername}}" >
			<div class="col-md-7 pr-md-0 img-hero">
				@include('includes.landingpage.gender_banner', ['banner' => $banner])
			</div>
			<div class="col-md-5 d-flex">
				<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
					<div class="product-group d-flex mb-md-3">
						@foreach($banner['products'] as $product)
							@include('includes.landingpage.gender_product', ['product' => $product])			
						@endforeach
					</div>	
					<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
					<p class="gender__years text-dark m-detach">{{$banner['element_data']['text']['text1']}}</p>				
						<a href="/boys/toddler-2-7-years/shirt" class="btn kss-btn kss-btn--dark">{{$banner['element_data']['text']['text2']}}</a>
				</div>
			</div>
		</div>
	@endforeach	
	@endif	
</div>

@stop
