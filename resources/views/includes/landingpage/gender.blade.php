@extends('layouts.default')

@php
  if ($gendername == 'boys') {
  	$title = 'Boys';
  	$date = '26th January 2019';
  	$venue = 'Triton Mall, Plot No. 1/1, Near Chomu Pulia Circle, Jhitwara Rd, Jaipur, Rajasthan.';
  	$registrationDate = 'January 25th, 2019; 7:00 PM';
  	$redirectLink = 'https://goo.gl/forms/yASCybdisxnuAhjT2';
  } else if ($gendername == 'girls') {
  	$title = 'Girls';
  	$date = '26th January 2019';
  	$venue = 'G-5, G-6, G-7, F-105, Om Arcade, Anandmahal, Adajan, Surat. Gujarat - 395009.';
  	$registrationDate = 'January 25th, 2019; 5:00 PM';
  	$redirectLink = 'https://goo.gl/forms/gnbLVZiUuMZDE1PA2';
  }
  else{
	$title = 'Infants';
  }
@endphp


@section('headjs')

@stop

@section('content')


@if ($gendername == 'boys')

<div class="activities-banner">
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
@else

<div class="activities-banner">
     <picture>
       <source media="(orientation: landscape)"
              data-srcset="{{CDN::asset('/img/our-activities/painting-banner-large.jpg') }} 2000w,
                          {{CDN::asset('/img/our-activities/painting-banner-medium.jpg') }} 1200w,
                          {{CDN::asset('/img/our-activities/painting-banner-small.jpg') }} 700w"
              sizes="100vw">

       <source media="(orientation: portrait)"
              data-srcset="{{CDN::asset('/img/our-activities/painting-banner-portrait-large.jpg') }} 1200w,
                          {{CDN::asset('/img/our-activities/painting-banner-portrait-medium.jpg') }} 700w,
                          {{CDN::asset('/img/our-activities/painting-banner-portrait-small.jpg') }} 400w"
              sizes="100vw">

       <img src="{{CDN::asset('/img/our-activities/painting-banner-20px.jpg') }}"
           data-sizes="100vw"
           class="img-fluid lazyload blur-up w-100" alt="Surat - Kids Painting Competition" title="Surat - Kids Painting Competition">
    </picture>
</div>

@endif



@stop
