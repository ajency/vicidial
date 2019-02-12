
@extends('layouts.default')


@php
  $delaycss = true;
@endphp

@section('headjs')
  @include('includes.abovethefold.homecss')
@stop

@section('content')

<!-- Banner  -->
@if (isset($static_elements['banner']))
  @include('includes.banner.slider', ['banners' => $static_elements['banner']])
@endif


<section class="mt-5">
  <div class="container mb-3">
      <div class="row">
          <div class="col-md-3 col-6 mb-md-0 mb-3">
            <a href="/shop/infants" class="card link-card border-0 text-center pt-3" style="background-color:#EEFAFC;">
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
            <a href="/shop/boys" class="card link-card border-0 text-center pt-3" style="background-color:#F3F3F1;">
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
            <a href="/shop/girls" class="card link-card border-0 text-center pt-3" style="background-color:#F4E6DC;">
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
                        src="{{CDN::asset('/img/new-arrival/kids-accessories-10px.jpg') }}"
                        data-srcset="{{CDN::asset('/img/new-arrival/kids-accessories-large.jpg') }} 813w,
                                     {{CDN::asset('/img/new-arrival/kids-accessories-medium.jpg') }} 542w,
                                     {{CDN::asset('/img/new-arrival/kids-accessories-small.jpg') }} 271w"
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


<!-- Theme of the week -->
@if (isset($static_elements['theme']))
  <section class="week-theme">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
              <h2 class="font-weight-bold mb-3">Theme of the week</h2>
            </div>
        </div>
    </div>
    @foreach($static_elements['theme'] as $theme)
      @include('includes.banner.slide', ['banner' => $theme, 'display_type' => 'Theme of the week', 'class' => 'position-relative'])
    @endforeach
  </section>
@endif


<!-- Home category -->
@if (isset($static_elements['category']))
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
      @include('includes.homecategory.home-category', ['categories' => $static_elements['category']])
    </div>
  </section>
@endif

<!-- Stories -->
@if (isset($static_elements['story']))
  <section class="section">
    <div class="container mt-5 ">
        <div class="row">
            <div class="col-md-12 text-center">
              <h2 class="font-weight-bold mb-3">Shop By Stories</h2>
              <!-- <p>Lorem ipsum dolor sit amet</p> -->
            </div>
        </div>
    </div>
  </section>
  <section>
    <div class="container">
      @include('includes.stories.stories', ['stories' => $static_elements['story']])
    </div>
  </section>
@endif


<!-- Product of the day -->
@if (isset($static_elements['trending']))
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
    @include('includes.trendinglooks.trending_looks', ['trending' => $static_elements['trending']])
    <div class="text-center mt-3">
      <a href="/shop" class="viewall-link">View More <i class="fas fa-chevron-right"></i></a>
    </div>
  </div>
</section>
@endif

<!-- Blogs section for site homepage -->
<section class="blog-section">
  <div class="container">
      <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="font-weight-bold mb-4 pb-2">Blogs</h2>
          </div>
      </div>
    <div class="blog-articles d-flex flex-column flex-lg-row">
      <!-- Recent articles -->
      <div class="blog-articles__recent order-1 order-lg-0">

        <?php echo do_shortcode( '[kss-recent-posts]' ); ?>

      </div>
      <!-- Featured articles -->
      <div class="blog-articles__featured order-0 order-lg-1">

        <div class="featured-section">
          <?php echo do_shortcode( '[kss-featured-posts]' ); ?>
        </div>

      </div>
    </div>
  </div>
</section>

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
                  Free shipping!
                </h2>
                <p class="text-muted mt-1 captions">
                  We provide free shipping on all our products. No minimum checkout value.
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
            <picture>
               <source media="(orientation: landscape)"
                      data-srcset="{{CDN::asset('/img/stores/banner/store-banner-large.jpg') }} 2000w,
                                  {{CDN::asset('/img/stores/banner/store-banner-medium.jpg') }} 1200w,
                                  {{CDN::asset('/img/stores/banner/store-banner-small.jpg') }} 700w"
                      sizes="100vw">

               <source media="(orientation: portrait)"
                      data-srcset="{{CDN::asset('/img/stores/banner/store-banner-mo-large.jpg') }} 1200w,
                                  {{CDN::asset('/img/stores/banner/store-banner-mo-medium.jpg') }} 700w,
                                  {{CDN::asset('/img/stores/banner/store-banner-mo-small.jpg') }} 400w"
                      sizes="100vw">

               <img src="{{CDN::asset('/img/stores/banner/store-banner-20px.jpg') }}"
                   data-sizes="100vw"
                   class="img-fluid lazyload blur-up w-100" alt="Visit our store" title="Visit our store">
            </picture>
            <div class="contentWrapper text-center d-flex align-items-center">
              <div>
                <p class="store-banner__title mb-0">Want to see our clothes in real life?</p>
                <span class="store-banner__caption">Just visit any one of stores near you!</span>
                <a href="/stores" class="btn kss-btn kss-btn--small">Visit our store</a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>


@stop

@section('footjs')
<!-- Google pixel tracking -->
<script type="text/javascript">
  gtag('event', 'page_view', {
    'send_to': google_pixel_id,
    'ecomm_pagetype': 'home',
    'ecomm_prodid': '',
    'ecomm_totalvalue': '',
    'user_id': getCookie('user_id')
  });

  $(function(){
    // Tooltip for chrome extension
      if($('.update-element-btn')){
        $(document).on('click',".update-element-btn",function(){
            setTimeout(function() {
                $('[data-toggle="tooltip"]').tooltip()
             }, 1800);
        });
      }
  })
</script>

@stop