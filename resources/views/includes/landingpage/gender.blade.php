@extends('layouts.default')

@php
  if ($gendername == 'boys') {
  	$title = 'Boys';
  	$years = '2 - 7 Years';
  	$box_1_alt= 'Shirts';
  	$box_1_title= 'Shirts';
  	$box_2_alt= 'T-Shirts';
  	$box_2_title= 'T-Shirts';
  	$box_3_alt= 'Ethnic';
  	$box_3_title= 'Ethnic';
  	$box_4_alt= 'Bottoms';
  	$box_4_title= 'Bottoms';
  	$box_5_alt= 'Shorts';
  	$box_5_title= 'Shorts';
  	$box_6_alt= 'Shoes';
  	$box_6_title= 'Shoes';
  } else if ($gendername == 'girls') {
  	$title = 'Girls';
  	$years = '2 - 7 Years';
  	$box_1_alt= 'Dresses';
  	$box_1_title= 'Dresses';
  	$box_2_alt= 'T-Shirts';
  	$box_2_title= 'T-Shirts';
  	$box_3_alt= 'Woven Tops';
  	$box_3_title= 'Woven Tops';
  	$box_4_alt= 'Ethnic';
  	$box_4_title= 'Ethnic';
  	$box_5_alt= 'Denim';
  	$box_5_title= 'Denim';
  	$box_6_alt= 'Bottoms';
  	$box_6_title= 'Bottoms';
  	$box_7_alt= 'Shorts';
  	$box_7_title= 'Shorts';
  	$box_8_alt= 'Shoes';
  	$box_8_title= 'Shoes';
  }
  else{
	$title = 'Infants';
	$years = '0 - 2 Years';
	$box_1_alt= 'Dresses';
  	$box_1_title= 'Dresses';
  	$box_2_alt= 'T-Shirts';
  	$box_2_title= 'T-Shirts';
  	$box_3_alt= 'Bottoms';
  	$box_3_title= 'Bottoms';
  	$box_4_alt= 'Utility';
  	$box_4_title= 'Utility';
  	$box_5_alt= 'Shoes';
  	$box_5_title= 'Shoes';
  	$box_6_alt= '';
  	$box_6_title= '';
  }
@endphp


@section('headjs')

@stop

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
		<div static_element-id="{{$banner['sequence']}}" static_element-display_type="Banner" static_element-type="{{$banner['type']}}" class="row mb-md-4 pb-md-4 kss-extension" page_slug="{{$gendername}}" >
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
					<p class="gender__years text-dark m-detach">{{$years}}</p>				
						<a href="/boys/toddler-2-7-years/shirt" class="btn kss-btn kss-btn--dark">{{$banner['element_data']['text']['text2']}}</a>
				</div>
			</div>
		</div>
	@endforeach	
	@endif	
</div>

@stop


@section('footjs')

<script type="text/javascript">
	// $(function(){
	// 	$('.sublanding-container > .row').each(function(){
	// 		var title_years = $(this).find('.m-detach').detach();
	// 		$(this).find('.img-hero').append(title_years);
	// 	})
	// });
</script>

@stop