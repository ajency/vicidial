@extends('layouts.default')

@section('headjs')

  @include('includes.abovethefold.homecss')

@stop

@section('content')
 <div id="home-slider" class="home-slider">
    <div  class="home-slide-item">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset='/img/home-banner/home-banner-large.jpg 2000w,
                              /img/home-banner/home-banner-medium.jpg 1200w,
                              /img/home-banner/home-banner-small.jpg  700w,'
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset='/img/home-banner/home-banner-portrait-large.jpg  1200w,
                              /img/home-banner/home-banner-portrait-medium.jpg  700w,
                              /img/home-banner/home-banner-portrait-small.jpg  400w'
                  sizes="100vw">

           <img src="/img/home-banner/home-banner-20px.jpg "
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Kidsuperstore Banner1" title="A New Season, A New Look">
         </picture>
    </div>
    <div class="home-slide-item">
      <picture>
         <source media="(orientation: landscape)"
                data-srcset='/img/home-banner/home-banner-boys-large.jpg 2000w,
                            /img/home-banner/home-banner-boys-medium.jpg 1200w,
                            /img/home-banner/home-banner-boys-small.jpg  700w,'
                sizes="100vw">

         <source media="(orientation: portrait)"
                data-srcset='/img/home-banner/home-banner-boys-portrait-large.jpg  1200w,
                            /img/home-banner/home-banner-boys-portrait-medium.jpg  700w,
                            /img/home-banner/home-banner-boys-portrait-small.jpg  400w'
                sizes="100vw">

         <img src="/img/home-banner/home-banner-boys-20px.jpg "
             data-sizes="100vw"
             class="img-fluid lazyload blur-up" alt="Kidsuperstore Banner2" title="A New Season, A New Look">
      </picture>
    </div>
    <div class="home-slide-item">
      <picture>
         <source media="(orientation: landscape)"
                data-srcset='/img/home-banner/home-banner-infants-large.jpg 2000w,
                            /img/home-banner/home-banner-infants-medium.jpg 1200w,
                            /img/home-banner/home-banner-infants-small.jpg  700w,'
                sizes="100vw">

         <source media="(orientation: portrait)"
                data-srcset='/img/home-banner/home-banner-infants-portrait-large.jpg  1200w,
                            /img/home-banner/home-banner-infants-portrait-medium.jpg  700w,
                            /img/home-banner/home-banner-infants-portrait-small.jpg  400w'
                sizes="100vw">

         <img src="/img/home-banner/home-banner-infants-20px.jpg "
             data-sizes="100vw"
             class="img-fluid lazyload blur-up" alt="Kidsuperstore Banner3" title="A New Season, A New Look">
       </picture>
    </div>
</div>
<section class="mt-5">
  <div class="container mb-3">
      <div class="row">
          <div class="col-md-3 col-6 mb-md-0 mb-3">
            <div class="card border-0 text-center pt-3" style="background-color:#EEFAFC;">
                <label class="font-weight-bold m-0">0-2 YEARS</label>
                <h4 class="font-weight-bold ">Infants</h4>
                <hr class="w-25 m-auto border-dark">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src='/img/gender/infant-10px.jpg'
                    data-srcset='/img/gender/infant-large.jpg 813w,
                           /img/gender/infant-medium.jpg 542w,
                           /img/gender/infant-small.jpg 271w'
                    data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                    title="Infants 0-2 years"
                    alt="Infants 0-2 years"/>
            </div>
          </div>
          <div class="col-md-3 col-6 mb-md-0 mb-3" >
            <div class="card border-0 text-center pt-3" style="background-color:#F3F3F1;">
                <label class="font-weight-bold m-0">2-14 YEARS</label>
                <h4 class="font-weight-bold">Boys</h4>
                <hr class="w-25 m-auto border-dark">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src='/img/gender/boy-10px.jpg'
                      data-srcset='/img/gender/boy-large.jpg 813w,
                             /img/gender/boy-medium.jpg 542w,
                             /img/gender/boy-small.jpg 271w'
                      data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                      title="Boys 2-14 years"
                      alt="Boys 2-14 years"/>
            </div>
          </div>
          <div class="col-md-3 col-6" >
            <div class="card border-0 text-center pt-3" style="background-color:#F4E6DC;">
                <label class="font-weight-bold m-0">2-14 YEARS</label>
                 <h4 class="font-weight-bold">Girls</h4>
                 <hr class="w-25 m-auto border-dark">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src='/img/gender/girl-10px.jpg'
                      data-srcset='/img/gender/girl-large.jpg 813w,
                             /img/gender/girl-medium.jpg 542w,
                             /img/gender/girl-small.jpg 271w'
                      data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                      title="Girls 2-14 years"
                      alt="Girls 2-14 years"/>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card border-0 p-3 text-center" style="background-color:#F3F3F1;">
              <label class="font-weight-bold">NEW ARRIVALS</label>
              <div id="slider-newarrival" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators ">
                  <li data-target="#slider-newarrival" data-slide-to="0" class="active"></li>
                  <li data-target="#slider-newarrival" data-slide-to="1"></li>
                  <li data-target="#slider-newarrival" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner mt-5">
                  <div class="carousel-item active">
                     <img class="d-block w-100 img-fluid lazyload blur-up"
                        src='/img/new-arrival/slider-bag-10px.jpg'
                        data-srcset='/img/new-arrival/slider-bag-large.jpg 813w,
                               /img/new-arrival/slider-bag-medium.jpg 542w,
                               /img/new-arrival/slider-bag-small.jpg 271w'
                        data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                        alt="New Arrivals"
                        title="New Arrivals"/>
                  </div>
                  <div class="carousel-item">
                   <img class="d-block w-100 img-fluid lazyload blur-up"
                        src='/img/new-arrival/slider-toy-10px.jpg'
                        data-srcset='/img/new-arrival/slider-toy-large.jpg 813w,
                               /img/new-arrival/slider-toy-medium.jpg 542w,
                               /img/new-arrival/slider-toy-small.jpg 271w'
                        data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                        alt="New Arrivals"
                        title="New Arrivals"/>
                  </div>
                  <div class="carousel-item">
                      <img class="d-block w-100 img-fluid lazyload blur-up"
                          src='/img/new-arrival/slider-shoes-10px.jpg'
                          data-srcset='/img/new-arrival/slider-shoes-large.jpg 813w,
                               /img/new-arrival/slider-shoes-medium.jpg 542w,
                               /img/new-arrival/slider-shoes-small.jpg 271w'
                          data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                          alt="New Arrivals"
                          title="New Arrivals"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
</section>

<section class="section">
<div class="container mt-5 ">
    <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="font-weight-bold m-0">Trend In Focus</h2>
          <p>Lorem ipsum dolor sit amet</p>
        </div>
    </div>
</div>
</section>

<section>
  <div class="container">
  <div class="trend-focus-wrapper">
    <div class="trend-box" style="background-color:#bce4f8;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0">Party Showstoppers</h4>
        <p>Lorem ipsum dolor sit amet</p>
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src='/img/collection/baby-woollen-cap-10px.jpg'
          data-srcset='/img/collection/baby-woollen-cap-large.jpg 818w,
                 /img/collection/baby-woollen-cap-medium.jpg 409w,
                 /img/collection/baby-woollen-cap-small.jpg 250w'
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Party Showstoppers"
          title="Party Showstoppers"/>
    </div>
    <div class="trend-box" style="background-color:#F4D5D3;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0">House Of Comfort</h4>
        <p>Lorem ipsum dolor sit amet</p>
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src='/img/collection/party-showstoppers-10px.jpg'
          data-srcset='/img/collection/party-showstoppers-large.jpg 818w,
               /img/collection/party-showstoppers-medium.jpg 409w,
               /img/collection/party-showstoppers-small.jpg 250w'
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - House Of Comfort"
          title="House Of Comfort"/>
    </div>
    <div class="trend-box" style="background-color:#fff8ed;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0">Party Showstoppers</h4>
        <p>Lorem ipsum dolor sit amet</p>
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src='/img/collection/printed-top-pyjama-set-10px.jpg'
          data-srcset='/img/collection/printed-top-pyjama-set-large.jpg 818w,
                 /img/collection/printed-top-pyjama-set-medium.jpg 409w,
                 /img/collection/printed-top-pyjama-set-small.jpg 250w'
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Party Showstoppers"
          title="Party Showstoppers"/>
    </div>
    <div class="trend-box" style="background-color:#ffda44;">
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src='/img/collection/girl-floral-10px.jpg'
          data-srcset='/img/collection/girl-floral-large.jpg 818w,
                 /img/collection/girl-floral-medium.jpg 409w,
                 /img/collection/girl-floral-small.jpg 250w'
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Floral Pattern"
          title="Floral Pattern"/>
    </div>
    <div class="trend-box" style="background-color:#F4D5D3;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0">House Of Comfort</h4>
        <p>Lorem ipsum dolor sit amet</p>
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
            src='/img/collection/party-showstoppers-10px.jpg'
            data-srcset='/img/collection/party-showstoppers-large.jpg 818w,
                   /img/collection/party-showstoppers-medium.jpg 409w,
                   /img/collection/party-showstoppers-small.jpg 250w'
            data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
            alt="Trend in Focus - House Of Comfort"
            title="House Of Comfort"/>
    </div>
    <div class="trend-box" style="background-color:#F4D5D3;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0">Party Showstoppers</h4>
        <p>Lorem ipsum dolor sit amet</p>
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src='/img/collection/party-showstoppers-10px.jpg'
          data-srcset='/img/collection/party-showstoppers-large.jpg 818w,
                 /img/collection/party-showstoppers-medium.jpg 409w,
                 /img/collection/party-showstoppers-small.jpg 250w'
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Party Showstoppers"
          title="Party Showstoppers"/>
    </div>
  </div>
</div>
</section>
<section class="section">
  <div class="container mt-5">
      <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="font-weight-bold m-0">Product of the Day</h2>
            <p>Lorem ipsum dolor sit amet</p>
          </div>
      </div>
  </div>
</section>
<section id="kss-clothings" class="stripe-bg-top">
  <div class="container ">
    <div id="card-list" class="overflow-m row">
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="#">
            <div class="">
             <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/1front-10px.jpg'
                  data-srcset='/img/home-list/1front-large.jpg 810w,
                         /img/home-list/1front-medium.jpg 540w,
                         /img/home-list/1front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="#">
            <div class="">
             <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/2front-10px.jpg'
                  data-srcset='/img/home-list/2front-large.jpg 810w,
                         /img/home-list/2front-medium.jpg 540w,
                         /img/home-list/2front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="#">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/3front-10px.jpg'
                  data-srcset='/img/home-list/3front-large.jpg 810w,
                         /img/home-list/3front-medium.jpg 540w,
                         /img/home-list/3front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="#">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/4front-10px.jpg'
                  data-srcset='/img/home-list/4front-large.jpg 810w,
                         /img/home-list/4front-medium.jpg 540w,
                         /img/home-list/4front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/kss/product/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/5front-10px.jpg'
                  data-srcset='/img/home-list/5front-large.jpg 810w,
                         /img/home-list/5front-medium.jpg 540w,
                         /img/home-list/5front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/kss/product/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/6front-10px.jpg'
                 data-srcset='/img/home-list/6front-large.jpg 810w,
                         /img/home-list/6front-medium.jpg 540w,
                         /img/home-list/6front-small.jpg 270w'
                 data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                 title="Product of the Day"
                 alt="Product of the Day"/>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/kss/product/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/8front-10px.jpg'
                  data-srcset='/img/home-list/8front-large.jpg 810w,
                         /img/home-list/8front-medium.jpg 540w,
                         /img/home-list/8front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/kss/product/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src='/img/home-list/7front-10px.jpg'
                  data-srcset='/img/home-list/7front-large.jpg 810w,
                         /img/home-list/7front-medium.jpg 540w,
                         /img/home-list/7front-small.jpg 270w'
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Product of the Day"
                  alt="Product of the Day"/>
           </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container mt-5">
      <div class="row">
          <div class="col-xl-6 mb-xl-0 mb-3">
             <div class=" d-flex border-0 text-left p-4" style="background-color:#FBF6D4;">
              <div class="w-50">
                <h2 class="font-weight-bold mt-3">
                  Give your child something special
                </h2>
                 <p class="text-muted mt-1">Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet</p>
              </div>
                <div class="bg-gift ml-auto">
                </div>

            </div>
          </div>
          <div class="col-xl-6">
            <div class="d-flex border-0 text-left p-4" style="background-color:#F4E6DC;">
              <div class="w-50">
                <h2 class="font-weight-bold mt-3">
                 Extra 10% off On your first purchase
                </h2>
                 <p class="text-muted mt-1">Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet</p>
              </div>
              <div class="bg-gift ml-auto">
              </div>
            </div>
          </div>
      </div>
  </div>
</section>

@stop