@extends('layouts.default')

@section('headjs')

@stop

@section('content')

<!-- Banner -->
<div class="kss_banner_sm justify-content-center d-flex p-3 p-md-5 text-white bg-dark">
   <div class="align-self-center text-center">
      <h1 class="display-6 bold mt-4 mb-1 banner-title">KidSuperStore Stores - Adjan, Surat</h1>
   </div>
</div>

<div class="container mt-5">
   <div class="row">
      <div class="col-12 col-md-8 mb-3">
        <ul id="storeSlider" class="cs-hidden ">
          <li class="item-a" data-thumb="{{CDN::asset('/img/stores/surat1-small.jpg') }}">
            <img class="card-img-top lazyload blur-up"
                src="{{CDN::asset('/img/stores/surat1-10px.jpg') }}"
                data-srcset="{{CDN::asset('/img/stores/surat1-large.jpg') }} 1280w,
                             {{CDN::asset('/img/stores/surat1-medium.jpg') }} 640w,
                             {{CDN::asset('/img/stores/surat1-small.jpg') }} 320w"
                data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                title="Adajan, Surat"
                alt="Adajan, Surat"/>
          </li>
          <li class="item-b" data-thumb="{{CDN::asset('/img/stores/surat1-small.jpg') }}">
            <img class="card-img-top lazyload blur-up"
                src="{{CDN::asset('/img/stores/surat1-10px.jpg') }}"
                data-srcset="{{CDN::asset('/img/stores/surat1-large.jpg') }} 1280w,
                             {{CDN::asset('/img/stores/surat1-medium.jpg') }} 640w,
                             {{CDN::asset('/img/stores/surat1-small.jpg') }} 320w"
                data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                title="Adajan, Surat"
                alt="Adajan, Surat"/>
          </li>
          <li class="item-c" data-thumb="{{CDN::asset('/img/stores/surat1-small.jpg') }}">
            <img class="card-img-top lazyload blur-up"
                src="{{CDN::asset('/img/stores/surat1-10px.jpg') }}"
                data-srcset="{{CDN::asset('/img/stores/surat1-large.jpg') }} 1280w,
                             {{CDN::asset('/img/stores/surat1-medium.jpg') }} 640w,
                             {{CDN::asset('/img/stores/surat1-small.jpg') }} 320w"
                data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                title="Adajan, Surat"
                alt="Adajan, Surat"/>
          </li>
          <li class="item-d" data-thumb="{{CDN::asset('/img/stores/surat1-small.jpg') }}">
            <img class="card-img-top lazyload blur-up"
                src="{{CDN::asset('/img/stores/surat1-10px.jpg') }}"
                data-srcset="{{CDN::asset('/img/stores/surat1-large.jpg') }} 1280w,
                             {{CDN::asset('/img/stores/surat1-medium.jpg') }} 640w,
                             {{CDN::asset('/img/stores/surat1-small.jpg') }} 320w"
                data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                title="Adajan, Surat"
                alt="Adajan, Surat"/>
          </li>
          <li class="item-e" data-thumb="{{CDN::asset('/img/stores/surat1-small.jpg') }}">
            <img class="card-img-top lazyload blur-up"
                src="{{CDN::asset('/img/stores/surat1-10px.jpg') }}"
                data-srcset="{{CDN::asset('/img/stores/surat1-large.jpg') }} 1280w,
                             {{CDN::asset('/img/stores/surat1-medium.jpg') }} 640w,
                             {{CDN::asset('/img/stores/surat1-small.jpg') }} 320w"
                data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                title="Adajan, Surat"
                alt="Adajan, Surat"/>
          </li>
        </ul>
      </div>
      <div class="col-12 col-md-4">
        <h4 class="font-weight-bold mb-2">Location</h4>
        <div class="h5 text-gray">Anand Mahal Road, Adajan, Surat</div>

        <h4 class="font-weight-bold mt-5 mb-2">Address</h4>
        <div class="h5 text-gray">G-5, G-6, G-7, F-105, Om Arcade, Anandmahal Road, Adajan, Surat, Gujarat - 395009</div>

        <a href="#" class="btn btn-primary my-2">View on Google Maps</a>

        <h4 class="font-weight-bold mt-5 mb-2">Store Manager</h4>
        <div class="h5 text-gray">Varoon</div>

        <h4 class="font-weight-bold mt-5 mb-2">Timings</h4>
        <div class="h5 text-gray">Monday to Sunday 11AM to 9PM</div>

        <h4 class="font-weight-bold mt-5 mb-2">Contact</h4>
        <div class="h5 text-gray">Phone: 9825487871</div>
        <div class="h5 text-gray">Email: varoon@omniedgeretail.com</div>
      </div>
   </div>
</div>

@stop