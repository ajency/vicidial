@extends('layouts.default')

@section('headjs')

@stop

@section('content')

<!-- Banner -->
<div class="kss_banner kss_banner_bg justify-content-center d-flex p-3 p-md-5 text-white bg-dark" style="background-image: url({{CDN::asset('/img/stores/banner/hyderabad-store-banner.jpg') }})">
   <div class="align-self-center text-center banner-content">
      <h1 class="display-5 bold mt-4 mb-1 banner-title banner-title--white">The KidSuperStore Stores</h1>
      <h4 class="font-weight-bold d-none d-sm-block">Want to see our clothes in real life? Now you can! Visit any one of our stores and experience our different variety of clothes and styles. Our stores are about as fun as they get, it won't even feel like you're shopping!</h4>
   </div>
</div>

<div class="container mt-3">
   <div class="row">
      <div class="col-12">

         <h2 class="font-weight-bold my-5 text-center">Check Out Out Existing Stores In Below Localities</h2>

         <div class="row justify-content-around">
            <div class="col-12 col-md-6">
               <div class="card shadow-sm mb-5">
                  <img class="card-img-top lazyload blur-up"
                      src="{{CDN::asset('/img/stores/surat1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/stores/surat1-large.jpg') }} 1280w,
                                   {{CDN::asset('/img/stores/surat1-medium.jpg') }} 640w,
                                   {{CDN::asset('/img/stores/surat1-small.jpg') }} 320w"
                      data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                      title="Adajan, Surat"
                      alt="Adajan, Surat"/>
                  <div class="card-body">
                     <div class="d-flex justify-content-between">
                        <div class="">
                           <h4 class="font-weight-bold">Adajan, Surat</h4>
                           <h6 class="font-weight-bold text-muted">Gujarat</h6>
                        </div>
                        <div class=" text-right">
                           <a href="#" class="btn btn-outline-dark btn-lg">View Details</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-12 col-md-6">
               <div class="card shadow-sm mb-5">
                  <img class="card-img-top lazyload blur-up"
                      src="{{CDN::asset('/img/stores/coimbatore1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/stores/coimbatore1-medium.jpg') }} 640w,
                                   {{CDN::asset('/img/stores/coimbatore1-small.jpg') }} 320w"
                      data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                      title="R.S. Puram, Coimbatore"
                      alt="R.S. Puram, Coimbatore"/>
                  <div class="card-body">
                     <div class="d-flex justify-content-between">
                        <div class="">
                           <h4 class="font-weight-bold">R.S. Puram, Coimbatore</h4>
                           <h6 class="font-weight-bold text-muted">Tamil Nadu</h6>
                        </div>
                        <div class=" text-right">
                           <a href="#" class="btn btn-outline-dark btn-lg">View Details</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-12 col-md-6">
               <div class="card shadow-sm mb-5">
                  <img class="card-img-top lazyload blur-up"
                      src="{{CDN::asset('/img/stores/hyderabad1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/stores/hyderabad1-large.jpg') }} 1275w,
                                   {{CDN::asset('/img/stores/hyderabad1-medium.jpg') }} 637w,
                                   {{CDN::asset('/img/stores/hyderabad1-small.jpg') }} 319w"
                      data-sizes='(min-width: 1200px) 568px, (min-width: 768px) 46vw,  94vw'
                      title="Kothapet, Hyderabad"
                      alt="Kothapet, Hyderabad"/>
                  <div class="card-body">
                     <div class="d-flex justify-content-between">
                        <div class="">
                           <h4 class="font-weight-bold">Kothapet, Hyderabad</h4>
                           <h6 class="font-weight-bold text-muted">Telangana</h6>
                        </div>
                        <div class=" text-right">
                           <a href="#" class="btn btn-outline-dark btn-lg">View Details</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="container-fluid py-4 mt-4 bg-brown" style="margin-bottom: -50px;">
   <img class="mx-auto d-block pt-4"
         src="{{CDN::asset('/img/store_location.png') }}"
         title="Store location marker"
         alt="Store location marker"/>
   <h2 class="font-weight-bold mt-3 text-center text-black">We are expanding rapidly! More stores coming soon.</h2>
   <h4 class="text-center my-3">Be the first to know when we launch in your area</h4>

   <form class="form-inline justify-content-center my-5">
      <input type="text" class="form-control mr-sm-4 mb-3" id="inlineFormInputName2" placeholder="Pincode">

      <input type="text" class="form-control mr-sm-4 mb-3" id="inlineFormInputGroupUsername2" placeholder="Email">

      <button type="submit" class="btn btn-primary mb-3">Submit</button>
   </form>
</div>

@stop