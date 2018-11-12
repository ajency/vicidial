@extends('layouts.default')

@php
  $delaycss = true;
@endphp

@section('headjs')
  @include('includes.abovethefold.homecss')
@stop

@section('content')
 <div id="home-slider" class="home-slider">
    <div  class="home-slide-item">
      <a href="#">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/home-banner-large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/home-banner-medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/home-banner-small.jpg') }} 700w,"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/home-banner-portrait-large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/home-banner-portrait-medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/home-banner-portrait-small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/home-banner-20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Kidsuperstore Banner - Stylish kids-wear collections under Rs.999" title="Stylish kids-wear collections under Rs.999">
        </picture>
      </a>
    </div>
    <div class="home-slide-item">
      <a href="/tshirt/">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/home-banner-boys-large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/home-banner-boys-medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/home-banner-boys-small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/home-banner-boys-portrait-large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/home-banner-boys-portrait-medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/home-banner-boys-portrait-small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/home-banner-boys-20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up" alt="Kidsuperstore Banner - Trending tshirts for boys and girls" title="Trending tshirts for boys and girls">
        </picture>
      </a>
    </div>
    <div class="home-slide-item">
      <a href="/apparels/girls/dress/">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/home-banner-girls-large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/home-banner-girls-medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/home-banner-girls-small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/home-banner-girls-portrait-large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/home-banner-girls-portrait-medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/home-banner-girls-portrait-small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/home-banner-girls-20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up" alt="Kidsuperstore Banner - Pretty dresses for girls" title="Pretty dresses for girls">
        </picture>
      </a>
    </div>
</div>
<section class="mt-5">
  <div class="container mb-3">
      <div class="row">
          <div class="col-md-3 col-6 mb-md-0 mb-3">
            <a href="/infant/" class="card link-card border-0 text-center pt-3" style="background-color:#EEFAFC;">
                <label class="font-weight-bold m-0 link-card_text">0-2 YEARS</label>
                <h4 class="font-weight-bold link-card_text">Infants</h4>
                <hr class="w-25 m-auto border-dark">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="{{CDN::asset('/img/gender/infant-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/gender/infant-large.jpg') }} 813w,
                                 {{CDN::asset('/img/gender/infant-medium.jpg') }} 542w,
                                 {{CDN::asset('/img/gender/infant-small.jpg') }} 271w"
                    data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                    title="Infants 0-2 years"
                    alt="Infants 0-2 years"/>
            </a>
          </div>
          <div class="col-md-3 col-6 mb-md-0 mb-3" >
            <a href="/boys/juniors--toddler--toddlers/" class="card link-card border-0 text-center pt-3" style="background-color:#F3F3F1;">
                <label class="font-weight-bold m-0 link-card_text">2-14 YEARS</label>
                <h4 class="font-weight-bold link-card_text">Boys</h4>
                <hr class="w-25 m-auto border-dark">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/gender/boy-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/gender/boy-large.jpg') }} 813w,
                                   {{CDN::asset('/img/gender/boy-medium.jpg') }} 542w,
                                   {{CDN::asset('/img/gender/boy-small.jpg') }} 271w"
                      data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                      title="Boys 2-14 years"
                      alt="Boys 2-14 years"/>
            </a>
          </div>
          <div class="col-md-3 col-6" >
            <a href="/girls/juniors--toddler--toddlers/" class="card link-card border-0 text-center pt-3" style="background-color:#F4E6DC;">
                <label class="font-weight-bold m-0 link-card_text">2-14 YEARS</label>
                 <h4 class="font-weight-bold link-card_text">Girls</h4>
                 <hr class="w-25 m-auto border-dark">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/gender/girl-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/gender/girl-large.jpg') }} 813w,
                                   {{CDN::asset('/img/gender/girl-medium.jpg') }} 542w,
                                   {{CDN::asset('/img/gender/girl-small.jpg') }} 271w"
                      data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                      title="Girls 2-14 years"
                      alt="Girls 2-14 years"/>
            </a>
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
                    <a href="/accessories/others/">
                      <img class="d-block w-100 img-fluid lazyload blur-up"
                        src="{{CDN::asset('/img/new-arrival/slider-bag-10px.jpg') }}"
                        data-srcset="{{CDN::asset('/img/new-arrival/slider-bag-large.jpg') }} 813w,
                                     {{CDN::asset('/img/new-arrival/slider-bag-medium.jpg') }} 542w,
                                     {{CDN::asset('/img/new-arrival/slider-bag-small.jpg') }} 271w"
                        data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                        alt="New Arrivals - Accessories"
                        title="New Arrivals - Accessories"/>
                      </a>
                  </div>
                  <div class="carousel-item">
                    <a href="/shoes/">
                      <img class="d-block w-100 img-fluid lazyload blur-up"
                        src="{{CDN::asset('/img/new-arrival/slider-shoes-10px.jpg') }}"
                        data-srcset="{{CDN::asset('/img/new-arrival/slider-shoes-large.jpg') }} 813w,
                                     {{CDN::asset('/img/new-arrival/slider-shoes-medium.jpg') }} 542w,
                                     {{CDN::asset('/img/new-arrival/slider-shoes-small.jpg') }} 271w"
                        data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                        alt="New Arrivals - Shoes"
                        title="New Arrivals - Shoes"/>
                    </a>
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
          <h2 class="font-weight-bold mb-3">Styles In Focus</h2>
          <!-- <p>Lorem ipsum dolor sit amet</p> -->
        </div>
    </div>
</div>
</section>

<section>
  <div class="container">
  <div class="trend-focus-wrapper">
    <a href="/apparels/woven-tops/" class="trend-box d-block link-card" style="background-color:#F4D5D3;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0 link-card_text">Woven tops</h4>
        <!-- <p class="link-card_text">Lorem ipsum dolor sit amet</p> -->
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src="{{CDN::asset('/img/collection/woven-tops-10px.jpg') }}"
          data-srcset="{{CDN::asset('/img/collection/woven-tops-large.jpg') }} 818w,
                       {{CDN::asset('/img/collection/woven-tops-medium.jpg') }} 409w,
                       {{CDN::asset('/img/collection/woven-tops-small.jpg') }} 250w"
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Party Showstoppers"
          title="Party Showstoppers"/>
    </a>
    <a href="/apparels/jeans/" class="trend-box d-block link-card" style="background-color:#feedcf;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0 link-card_text">Jeans</h4>
        <!-- <p class="link-card_text">Lorem ipsum dolor sit amet</p> -->
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src="{{CDN::asset('/img/collection/jeans-10px.jpg') }}"
          data-srcset="{{CDN::asset('/img/collection/jeans-large.jpg') }} 818w,
                       {{CDN::asset('/img/collection/jeans-medium.jpg') }} 409w,
                       {{CDN::asset('/img/collection/jeans-small.jpg') }} 250w"
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - House Of Comfort"
          title="House Of Comfort"/>
    </a>
    <a href="/apparels/ethnic/" class="trend-box d-block link-card" style="background-color:#efe665;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0 link-card_text">Ethnic</h4>
        <!-- <p class="link-card_text">Lorem ipsum dolor sit amet</p> -->
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src="{{CDN::asset('/img/collection/ethnic-10px.jpg') }}"
          data-srcset="{{CDN::asset('/img/collection/ethnic-large.jpg') }} 818w,
                       {{CDN::asset('/img/collection/ethnic-medium.jpg') }} 409w,
                       {{CDN::asset('/img/collection/ethnic-small.jpg') }} 250w"
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Party Showstoppers"
          title="Party Showstoppers"/>
    </a>
    <a href="/apparels/infant-utility/" class="trend-box d-block link-card" style="background-color:#fcfbff;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0 link-card_text">Infant Accessories</h4>
        <!-- <p class="link-card_text">Lorem ipsum dolor sit amet</p> -->
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src="{{CDN::asset('/img/collection/infant-accessories-10px.jpg') }}"
          data-srcset="{{CDN::asset('/img/collection/infant-accessories-large.jpg') }} 818w,
                       {{CDN::asset('/img/collection/infant-accessories-medium.jpg') }} 409w,
                       {{CDN::asset('/img/collection/infant-accessories-small.jpg') }} 250w"
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Floral Pattern"
          title="Floral Pattern"/>
    </a>
    <a href="/apparels/dress/" class="trend-box d-block link-card" style="background-color:#ed8d77;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0 link-card_text">Dresses</h4>
        <!-- <p class="link-card_text">Lorem ipsum dolor sit amet</p> -->
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
            src="{{CDN::asset('/img/collection/dresses-10px.jpg') }}"
            data-srcset="{{CDN::asset('/img/collection/dresses-large.jpg') }} 818w,
                         {{CDN::asset('/img/collection/dresses-medium.jpg') }} 409w,
                         {{CDN::asset('/img/collection/dresses-small.jpg') }} 250w"
            data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
            alt="Trend in Focus - House Of Comfort"
            title="House Of Comfort"/>
    </a>
    <a href="/shirt/" class="trend-box d-block link-card" style="background-color:#eaeaea;">
      <div class="p-3">
        <h4 class="font-weight-bold m-0 link-card_text">Shirts</h4>
        <!-- <p class="link-card_text">Lorem ipsum dolor sit amet</p> -->
      </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
          src="{{CDN::asset('/img/collection/shirt-10px.jpg') }}"
          data-srcset="{{CDN::asset('/img/collection/shirt-large.jpg') }} 818w,
                       {{CDN::asset('/img/collection/shirt-medium.jpg') }} 409w,
                       {{CDN::asset('/img/collection/shirt-small.jpg') }} 250w"
          data-sizes='(min-width: 1200px) 366px, (min-width: 991px) 28vw,  (min-width: 768px) 46vw,  91vw'
          alt="Trend in Focus - Party Showstoppers"
          title="Party Showstoppers"/>
    </a>
  </div>
</div>
</section>


<section class="section">
  <div class="container mt-5">
      <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="font-weight-bold mb-3">Product of the Day</h2>
            <!-- <p>Lorem ipsum dolor sit amet</p> -->
          </div>
      </div>
  </div>
</section>
<section id="kss-clothings" class="stripe-bg-top">
  <div class="container ">
    <div id="card-list" class="overflow-m row">
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/white-cotton-shirt-251-white/buy/">
            <div class="">
             <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-medium.jpg') }} 370w,
                               {{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="White Cotton Shirt"
                  alt="White Cotton Shirt"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/grey-printed-graphic-t-shirt-1441-grey/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-medium.jpg') }} 400w,
                               {{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Grey printed graphic t-shirt"
                  alt="Grey printed graphic t-shirt"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/a-line-marigold-embroidered-dress-982-turquoise/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-large.jpg') }} 810w,
                               {{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="A-line Marigold Embroidered Dress"
                  alt="A-line Marigold Embroidered Dress"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/chambray-hemla-dress-coral-972-coral/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-large.jpg') }} 810w,
                               {{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-small.jpg') }} 326w"
                 data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                 title="Chambray Hemla Dress Coral"
                 alt="Chambray Hemla Dress Coral"/>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/casual-indigo-shorts-210-dark-wash/buy/">
            <div class="">
             <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-large.jpg') }} 697w,
                               {{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Casual indigo shorts"
                  alt="Casual indigo shorts"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/circular-knit-boys-graphic-tshirt-1059-blue/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/infant-boys-t-shirt-3070-color-blue-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/infant-boys-t-shirt-3070-color-blue-1-medium.jpg') }} 450w,
                               {{CDN::asset('/img/product-of-day/infant-boys-t-shirt-3070-color-blue-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Circular knit boys graphic tshirt"
                  alt="Circular knit boys graphic tshirt"/>
           </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/grey-circular-knit-graphic-girls-tshirt-1272-grey/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-medium.jpg') }} 537w,
                               {{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Grey circular knit graphic girls tshirt"
                  alt="Grey circular knit graphic girls tshirt"/>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 col-6  ">
        <div class="card h-100 product-card">
          <a href="/cotton-printed-girls-rompers-1061-white/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-medium.jpg') }} 448w,
                               {{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 267px, (min-width: 991px) 22vw, 41vw'
                  title="Cotton printed girls rompers"
                  alt="Cotton printed girls rompers"/>
           </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- <section>
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
</section> -->

@stop