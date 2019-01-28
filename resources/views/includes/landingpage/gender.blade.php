@extends('layouts.default')

@php
  if ($gendername == 'boys') {
  	$title = 'Boys';
  	$years = '2 - 7 Years';
  	$registrationDate = 'January 25th, 2019; 7:00 PM';
  	$redirectLink = 'https://goo.gl/forms/yASCybdisxnuAhjT2';
  } else if ($gendername == 'girls') {
  	$title = 'Girls';
  	$years = '2 - 7 Years';
  	$venue = 'G-5, G-6, G-7, F-105, Om Arcade, Anandmahal, Adajan, Surat. Gujarat - 395009.';
  	$registrationDate = 'January 25th, 2019; 5:00 PM';
  	$redirectLink = 'https://goo.gl/forms/gnbLVZiUuMZDE1PA2';
  }
  else{
	$title = 'Infants';
	$years = '0 - 2 Years';
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
		              data-srcset="{{CDN::asset('/img/our-activities/fashion-banner-large.jpg') }} 2000w,
		                          {{CDN::asset('/img/our-activities/fashion-banner-medium.jpg') }} 1200w,
		                          {{CDN::asset('/img/our-activities/fashion-banner-small.jpg') }} 700w"
		              sizes="100vw">

		       <source media="(orientation: portrait)"
		              data-srcset="{{CDN::asset('/img/our-activities/fashion-banner-portrait-large.jpg') }} 1200w,
		                          {{CDN::asset('/img/our-activities/fashion-banner-portrait-medium.jpg') }} 700w,
		                          {{CDN::asset('/img/our-activities/fashion-banner-portrait-small.jpg') }} 400w"
		              sizes="100vw">

		       <img src="{{CDN::asset('/img/our-activities/fashion-banner-20px.jpg') }}"
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100" alt="Jaipur - The Super Fashion Show" title="Jaipur - The Super Fashion Show">
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
