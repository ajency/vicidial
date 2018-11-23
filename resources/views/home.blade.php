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
                </ol>
                <div class="carousel-inner mt-5">
                  <div class="carousel-item active">
                    <a href="/accessories/others/">
                      <img class="d-block w-100 img-fluid lazyload blur-up"
                        src="{{CDN::asset('/img/new-arrival/cup-10px.jpg') }}"
                        data-srcset="{{CDN::asset('/img/new-arrival/cup-large.jpg') }} 813w,
                                     {{CDN::asset('/img/new-arrival/cup-medium.jpg') }} 542w,
                                     {{CDN::asset('/img/new-arrival/cup-small.jpg') }} 271w"
                        data-sizes='(min-width: 1200px) 270px, (min-width: 768px) 22vw,  44vw'
                        alt="New Arrivals - Jewerly"
                        title="New Arrivals - Jewerly"/>
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
          alt="Styles in Focus - Woven tops"
          title="Woven tops"/>
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
          alt="Styles in Focus - Jeans"
          title="Jeans"/>
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
          alt="Styles in Focus - Ethnic"
          title="Ethnic"/>
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
          alt="Styles in Focus - Infant Accessories"
          title="Infant Accessories"/>
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
            alt="Styles in Focus - Dresses"
            title="Dresses"/>
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
          alt="Styles in Focus - Shirts"
          title="Shirts"/>
    </a>
  </div>
</div>
</section>


<!-- Product of the day -->

<section class="section">
  <div class="container mt-5">
      <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="font-weight-bold mb-4">Trending Looks</h2>
          </div>
      </div>
  </div>
</section>
<section id="kss-clothings" class="stripe-bg-top">
  <div class="container ">
    <div id="card-list" class="overflow-m row productGrid">
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/white-cotton-shirt-251-white/buy/">
            <div class="">
             <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-medium.jpg') }} 370w,
                               {{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                  title="White Cotton Shirt"
                  alt="White Cotton Shirt"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹699</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/grey-circular-knit-graphic-girls-tshirt-1272-grey/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-medium.jpg') }} 537w,
                               {{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                  title="Grey circular knit graphic girls tshirt"
                  alt="Grey circular knit graphic girls tshirt"/>
            </div>
          </a>
          <div class="kss-price kss-price--medium">₹299</div>
        </div>
      </div>      
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/cotton-printed-girls-rompers-1061-white/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-medium.jpg') }} 448w,
                               {{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                  title="Cotton printed girls rompers"
                  alt="Cotton printed girls rompers"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹249</div>
        </div>
      </div>     
<!--       <div class="col">
        <div class="card h-100 product-card position-relative">
          <a href="/boys-navy-casual-printed-tshirt-73-navy/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/shirt-4-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/shirt-4-large.jpg') }} 978w,
                               {{CDN::asset('/img/product-of-day/shirt-4-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/shirt-4-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                  title="Boys Navy Casual Printed Tshirt"
                  alt="Boys Navy Casual Printed Tshirt"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹195</div>
        </div>
      </div> -->
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/blue-cotton-rompers-1071-navy/buy/">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="{{CDN::asset('/img/product-of-day/infant-3-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/infant-3-large.jpg') }} 978w,
                               {{CDN::asset('/img/product-of-day/infant-3-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/infant-3-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                  title="Blue Cotton Rompers"
                  alt="Blue Cotton Rompers"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹799</div>
        </div>
      </div>      
    </div>

    <!-- <div class="row mt-5">
        <div class="col-md-12 text-center">
          <h2 class="font-weight-bold mb-3">Trending for Girls</h2>
        </div>
    </div> -->

    <div id="card-list" class="overflow-m row productGrid mt-2">
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative position-relative">
              <a href="/a-line-marigold-embroidered-dress-982-turquoise/buy/">
                <div class="">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-large.jpg') }} 810w,
                                   {{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                      title="A-line Marigold Embroidered Dress"
                      alt="A-line Marigold Embroidered Dress"/>
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹695</div>
            </div>
          </div>
<!--           <div class="col">
            <div class="card h-100 product-card position-relative position-relative">
              <a href="/denim-indigo-trouser-1329-dark-blue/buy/">
                <div class="">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/girl-trouser-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/girl-trouser-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/girl-trouser-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/girl-trouser-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                      title="Denim Indigo Trouser"
                      alt="Denim Indigo Trouser"/>
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹729</div>
            </div>
          </div>  --> 
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative position-relative">
              <a href="/grey-printed-graphic-t-shirt-1441-grey/buy/">
                <div class="">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-medium.jpg') }} 400w,
                                   {{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                      title="Grey printed graphic t-shirt"
                      alt="Grey printed graphic t-shirt"/>
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹395</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative">
              <a href="/cotton-circular-knit-short-1217-turquoise/buy/">
                <div class="">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/girl-short-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/girl-short-large.jpg') }} 978w,
                                  {{CDN::asset('/img/product-of-day/girl-short-medium.jpg') }} 450w,
                                   {{CDN::asset('/img/product-of-day/girl-short-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                      title="Cotton Circular Knit Short"
                      alt="Cotton Circular Knit Short"/>
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹295</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative">
              <a href="/chambray-hemla-dress-coral-972-coral/buy/">
                <div class="">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-large.jpg') }} 810w,
                                   {{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-small.jpg') }} 326w"
                     data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                     title="Chambray Hemla Dress Coral"
                     alt="Chambray Hemla Dress Coral"/>
                </div>
              </a>
              <div class="kss-price kss-price--medium">₹895</div>
            </div>
          </div>
    </div>

    <!-- <div class="row mt-5">
        <div class="col-md-12 text-center">
          <h2 class="font-weight-bold mb-3">Trending for Infants</h2>
        </div>
    </div> -->

    <div id="card-list" class="overflow-m row productGrid mt-2">

        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative position-relative">
            <a href="/half-sleeves-navy-cotton-tshirt-1034-navy/buy/">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="{{CDN::asset('/img/product-of-day/infant-1-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/product-of-day/infant-1-large.jpg') }} 978w,
                                 {{CDN::asset('/img/product-of-day/infant-1-medium.jpg') }} 652w,
                                 {{CDN::asset('/img/product-of-day/infant-1-small.jpg') }} 326w"
                    data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                    title="Half Sleeves Navy Cotton Tshirt"
                    alt="Half Sleeves Navy Cotton Tshirt"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹299</div>
          </div>
        </div>

<!--         <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/red-all-over-printed-dress-with-belt-171-red/buy/">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="{{CDN::asset('/img/product-of-day/infant-2-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/product-of-day/infant-2-large.jpg') }} 978w,
                                 {{CDN::asset('/img/product-of-day/infant-2-medium.jpg') }} 652w,
                                 {{CDN::asset('/img/product-of-day/infant-2-small.jpg') }} 326w"
                    data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                    title="Red All Over Printed Dress With Belt"
                    alt="Red All Over Printed Dress With Belt"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹1299</div>
          </div>
        </div> -->

        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/half-sleeves-cotton-shirt-256-blue/buy/">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="{{CDN::asset('/img/product-of-day/shirt-5-shirt-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/product-of-day/shirt-5-shirt-large.jpg') }} 978w,
                                 {{CDN::asset('/img/product-of-day/shirt-5-shirt-medium.jpg') }} 652w,
                                 {{CDN::asset('/img/product-of-day/shirt-5-shirt-small.jpg') }} 326w"
                   data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                   title="Half Sleeves Cotton Shirt"
                   alt="Half Sleeves Cotton Shirt"/>
              </div>
            </a>
            <div class="kss-price kss-price--medium">₹599</div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/cobalt-casual-knit-short-1010-cobalt/buy/">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="{{CDN::asset('/img/product-of-day/infant-4-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/product-of-day/infant-4-large.jpg') }} 978w,
                                 {{CDN::asset('/img/product-of-day/infant-4-medium.jpg') }} 652w,
                                 {{CDN::asset('/img/product-of-day/infant-4-small.jpg') }} 326w"
                    data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                    title="Cobalt Casual Knit Short"
                    alt="Cobalt Casual Knit Short"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹269</div>
          </div>
        </div>      
        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/casual-indigo-shorts-210-dark-wash/buy/">
              <div class="">
               <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="{{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-large.jpg') }} 697w,
                                {{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-medium.jpg') }} 652w,
                                 {{CDN::asset('/img/product-of-day/denim-shorts-1556-color-dark-wash-3-small.jpg') }} 326w"
                    data-sizes='(min-width: 1200px) 20vw, (min-width: 991px) 22vw, 41vw'
                    title="Casual indigo shorts"
                    alt="Casual indigo shorts"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹699</div>
          </div>
        </div> 
    </div>
    <div class="text-center mt-3">
      <a href="/shop" class="viewall-link">View All</a>
    </div>
  </div>
</section>


<!-- Trending looks -->

<!-- <section class="mt-5 product-collection py-3">
  <div class="container mb-3">
    <div class="row my-4">
        <div class="col-md-12 text-center">
          <h2 class="font-weight-bold mb-2">Trending Looks</h2>
        </div>
    </div>  
    <div class="row">
      <div class="col-sm-4 mt-2 mt-sm-0 d-flex flex-column-reverse d-sm-block">
        <div class="row product-collection__wrapper">
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/white-cotton-shirt-251-white/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-medium.jpg') }} 370w,
                                   {{CDN::asset('/img/product-of-day/boys-shirt-op06-color-white-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="White Cotton Shirt"
                      alt="White Cotton Shirt"/>
               </div>
              </a>
            </div>
          </div>
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/grey-printed-graphic-t-shirt-1441-grey/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-medium.jpg') }} 400w,
                                   {{CDN::asset('/img/product-of-day/pc-29028-black-panther-printed-tshirt-color-grey-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Grey printed graphic t-shirt"
                      alt="Grey printed graphic t-shirt"/>
               </div>
              </a>
            </div>
          </div>
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/boys-navy-casual-printed-tshirt-73-navy/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/shirt-4-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/shirt-4-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/shirt-4-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/shirt-4-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Boys Navy Casual Printed Tshirt"
                      alt="Boys Navy Casual Printed Tshirt"/>
               </div>
              </a>
            </div>
          </div>
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/half-sleeves-cotton-shirt-256-blue/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/shirt-5-shirt-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/shirt-5-shirt-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/shirt-5-shirt-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/shirt-5-shirt-small.jpg') }} 326w"
                     data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                     title="Half Sleeves Cotton Shirt"
                     alt="Half Sleeves Cotton Shirt"/>
                </div>
              </a>
            </div>
          </div>          
        </div>
        <p class="trending-subtitle text-center text-sm-left">Boys</p>
      </div>
      <div class="col-sm-4 center-col mt-2 mt-sm-0 d-flex flex-column-reverse d-sm-block">
        <div class="row product-collection__wrapper">
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/a-line-marigold-embroidered-dress-982-turquoise/buy/">
                <div class="img-container">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-large.jpg') }} 810w,
                                   {{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/171081-a-line-marigold-embroidered-dress-color-turquoise-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="A-line Marigold Embroidered Dress"
                      alt="A-line Marigold Embroidered Dress"/>
               </div>
              </a>
            </div>
          </div>
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/denim-indigo-trouser-1329-dark-blue/buy/">
                <div class="img-container">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/girl-trouser-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/girl-trouser-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/girl-trouser-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/girl-trouser-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Denim Indigo Trouser"
                      alt="Denim Indigo Trouser"/>
               </div>
              </a>
            </div>
          </div>  
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/grey-circular-knit-graphic-girls-tshirt-1272-grey/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-medium.jpg') }} 537w,
                                   {{CDN::asset('/img/product-of-day/jl-ppg-3-side-girls-hd-hs-top-color-grey-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Grey circular knit graphic girls tshirt"
                      alt="Grey circular knit graphic girls tshirt"/>
                </div>
              </a>
            </div>
          </div>
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/chambray-hemla-dress-coral-972-coral/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-large.jpg') }} 810w,
                                   {{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/161025-chambray-hemla-dress-coral-color-coral-1-small.jpg') }} 326w"
                     data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                     title="Chambray Hemla Dress Coral"
                     alt="Chambray Hemla Dress Coral"/>
                </div>
              </a>
            </div>
          </div>                    
        </div>
        <p class="trending-subtitle text-center text-sm-left">Girls</p>
      </div>
      <div class="col-sm-4 mt-2 mt-sm-0 d-flex flex-column-reverse d-sm-block">
        <div class="row product-collection__wrapper">
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/half-sleeves-navy-cotton-tshirt-1034-navy/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/infant-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/infant-1-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/infant-1-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/infant-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Half Sleeves Navy Cotton Tshirt"
                      alt="Half Sleeves Navy Cotton Tshirt"/>
               </div>
              </a>
            </div>
          </div>  
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/blue-cotton-rompers-1071-navy/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/infant-3-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/infant-3-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/infant-3-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/infant-3-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Blue Cotton Rompers"
                      alt="Blue Cotton Rompers"/>
               </div>
              </a>
            </div>
          </div>
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/cobalt-casual-knit-short-1010-cobalt/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/infant-4-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/infant-4-large.jpg') }} 978w,
                                   {{CDN::asset('/img/product-of-day/infant-4-medium.jpg') }} 652w,
                                   {{CDN::asset('/img/product-of-day/infant-4-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Cobalt Casual Knit Short"
                      alt="Cobalt Casual Knit Short"/>
               </div>
              </a>
            </div>
          </div>      
          <div class="col-6 category-col">
            <div class="card h-100 product-card">
              <a href="/cotton-printed-girls-rompers-1061-white/buy/">
                <div class="img-container">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="{{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-10px.jpg') }}"
                      data-srcset="{{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-medium.jpg') }} 448w,
                                   {{CDN::asset('/img/product-of-day/new-born-3009-color-white-1-small.jpg') }} 326w"
                      data-sizes='(min-width: 1200px) 13vw, (min-width: 768px) 15vw, 50vw'
                      title="Cotton printed girls rompers"
                      alt="Cotton printed girls rompers"/>
               </div>
              </a>
            </div>
          </div>                  
        </div>
        <p class="trending-subtitle text-center text-sm-left">Infants</p>
      </div>
    </div>
  </div>
</section> -->


<!-- Advt section -->

<section>
  <div class="container mt-5">
      <div class="row add-info-row">
          <div class="col-md-6 mb-3 mb-sm-0">
             <div class=" d-flex align-items-center justify-content-between flex-column-reverse flex-sm-row border-0 text-left p-2 p-sm-4" style="background-color: #fbf5d5;">
              <div class="text-center text-sm-left pr-0 pr-sm-3">
                <h2 class="font-weight-bold mt-3">
                  Fresh and Latest
                </h2>
                <p class="text-muted mt-1 captions">
                  We always find the latest clothing and accessories for kids.
                </p>
              </div>
              <div class="bg-gift ml-auto home-coupon latest-trend"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-between flex-column-reverse flex-sm-row border-0 text-left p-2 p-sm-4" style="background-color: #f2e6de;">
              <div class="text-center text-sm-left pr-0 pr-sm-3">
                <h2 class="font-weight-bold mt-3">
                 Give your child something special
                </h2>
                <p class="text-muted mt-1 captions">
                  Shop from us for amazing deals all year around.
                </p>
              </div>
              <div class="bg-gift ml-auto home-coupon shipping-img"></div>
            </div>
          </div>
      </div>
  </div>
</section>

<section>
  <div class="container mt-5">
      <div class="row">
        <div class="col-sm-12">
          <div class="store-banner postion-relative">
            <img class="img-fluid"
              src="{{CDN::asset('/img/store-banner.jpg') }}"
              title="Store Banner"
              alt="Store Banner"/>            
            <div class="contentWrapper text-center">
              <p class="store-banner__title mb-0">Want to see our clothes in real life?</p>
              <span class="store-banner__caption">Just visit any one of stores near you!</span>
              <a href="#" class="btn kss-btn kss-btn--small">Visit our store</a>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>


@stop