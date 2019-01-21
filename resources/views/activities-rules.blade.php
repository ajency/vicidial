@extends('layouts.default')

@php
  if ($storename == 'jaipur') {
  	$title = 'Rules of the show';
  	$date = '26th January, 2019';
  	$venue = 'Triton Mall, Plot No. 1/1, Near Chomu Pulia Circle, Jhitwara Rd, Jaipur, Rajasthan.';
  	$registrationDate = 'January 25th, 2019; 7:00 P.M';
  	$redirectLink = 'https://goo.gl/forms/yASCybdisxnuAhjT2';
  } else {
  	$title = 'Rules of the Competition';
  	$date = '26th January, 2019';
  	$venue = 'G-5, G-6, G-7, F-105, Om Arcade, Anandmahal, Adajan, Surat. Gujarat - 395009.';
  	$registrationDate = 'January 25th, 2019; 5:00 P.M';
  	$redirectLink = 'https://goo.gl/forms/gnbLVZiUuMZDE1PA2';
  }
@endphp


@section('headjs')

@stop

@section('content')


@if ($storename == 'jaipur')

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

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="font-weight-bold my-4 py-4 text-uppercase text-center">Rules &amp; Regulations</h2>
			</div>
			<div class="col-sm-12">
				<div class="row justify-content-center p-sm-3">
			      <div class="col-sm-12 mb-sm-3 bg-lightgray py-3">
			         <div class="points rules">
			            <ol>
			               <li class="group-body">
			                  Date of the show: <strong>{{$date}}</strong>
			               </li>
			               <li class="group-body">
			                  Venue: <strong>{{$venue}}</strong>
			               </li>
			               <li class="group-body">
								@if ($storename == 'jaipur')
									All the participants needs to pre-register in order to participate in the competition.
								@else
									Contact No: <a href="tel:0261-2737303" class="kss-anchor">0261-2737303</a> / <a href="tel:0261-2737304" class="kss-anchor">0261-2737304</a>
								@endif
			               </li>
			               <li class="group-body">
			                  Please visit <a href="http://www.kidsuperstore.in" class="kss-anchor">www.kidsuperstore.in</a> to register yourself.
			               </li>
			               <li class="group-body">
			                   The last day to register is <strong>{{$registrationDate}}</strong>
			               </li>
			               @if ($storename == 'jaipur')
			               <li class="group-body">
								All the participants are requested to be in premises by <strong>3:00 P.M</strong>
			               </li>
			               <li class="group-body">
			               		The participants would be divided into sequences as suggested by the stylist.
			               </li>
			               <li class="group-body">
			               		Parents won't be allowed in the changing room as well as in backstage.
			               </li>
			               <li class="group-body">
			               		Garments have to be returned to the co-ordinators. No garments should be taken home.
			               </li>
			               <li class="group-body">
			               		Please take care of the merchandise worn.
			               </li>
			               <li class="group-body">
			               		If any of our merchandise/product is damaged or missing, the concerned participant would be fined.
			               </li>
			               <li class="group-body">
			               		The participants have to take care of their belongings, the management shall not be liable for any loss or theft of the items outside the green room.
			               </li>
			               <li class="group-body">
			               		The tags (if any) of the merchandise worn should be returned while handling over the merchandise at the end of the show.
			               </li>
			               <li class="group-body">
			               		<a href="http://www.kidsuperstore.in" class="kss-anchor">Kidsuperstore.in</a> reserves all the rights to use any photograph, video, audio, interview during the course of the show for the branding purpose.
			               </li>
			               <li class="group-body">
			               		Awards will be announced on the same day and the participants are requested to stay till the ceremony.
			               </li>
			               @else
			               <li class="group-body">
		               			The participants would be divided into three Groups: 
								<ol class="lower-roman mt-3">
			                     <li class="group-body">
			                        <strong>Super 1</strong> - Children till the age of 5 years will participate under the group <strong>'SUPER 1'</strong>
			                     </li>
			                     <li class="group-body">
			                        <strong>Super 2</strong> - Children between 6 years till 10 years will participate under the group <strong>'SUPER 2'</strong>
			                     </li>
			                     <li class="group-body">
			                        <strong>Super 3</strong> - Children between 11 years till 14 years will participate under the group <strong>'SUPER 3'</strong>
			                     </li>
			                  </ol>
			               </li>
			               <li class="group-body">
			               		Parents for group <strong>'SUPER 1'</strong> can stay with their children during the competition.
			               </li>
			               <li class="group-body">
			               		But parents for the other age groups would have to leave the premises while the competition is on.
			               </li>
			               <li class="group-body">
			               		Timing for the competition: <strong>2:30 P.M - 5:30 P.M</strong>
			               </li>
			               <li class="group-body">
			               		All the participants should be present in the premises by <strong>2:00 P.M</strong>
			               </li>
			               <li class="group-body">
			               		Participants need to carry their own painting equipment like colors, brushes, palette, drawing board etc. Paper &amp; water would be provided by the organising committee. 
			               </li>
			               <li class="group-body">
			               		The result of the competition will be announced on January 26th itself. The award ceremony will start from 6:00 P.M onwards. All the participants are requested to stay for the ceremony.
			               </li>
			               <li class="group-body">
			               		All the decision taken by the authorised jury will not be changed under any circumstances.
			               </li>
			               <li class="group-body">
			               		<a href="http://www.kidsuperstore.in" class="kss-anchor">Kidsuperstore.in</a> reserves all the rights to use any of the artwork for their marketing and promotion purpose.
			               </li>
			               @endif
			            </ol>
			         </div>                                  
			      </div>
			   </div>
				
				<div class="check-terms mt-4 mt-sm-2">
					<div class="custom-control custom-checkbox">
			            <input type="checkbox" class="custom-control-input agree-terms" id="agree-terms">
			            <label class="custom-control-label f-w-4 pt-sm-1 pl-2" for="agree-terms">I hereby agree to the terms and conditions</label>
			        </div>
			        <div class="d-block d-sm-inline-flex my-4 text-center text-sm-left">
		        		<a href="{{$redirectLink}}" class="btn kss-btn kss-btn--primary kss-btn--big terms-accepted-btn disabled" target="_blank">Register</a>
		        	</div>
		        </div>

			</div>
		</div>
	</div>
</section>

@stop


@section('footjs')
<!-- Terms check disabled -->
<script type="text/javascript">
  	const terms = document.querySelector('.agree-terms');
  	const submitBtn = document.querySelector('.terms-accepted-btn');
  	// Browser back checkbox clear
	terms.checked = false;
	function enableBtn(e){
	  	submitBtn.classList.toggle('disabled');
	}

  	terms.addEventListener('change', enableBtn);
</script>

@stop