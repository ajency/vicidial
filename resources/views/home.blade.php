@extends('layouts.default')

@php
  $delaycss = true;
@endphp

@section('headjs')
  @include('includes.abovethefold.homecss')
@stop

@section('content')
<div id="home-slider" class="home-slider">
<!--     <div class="home-slide-item">
      <a href="/stores/jaipur">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/hello-jaipur-large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/hello-jaipur-medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/hello-jaipur-small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/hello-jaipur-portrait-large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/hello-jaipur-portrait-medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/hello-jaipur-portrait-small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/hello-jaipur-20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Hello Jaipur - Your Kids's Favourite fashion destination is now coming to Jaipur!" title="Hello Jaipur - Your Kids's Favourite fashion destination is now coming to Jaipur!">
        </picture>
      </a>
    </div> -->
    <div class="home-slide-item">
      <a href="/shop?rf=price:0TO499">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/makar_sankranti_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/makar_sankranti_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/makar_sankranti_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/makar_sankranti_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/makar_sankranti_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/makar_sankranti_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/makar_sankranti_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Happy Makar Sankranti Flash Sale - Entire Store Under ₹499" title="Happy Makar Sankranti Flash Sale - Entire Store Under ₹499">
        </picture>
      </a>
    </div>
    <div class="home-slide-item">
      <a href="/shop?rf=price:0TO499">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/pongal_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/pongal_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/pongal_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/pongal_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/pongal_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/pongal_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/pongal_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Happy Pongal Flash Sale - Entire Store Under " title="Happy Pongal Flash Sale - Entire Store Under ₹499">
        </picture>
      </a>
    </div>
    <div class="home-slide-item">
      <a href="/shop?rf=price:0TO499">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/lohri_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/lohri_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/lohri_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/lohri_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/lohri_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/lohri_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/lohri_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Happy Lohri Flash Sale - Entire Store Under " title="Happy Lohri Flash Sale - Entire Store Under ₹499">
        </picture>
      </a>
    </div>
<!--     <div class="home-slide-item">
      <a href="/shop">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner1_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/banner1_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner1_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner1_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner1_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/banner1_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/banner1_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Upto 50% OFF" title="Upto 50% OFF">
        </picture>
      </a>
    </div> -->
<!--     <div class="home-slide-item">
      <a href="/shop">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner2_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/banner2_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner2_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner2_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner2_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/banner2_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/banner2_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Upto 50% OFF" title="Upto 50% OFF">
        </picture>
      </a>
    </div>  -->   
    <div class="home-slide-item">
      <a href="/shop">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner3_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/banner3_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner3_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner3_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner3_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/banner3_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/banner3_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up w-100" alt="Free Gifts On The Purchase Of ₹3000 And Above" title="Free Gifts On The Purchase Of ₹3000 And Above">
        </picture>
      </a>
    </div>
    <div class="home-slide-item">
      <a href="/shop">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner4_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/banner4_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner4_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner4_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner4_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/banner4_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/banner4_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up" alt="₹500 OFF On Your Next Purchase" title="₹500 OFF On Your Next Purchase">
        </picture>
      </a>
    </div>
    <div class="home-slide-item">
      <a href="/shop">
        <picture>
           <source media="(orientation: landscape)"
                  data-srcset="{{CDN::asset('/img/home-banner/banner5_jan_large.jpg') }} 2000w,
                              {{CDN::asset('/img/home-banner/banner5_jan_medium.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner5_jan_small.jpg') }} 700w"
                  sizes="100vw">

           <source media="(orientation: portrait)"
                 data-srcset="{{CDN::asset('/img/home-banner/banner5_jan_portrait_large.jpg') }} 1200w,
                              {{CDN::asset('/img/home-banner/banner5_jan_portrait_medium.jpg') }} 700w,
                              {{CDN::asset('/img/home-banner/banner5_jan_portrait_small.jpg') }} 400w"
                  sizes="100vw">

           <img src="{{CDN::asset('/img/home-banner/banner5_jan_20px.jpg') }}"
               data-sizes="100vw"
               class="img-fluid lazyload blur-up" alt="Chance To Win a Super Cycle Every Week" title="Chance To Win a Super Cycle Every Week">
        </picture>
      </a>
    </div>
</div>
<section class="mt-5">
  <div class="container mb-3">
      <div class="row">
          <div class="col-md-3 col-6 mb-md-0 mb-3">
            <a href="/infant-0-2-years/" class="card link-card border-0 text-center pt-3" style="background-color:#EEFAFC;">
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
            <a href="/boys/junior-7-14-years--toddler-2-7-years/" class="card link-card border-0 text-center pt-3" style="background-color:#F3F3F1;">
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
            <a href="/girls/junior-7-14-years--toddler-2-7-years/" class="card link-card border-0 text-center pt-3" style="background-color:#F4E6DC;">
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

<!-- Home category -->
<section>
  <div class="container">
    <div class="cat-container">
      <div class="cat-item cat-13">
        <a href="/shop?rf=price:0TO499">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/makar_sankranti_category_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/makar_sankranti_category_large.jpg') }} 740w,
                            {{CDN::asset('/img/home-category/makar_sankranti_category_medium.jpg') }} 370w,
                            {{CDN::asset('/img/home-category/makar_sankranti_category_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 570px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="Happy Makar Sankranti - Entire Store Under ₹499"
              title="Happy Makar Sankranti - Entire Store Under ₹499" />
        </a>
      </div>
      <div class="cat-item cat-14">
        <a href="/stationery">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid14_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid14_large.jpg') }} 740w,
                            {{CDN::asset('/img/home-category/category_grid14_medium.jpg') }} 370w,
                            {{CDN::asset('/img/home-category/category_grid14_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 570px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="Bag To School"
              title="Bag To School" />
        </a>
      </div>
      <div class="cat-item cat-1 position-relative">
        <a href="/girls/dress">
            <img class="d-block w-100 img-fluid lazyload blur-up"
                        src="{{CDN::asset('/img/home-category/category_grid1_10px.jpg') }}"
                        data-srcset="{{CDN::asset('/img/home-category/category_grid1_large.jpg') }} 818w,
                                      {{CDN::asset('/img/home-category/category_grid1_medium.jpg') }} 409w,
                                      {{CDN::asset('/img/home-category/category_grid1_small.jpg') }} 272w"
                        data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
                        alt="Dear dress with love"
                        title="Dear dress with love"/>
            <!-- <a href="/shop" class="shop-now-btn shop-now-btn--green">Shop Now</a> -->
          <p class="custom-text dress-text">Dear <strong>dress</strong>, with <strong class="text-primary">Love.</strong></p>
        </a>
      </div>
      <div class="cat-item cat-2 position-relative">
        <a href="/girls/tops--woven-tops">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid2_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid2_large.jpg') }} 740w,
                            {{CDN::asset('/img/home-category/category_grid2_medium.jpg') }} 370w,
                            {{CDN::asset('/img/home-category/category_grid2_small.jpg') }} 246w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="Woven tops"
              title="Woven tops"/>
          <!-- <a href="/shop" class="shop-now-btn shop-now-btn--orange">Shop Now</a> -->
        </a>
      </div>
      <div class="cat-item cat-3">
        <a href="/shop?rf=price:0TO299">
          <img class="img-fluid lazyload blur-up" src="{{CDN::asset('/img/home-category/category_grid3_jan_10px.jpg') }}"
          data-srcset="{{CDN::asset('/img/home-category/category_grid3_jan_large.gif') }}" alt="Shop under ₹299" title="Shop under ₹299" />
          <!-- <div class="shop-under-box d-flex align-items-center justify-content-center">
            <p class="m-0 shop-under-box__text text-uppercase">Shop Under</p>
          </div> -->
        </a>
      </div>
      <div class="cat-item cat-4 position-relative">
        <a href="/toys">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid4_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid4_large.jpg') }} 818w,
                            {{CDN::asset('/img/home-category/category_grid4_medium.jpg') }} 409w,
                            {{CDN::asset('/img/home-category/category_grid4_small.jpg') }} 271w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="The Super Toy Store"
              title="The Super Toy Store"/>

          <!-- <p class="custom-text ethnic-text text-uppercase font-weight-bold">Ethnic</p> -->
          <!-- <a href="/shop" class="shop-now-btn shop-now-btn--red">Shop Now</a> -->
        </a>
      </div>
      <div class="cat-item cat-5 position-relative">
        <a href="/jeans">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid5_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid5_large.jpg') }} 818w,
                            {{CDN::asset('/img/home-category/category_grid5_medium.jpg') }} 409w,
                            {{CDN::asset('/img/home-category/category_grid5_small.jpg') }} 271w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="The Daily Denim"
              title="The Daily Denim"/>
          <!-- <p class="m-0 custom-text denim-text">Denim<strong>search!</strong></p> -->
        </a>
      </div>
      <div class="cat-item cat-6 position-relative">
        <a href="/short" class="d-block">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid6_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid6_large.jpg') }} 818w,
                            {{CDN::asset('/img/home-category/category_grid6_medium.jpg') }} 409w,
                            {{CDN::asset('/img/home-category/category_grid6_small.jpg') }} 271w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt=""
              title=""/>
          <p class="custom-text text-bottoms text-uppercase"><strong>Playful</strong> Bottoms</p>
        </a>
        <div class="links-wrapper">
          <a href="/short" class="links-wrapper__first"></a>
          <a href="/short" class="links-wrapper__second"></a>
          <a href="/short" class="links-wrapper__third"></a>
          <a href="/short" class="links-wrapper__fourth"></a>
          <a href="/short" class="links-wrapper__shop">Shop Now</a>
        </div>
      </div>
      <div class="cat-item cat-7 position-relative">
        <a href="/accessories/girls">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid7_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid7_large.jpg') }} 740w,
                            {{CDN::asset('/img/home-category/category_grid7_medium.jpg') }} 370w,
                            {{CDN::asset('/img/home-category/category_grid7_small.jpg') }} 246w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vww'
              alt="Her Jewellery"
              title="Her Jewellery"/>

          <!-- <a href="/shop" class="shop-now-btn shop-now-btn--jewelery">Shop Now</a> -->
        </a>
      </div>
      <div class="cat-item cat-8 position-relative">
        <a href="/infant-utility">
         <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid8_jan_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid8_jan_large.jpg') }} 740w,
                            {{CDN::asset('/img/home-category/category_grid8_jan_medium.jpg') }} 370w,
                            {{CDN::asset('/img/home-category/category_grid8_jan_small.jpg') }} 246w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="Her Cute Accessory Shop"
              title="Her Cute Accessory Shop"/>
          <!-- <p class="custom-text text-acc text-uppercase">The cute <strong>accessory</strong> shop</p> -->
        </a>
      </div>
      <div class="cat-item cat-9 position-relative">
        <a href="/infant-0-2-years">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid9_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid9_large.jpg') }} 740w,
                            {{CDN::asset('/img/home-category/category_grid9_medium.jpg') }} 370w,
                            {{CDN::asset('/img/home-category/category_grid9_small.jpg') }} 246w"
              data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="First Wardrobe"
              title="First Wardrobe" />
          <p class="custom-text text-wardrobe text-uppercase">Their <strong>first wardrobe</strong></p>
        </a>
      </div>
      <div class="cat-item cat-10 position-relative">
        <a href="/shoes">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid10_jan_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid10_jan_large.jpg') }} 1535w,
                            {{CDN::asset('/img/home-category/category_grid10_jan_medium.jpg') }} 767w,
                            {{CDN::asset('/img/home-category/category_grid10_jan_small.jpg') }} 511w"
              data-sizes='(min-width: 1200px) 770px, (max-width: 992px) 92vw, 96vw'
              alt="Shoes"
              title="Shoes" />
          <!-- <a href="/shop" class="shop-now-btn shop-now-btn--shoes">Shop Now</a> -->
        </a>
      </div>
      <div class="cat-item cat-11">
        <a href="/tshirt">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid11_10px.gif') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid11_large.gif') }}"
              alt="T-shirts and Polos"
              title="T-shirts and Polos" />
        </a>
      </div>
      <div class="cat-item cat-12">
        <a href="/shirt">
          <img class="d-block w-100 img-fluid lazyload blur-up"
              src="{{CDN::asset('/img/home-category/category_grid12_jan_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/home-category/category_grid12_jan_large.jpg') }} 570w,
                            {{CDN::asset('/img/home-category/category_grid12_jan_medium.jpg') }} 284w,
                            {{CDN::asset('/img/home-category/category_grid12_jan_small.jpg') }} 190w"
              data-sizes='(min-width: 1200px) 570px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
              alt="His Favourite Shirts"
              title="His Favourite Shirts" />
        </a>
      </div>
    </div>
</div>
</section>


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

<!-- Stories -->

<section>
  <div class="container stories-wrapper">
    <div class="trend-focus-wrapper mb-4 mb-sm-0">
      <a href="/shop?pf=tag:lines-blocks" class="trend-box d-block link-card">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid9_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid9_large.jpg') }} 740w,
                           {{CDN::asset('/img/stories/story_grid9_medium.jpg') }} 370w,
                           {{CDN::asset('/img/stories/story_grid9_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Lines &amp; Blocks"
              title="Lines &amp; Blocks"/>
      </a>
      <a href="/shop?pf=tag:chubby-cheeks" class="trend-box d-block link-card">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid10_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid10_large.jpg') }} 740w,
                           {{CDN::asset('/img/stories/story_grid10_medium.jpg') }} 370w,
                           {{CDN::asset('/img/stories/story_grid10_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Chubby Cheeks"
              title="Chubby Cheeks"/>
      </a>
      <a href="/shop?pf=tag:rock-them-up" class="trend-box d-block link-card rock-them">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid11_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid11_large.jpg') }} 740w,
                           {{CDN::asset('/img/stories/story_grid11_medium.jpg') }} 370w,
                           {{CDN::asset('/img/stories/story_grid11_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Rock Them Up"
              title="Rock Them Up"/>
      </a>
    </div>
    <div class="trend-focus-wrapper">
        <!-- Grid-1 -->
        <a href="/shop?pf=tag:cute-florals" class="trend-box d-block link-card position-relative" style="order:0;">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid1_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid1_large.jpg') }} 818w,
                           {{CDN::asset('/img/stories/story_grid1_medium.jpg') }} 409w,
                           {{CDN::asset('/img/stories/story_grid1_small.jpg') }} 272w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Cute Floral"
              title="Cute Floral"/>
          <p class="custom-text floral-text text-uppercase">Cute <strong>Florals</strong></p>
        </a>
        
        <!-- Grid-4 -->
        <a href="/shop?pf=tag:see-spot-run" class="trend-box d-block link-card position-relative"  style="order:4;">

          <img class="img-fluid lazyload blur-up" src="{{CDN::asset('/img/stories/story_grid4_10px.gif') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid4_large.gif') }}" alt="See spot run" title="See spot run" />
            <p class="custom-text spot-text text-uppercase">See <strong>Spot</strong> Run</p>
        </a>
    
        <!-- Grid-2 -->
        <a href="/shop?pf=tag:baby-mornings" class="trend-box d-block link-card tab-append" style="order:1;">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid2_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid2_large.jpg') }} 740w,
                           {{CDN::asset('/img/stories/story_grid2_medium.jpg') }} 370w,
                           {{CDN::asset('/img/stories/story_grid2_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Baby Mornings"
              title="Baby Mornings"/>
        </a>

        <!-- Grid-5 -->
        <a href="/shop?pf=tag:teenage-drama" class="trend-box d-block link-card position-relative" style="order:5;">
         <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid5_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid5_large.jpg') }} 818w,
                           {{CDN::asset('/img/stories/story_grid5_medium.jpg') }} 409w,
                           {{CDN::asset('/img/stories/story_grid5_small.jpg') }} 272w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Teenage Drama"
              title="Teenage Drama"/>
              <p class="custom-text teenage-text text-uppercase">Teenage <strong>Drama</strong></p>
        </a>

        <!-- Grid-3 -->
        <a href="/shop?pf=tag:ice-cream" class="trend-box d-block link-card" style="order:3;">
         <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid3_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid3_large.jpg') }} 818w,
                           {{CDN::asset('/img/stories/story_grid3_medium.jpg') }} 409w,
                           {{CDN::asset('/img/stories/story_grid3_small.jpg') }} 272w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="T-shirts and Tops"
              title="T-shirts and Tops"/>
        </a>
        
        <!-- Grid-6 -->
        <a href="/shop?pf=tag:party-shoes" class="trend-box d-block link-card position-relative party-shoes" style="order:6;">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid6_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid6_large.jpg') }} 740w,
                           {{CDN::asset('/img/stories/story_grid6_medium.jpg') }} 370w,
                           {{CDN::asset('/img/stories/story_grid6_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 376px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Party shoes"
              title="Party shoes"/>
              <p class="custom-text party-text text-uppercase">Party <strong>Shoes</strong></p>
        </a>
    </div>
     <div class="d-flex align-items-end stories-bottom-row">
         <a href="/shop?pf=tag:how-i-wonder-what-you-are" class="trend-box d-block link-card col-8 left-col">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
            src="{{CDN::asset('/img/stories/story_grid7_10px.jpg') }}"
            data-srcset="{{CDN::asset('/img/stories/story_grid7_large.jpg') }} 1553w,
                         {{CDN::asset('/img/stories/story_grid7_medium.jpg') }} 778w,
                         {{CDN::asset('/img/stories/story_grid7_small.jpg') }} 521w"
            data-sizes='(min-width: 1200px) 780px, (max-width: 992px) 90vw, 63vw'
            alt="How I Wounder What You Are"
            title="How I Wounder What You Are"/>
        </a>
        <a href="/shop?pf=tag:comfy-underwear" class="trend-box d-block link-card col-4 right-col position-relative">
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
              src="{{CDN::asset('/img/stories/story_grid8_10px.jpg') }}"
              data-srcset="{{CDN::asset('/img/stories/story_grid8_large.jpg') }} 740w,
                           {{CDN::asset('/img/stories/story_grid8_medium.jpg') }} 370w,
                           {{CDN::asset('/img/stories/story_grid8_small.jpg') }} 248w"
              data-sizes='(min-width: 1200px) 390px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 90vw,  30vw'
              alt="Comfy Underwear"
              title="Comfy Underwear"/>
          <p class="custom-text comfy-text text-uppercase">Comfy <strong>Underwears</strong></p>
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
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                  src="{{CDN::asset('/img/product-of-day/infant-2-10px.jpg') }}"
                  data-srcset="{{CDN::asset('/img/product-of-day/infant-2-large.jpg') }} 978w,
                               {{CDN::asset('/img/product-of-day/infant-2-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/infant-2-small.jpg') }} 326w"
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                      data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                      data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                      data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                     data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                    data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                   data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                    src="{{CDN::asset('/img/product-of-day/infant-3-10px.jpg') }}"
                    data-srcset="{{CDN::asset('/img/product-of-day/infant-3-large.jpg') }} 978w,
                               {{CDN::asset('/img/product-of-day/infant-3-medium.jpg') }} 652w,
                               {{CDN::asset('/img/product-of-day/infant-3-small.jpg') }} 326w"
                    data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
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
                    data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                    title="Casual indigo shorts"
                    alt="Casual indigo shorts"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹699</div>
          </div>
        </div>
    </div>
    <div class="text-center mt-3">
      <a href="/shop" class="viewall-link">View More <i class="fas fa-chevron-right"></i></a>
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