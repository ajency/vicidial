@extends('layouts.default')

@php
  if ($gendername == 'boys') {
  	$title = 'Boys';
  	$years = '2 - 7 Years';
  	$box_1_alt= 'Boys Alt';
  	$box_1_title= 'Boys Title';
  } else if ($gendername == 'girls') {
  	$title = 'Girls';
  	$years = '2 - 7 Years';
  	$box_1_alt= 'Girls Alt';
  	$box_1_title= 'Girls Title';
  }
  else{
	$title = 'Infants';
	$years = '0 - 2 Years';
	$box_1_alt= 'Infant Alt';
  	$box_1_title= 'Infant Title';
  }
@endphp


@section('headjs')

@stop

@section('content')




<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box-1_shirt_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box-1_shirt_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box-1_shirt_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box-1_dresses_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box-1_dresses_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box-1_dresses_small.jpg') }} 512w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box-1_dresses_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/infants/box-1_dresses_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/infants/box-1_dresses_small.jpg') }} 512w"
					@endf		                          
		            sizes="100vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box-1_shirt_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box-1_shirt_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box-1_shirt_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box-1_dresses_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box-1_dresses_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box-1_dresses_portrait_small.jpg') }} 400w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box-1_dresses_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/infants/box-1_dresses_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/infants/box-1_dresses_portrait_small.jpg') }} 400w"
					@endf
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box-1_shirt_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box-1_dresses_20px.jpg') }}"
		       	   @else
		       	   	src="{{CDN::asset('/img/gender/infants/box-1_dresses_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_1_alt}}" 
		           title="{{$box_1_title}}">
		    </picture>
		</div>
		<div class="col-sm-4">
			<div class="gender text-center">
				<div class="row">
					<div class="col">
						{{$title}}
					</div>
					<div class="col">
						{{$title}}
					</div>
					<div class="col">
						{{$title}}
					</div>
				</div>	
				<h3 class="gender__name font-weight-bold text-dark text-uppercase">{{$title}}</h3>
				<p class="gender__years text-dark">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="#" class="btn kss-btn kss-btn--dark">Shop <strong>Shirts</strong></a>
				@elseif ($gendername == 'girls')
					<a href="#" class="btn kss-btn kss-btn--dark">Shop <strong>Dresses</strong></a>
				@else
					<a href="#" class="btn kss-btn kss-btn--dark">Shop <strong>Dresses</strong></a>
				@endif	
			</div>
		</div>
	</div>
</div>

@stop
