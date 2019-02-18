@extends('layouts.default')

@php
  if (\Request::is('stores/surat')) {
      $name = "Adjan, Surat";
      $location = "Anand Mahal Road, Adajan, Surat";
      $address = "G-5, G-6, G-7, F-105, Om Arcade, Anandmahal Road, Adajan, Surat, Gujarat - 395009";
      $manager = "Varoon";
      $timings = "10:30am to 10:00pm";
      $phone = "9825487871";
      $email = "varoon@omniedgeretail.com";
  } else if (\Request::is('stores/coimbatore')){
      $name = "R.S. Puram, Coimbatore";
      $location = "D.B. Road, R.S. Puram, Coimbatore";
      $address = "Shop No. 97, D.B. Road, R.S. Puram, Coimbatore, Tamil Nadu - 641002";
      $manager = "Chinraj";
      $timings = "10:30am to 10:00pm";
      $phone = "9787046725";
      $email = "2001@omniedgeretail.com";
  } else if (\Request::is('stores/hyderabad')){
      $name = "Kothapet, Hyderabad";
      $location = "Tyagaryaya Nagar, Kothapet, Hyderabad";
      $address = "Six Mall, Opp. Fruit Market, H.No:128, 128/2 & 129, 23-106/1, 23-106/18, 23-107, Tyagaryaya Nagar, Kothapet, Hyderabad, Telangana - 500035";
      $manager = "Shashi";
      $timings = "10:30am to 10:00pm";
      $phone = "9959159192";
      $email = "2007@omniedgeretail.com";
  } else if (\Request::is('stores/jaipur')){
      $name = "Triton Mall, Jaipur";
      $location = "Triton Mall, Jhotwara Rd, Jaipur";
      $address = "Triton Mall, Plot No 1/1, Near Chomu Pulia Circle, Jhotwara Rd, Jaipur";
      $manager = "Sameer Khan";
      $timings = "10:30am to 10:00pm";
      $phone = "8949127903";
      $email = "2009_sm@omniedgeretail.com";
  }
@endphp

@section('headjs')

@stop

@section('content')

<!-- Banner -->
<div class="kss_banner_sm justify-content-center d-flex p-3 p-md-5 text-white bg-dark">
   <div class="align-self-center text-center">
      <h1 class="display-6 bold mt-4 mb-1 banner-title">KidSuperStore Stores - {{$name}}</h1>
   </div>
</div>


<div class="container mt-5">
   <div class="row">
      <div class="col-12 col-md-8 mb-3 @if (\Request::is('stores/jaipur')) jaipur-col @endif">

        @if (\Request::is('stores/surat'))
          <ul id="storeSlider" class="cs-hidden ">
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat/surat8-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat8-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat8-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat8-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat8-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-a" data-thumb="{{CDN::asset('/img/stores/surat/surat1-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat1-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat1-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat1-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-b" data-thumb="{{CDN::asset('/img/stores/surat/surat2-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat2-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat2-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat2-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat2-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-c" data-thumb="{{CDN::asset('/img/stores/surat/surat3-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat3-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat3-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat3-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat3-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-d" data-thumb="{{CDN::asset('/img/stores/surat/surat4-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat4-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat4-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat4-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat4-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat/surat5-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat5-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat5-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat5-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat5-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat/surat6-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat6-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat6-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat6-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat6-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat/surat7-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat7-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat7-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat7-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat7-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat/surat9-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat9-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat9-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat9-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat9-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat/surat10-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/surat/surat10-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/surat/surat10-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/surat/surat10-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/surat/surat10-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Adajan, Surat"
                  alt="Adajan, Surat"/>
            </li>
          </ul>
        @endif

        @if (\Request::is('stores/coimbatore'))
          <ul id="storeSlider" class="cs-hidden ">
            <li class="item-a" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore1-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore1-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore1-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore1-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-b" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore2-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore2-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore2-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore2-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore2-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-c" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore3-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore3-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore3-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore3-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore3-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-d" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore4-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore4-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore4-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore4-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore4-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore5-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore5-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore5-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore5-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore5-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore6-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore6-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore6-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore6-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore6-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore7-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore7-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore7-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore7-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore7-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore8-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore8-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore8-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore8-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore8-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
            <li class="item-e" data-thumb="{{CDN::asset('/img/stores/coimbatore/coimbatore9-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/coimbatore/coimbatore9-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/coimbatore/coimbatore9-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore9-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/coimbatore/coimbatore9-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="R.S. Puram, Coimbatore"
                  alt="R.S. Puram, Coimbatore"/>
            </li>
          </ul>
        @endif

        @if (\Request::is('stores/hyderabad'))
          <ul id="storeSlider" class="cs-hidden ">
            <li class="item-c" data-thumb="{{CDN::asset('/img/stores/hyderabad/hyderabad3-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/hyderabad/hyderabad3-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/hyderabad/hyderabad3-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad3-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad3-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Kothapet, Hyderabad"
                  alt="Kothapet, Hyderabad"/>
            </li>
            <li class="item-a" data-thumb="{{CDN::asset('/img/stores/hyderabad/hyderabad1-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/hyderabad/hyderabad1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/hyderabad/hyderabad1-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad1-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad1-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Kothapet, Hyderabad"
                  alt="Kothapet, Hyderabad"/>
            </li>
            <li class="item-b" data-thumb="{{CDN::asset('/img/stores/hyderabad/hyderabad2-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/hyderabad/hyderabad2-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/hyderabad/hyderabad2-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad2-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad2-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Kothapet, Hyderabad"
                  alt="Kothapet, Hyderabad"/>
            </li>
            <li class="item-d" data-thumb="{{CDN::asset('/img/stores/hyderabad/hyderabad4-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/hyderabad/hyderabad4-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/hyderabad/hyderabad4-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad4-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/hyderabad/hyderabad4-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Kothapet, Hyderabad"
                  alt="Kothapet, Hyderabad"/>
            </li>
          </ul>
        @endif

        @if (\Request::is('stores/jaipur'))
          <ul id="storeSlider" class="cs-hidden ">
            <li class="item-c" data-thumb="{{CDN::asset('/img/stores/jaipur/jp-store-1-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/jaipur/jp-store-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/jaipur/jp-store-1-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-1-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-1-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Triton Mall, Jaipur"
                  alt="Triton Mall, Jaipur"/>
            </li>
            <li class="item-a" data-thumb="{{CDN::asset('/img/stores/jaipur/jp-store-2-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/jaipur/jp-store-2-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/jaipur/jp-store-2-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-2-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-2-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Triton Mall, Jaipur"
                  alt="Triton Mall, Jaipur"/>
            </li>
            <li class="item-b" data-thumb="{{CDN::asset('/img/stores/jaipur/jp-store-3-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/jaipur/jp-store-3-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/jaipur/jp-store-3-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-3-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-3-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Triton Mall, Jaipur"
                  alt="Triton Mall, Jaipur"/>
            </li>
            <li class="item-d" data-thumb="{{CDN::asset('/img/stores/jaipur/jp-store-4-small.jpg') }}">
              <img class="card-img-top lazyload blur-up"
                  src="{{CDN::asset('/img/stores/jaipur/jp-store-4-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/stores/jaipur/jp-store-4-large.jpg') }} 1200w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-4-medium.jpg') }} 770w,
                               {{CDN::asset('/img/stores/jaipur/jp-store-4-small.jpg') }} 480w"
                  data-sizes='(min-width: 1200px) 770px, (min-width: 768px) 62vw,  94vw'
                  title="Triton Mall, Jaipur"
                  alt="Triton Mall, Jaipur"/>
            </li>

          </ul>          
        @endif
      </div>
      <div class="col-12 col-md-4">
        <h4 class="font-weight-bold mb-2">Location</h4>
        <div class="h5 text-gray line-height-5">{{$location}}</div>

        <h4 class="font-weight-bold mt-5 mb-2">Address</h4>
        <div class="h5 text-gray line-height-5">{{$address}}</div>

        @if (\Request::is('stores/surat'))
          <a href="https://www.google.com/maps/search/?api=1&query=21.19279,72.79981" target="_blank" class="btn btn-primary my-2 font-weight-bold">View on Google Maps</a>
        @endif
        @if (\Request::is('stores/coimbatore'))
          <a href="https://www.google.com/maps/search/?api=1&query=11.00742,76.95087" target="_blank" class="btn btn-primary my-2 font-weight-bold">View on Google Maps</a>
        @endif
        @if (\Request::is('stores/jaipur'))
          <a href="https://www.google.com/maps/search/?api=1&query=26.941362,75.771318" target="_blank" class="btn btn-primary my-2 font-weight-bold">View on Google Maps</a>
        @endif

        <h4 class="font-weight-bold mt-5 mb-2">Store Manager</h4>
        <div class="h5 text-gray line-height-5">{{$manager}}</div>

        <h4 class="font-weight-bold mt-5 mb-2">Timings</h4>
        <div class="h5 text-gray line-height-5">{{$timings}}</div>

        <h4 class="font-weight-bold mt-5 mb-2">Contact</h4>
        <div class="h5 text-gray line-height-5">Phone: {{$phone}}</div>
        <div class="h5 text-gray line-height-5">Email: {{$email}}</div>

      </div>
   </div>
</div>


<div class="container-fluid mt-5 py-5" style="margin-bottom:-50px; background-color: #f6f6f6;">
  <h2 class="font-weight-bold pt-2 pb-5 text-center">Why Visit Us?</h2>

  <div class="container">

    <div class="row">
      <div class="col-sm-6">

        <div class="accordion collapse-style-2" id="whyvisit">
          <div class="card border-0">
            <div class="card-header border-0" id="touchfeel">
              <div class="h4 font-weight-bold mb-0 cursor-pointer" data-toggle="collapse" data-target="#collapseTouch" aria-expanded="true" aria-controls="collapseTouch">
                Touch And Feel The Products
              </div>
            </div>

            <div id="collapseTouch" class="collapse show" aria-labelledby="touchfeel" data-parent="#whyvisit">
              <div class="card-body h5">
                Lack of touch-feel-try creates concerns over the quality of the product on offer. At our stores you can feel and try the products you want thus giving you more confidence in the purchase you make.
              </div>
            </div>
          </div>
          <div class="card border-0">
            <div class="card-header border-0" id="experience">
              <div class="h4 font-weight-bold mb-0 cursor-pointer collapsed" data-toggle="collapse" data-target="#collapseExperience" aria-expanded="false" aria-controls="collapseExperience">
                Superior Shopping Experience
              </div>
            </div>
            <div id="collapseExperience" class="collapse" aria-labelledby="experience" data-parent="#whyvisit">
              <div class="card-body h5">
                You can try a variety of styles and combinations and see which one suits you firsthand. Plus our team is always there to help you select the best style and fit.
              </div>
            </div>
          </div>
          <div class="card border-0">
            <div class="card-header border-0" id="discounts">
              <div class="h4 font-weight-bold mb-0 cursor-pointer collapsed" data-toggle="collapse" data-target="#collapseDiscounts" aria-expanded="false" aria-controls="collapseDiscounts">
                Great Discounts At Our Stores
              </div>
            </div>
            <div id="collapseDiscounts" class="collapse" aria-labelledby="discounts" data-parent="#whyvisit">
              <div class="card-body h5">
                We have attractive discounts which are only available in-store. We offer the irresistible deals and discounts for almost every product on our store.
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="col-sm-6">
        <img class="img-fluid"
            src="{{CDN::asset('/img/kss_why.png') }}"
            title="Why KSS"
            alt="Why KSS"/>
      </div>
    </div>

  </div>
</div>

@stop