
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
          <a href="/knit-striped-printed-dress-998-navy/buy">
            <div class="">
             <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="/images/products/33394/list-view/load/knit-dress-3045-color-navy-1.jpg"
                  data-srcset="/images/products/33394/list-view/1x/knit-dress-3045-color-navy-1.jpg 270w, /images/products/33394/list-view/2x/knit-dress-3045-color-navy-1.jpg 540w, /images/products/33394/list-view/3x/knit-dress-3045-color-navy-1.jpg 810w"
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                  title="Knit Striped Printed dress  - Navy"
                  alt="Knit Striped Printed dress  - Navy"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹175</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/white-regular-a-line-dress-410-white/buy">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="/images/products/30329/list-view/load/knit-dresses-1509-color-white-1.jpg"
                  data-srcset="/images/products/30329/list-view/1x/knit-dresses-1509-color-white-1.jpg 270w, /images/products/30329/list-view/2x/knit-dresses-1509-color-white-1.jpg 540w, /images/products/30329/list-view/3x/knit-dresses-1509-color-white-1.jpg 810w"
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                  title="White regular A-line dress - White"
                  alt="White regular A-line dress - White"/>
            </div>
          </a>
          <div class="kss-price kss-price--medium">₹239</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/woven-cotton-dress-301-turquoise/buy">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="/images/products/33613/list-view/load/dresses-1706-color-turquoise-1.jpg"
                  data-srcset="/images/products/33613/list-view/1x/dresses-1706-color-turquoise-1.jpg 270w, /images/products/33613/list-view/2x/dresses-1706-color-turquoise-1.jpg 540w, /images/products/33613/list-view/3x/dresses-1706-color-turquoise-1.jpg 810w"
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                  title="Woven cotton dress - Turquoise"
                  alt="Woven cotton dress - Turquoise"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹399</div>
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
          <a href="/sleeveless-tie-dye-jumpsuit-2137-lime/buy">
            <div class="">
              <img class="d-block w-100 img-fluid lazyload blur-up"
                  src="/images/products/32895/list-view/load/ssgi180902-ay-3008-sleeveless-tie-dye-jumpsuit-color-lime-3.jpg"
                  data-srcset="/images/products/32895/list-view/1x/ssgi180902-ay-3008-sleeveless-tie-dye-jumpsuit-color-lime-3.jpg 270w, /images/products/32895/list-view/2x/ssgi180902-ay-3008-sleeveless-tie-dye-jumpsuit-color-lime-3.jpg 540w, /images/products/32895/list-view/3x/ssgi180902-ay-3008-sleeveless-tie-dye-jumpsuit-color-lime-3.jpg 810w"
                  data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                  title="Sleeveless Tie &amp; dye Jumpsuit - Lime"
                  alt="Sleeveless Tie &amp; dye Jumpsuit - Lime"/>
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹499</div>
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
              <a href="/regular-denim-jeans-211-mid-wash/buy">
                <div class="">
                 <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="/images/products/30044/list-view/load/boys-jeans-1563-color-mid-wash-1.jpg"
                      data-srcset="/images/products/30044/list-view/1x/boys-jeans-1563-color-mid-wash-1.jpg 270w, /images/products/30044/list-view/2x/boys-jeans-1563-color-mid-wash-1.jpg 540w, /images/products/30044/list-view/3x/boys-jeans-1563-color-mid-wash-1.jpg 810w"
                      data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                      title="Regular denim jeans - Mid Wash"
                      alt="Regular denim jeans - Mid Wash" 
                      style="padding: 8px;" />
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹599</div>
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
              <a href="/applique-cotton-boys-tshirt-1304-black/buy">
                <div class="">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="/images/products/33028/list-view/load/mtc-3714a-occ-player-applique-hs-boys-tshirt-color-black-4.jpg"
                      data-srcset="/images/products/33028/list-view/1x/mtc-3714a-occ-player-applique-hs-boys-tshirt-color-black-4.jpg 270w, /images/products/33028/list-view/2x/mtc-3714a-occ-player-applique-hs-boys-tshirt-color-black-4.jpg 540w, /images/products/33028/list-view/3x/mtc-3714a-occ-player-applique-hs-boys-tshirt-color-black-4.jpg 810w"
                      data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                      title="Applique cotton boys tshirt - Black"
                      alt="Applique cotton boys tshirt - Black"/>
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹319</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative">
              <a href="/full-sleeves-checkered-shirt-2000-red/buy">
                <div class="">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="/images/products/10321/list-view/load/upbj180902-ca-1009-color-red-1.jpg"
                      data-srcset="/images/products/10321/list-view/1x/upbj180902-ca-1009-color-red-1.jpg 270w, /images/products/10321/list-view/2x/upbj180902-ca-1009-color-red-1.jpg 540w, /images/products/10321/list-view/3x/upbj180902-ca-1009-color-red-1.jpg 810w"
                      data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                      title="Full Sleeves Checkered Shirt - Red"
                      alt="Full Sleeves Checkered Shirt - Red"/>
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹599</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative">
              <a href="/turquoise-casual-printed-tshirt-1526-turquoise/buy">
                <div class="">
                  <img class="d-block w-100 img-fluid lazyload blur-up"
                      src="/images/products/31927/list-view/load/jus-jc69tb047-t-shirt-color-turquoise-1.jpg"
                      data-srcset="/images/products/31927/list-view/1x/jus-jc69tb047-t-shirt-color-turquoise-1.jpg 270w, /images/products/31927/list-view/2x/jus-jc69tb047-t-shirt-color-turquoise-1.jpg 540w, /images/products/31927/list-view/3x/jus-jc69tb047-t-shirt-color-turquoise-1.jpg 810w"
                     data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                     title="Turquoise casual printed tshirt - Turquoise"
                     alt="Turquoise casual printed tshirt - Turquoise"/>
                </div>
              </a>
              <div class="kss-price kss-price--medium">₹257</div>
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
            <a href="/casual-girl-denim-shorts-310-mid-wash/buy">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="/images/products/30253/list-view/load/girl-shorts1020-color-mid-wash-1.jpg"
                    data-srcset="/images/products/30253/list-view/1x/girl-shorts1020-color-mid-wash-1.jpg 270w, /images/products/30253/list-view/2x/girl-shorts1020-color-mid-wash-1.jpg 540w, /images/products/30253/list-view/3x/girl-shorts1020-color-mid-wash-1.jpg 810w"
                    data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                    title="Casual girl denim shorts - Mid Wash"
                    alt="Casual girl denim shorts - Mid Wash"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹400</div>
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
            <a href="/full-elasticated-all-over-printed-woven-short-2055-aqua/buy">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="/images/products/32403/list-view/load/upgt180901-an-7021-full-elasticated-all-over-printed-woven-short-color-aqua-1.jpg"
                    data-srcset="/images/products/32403/list-view/1x/upgt180901-an-7021-full-elasticated-all-over-printed-woven-short-color-aqua-1.jpg 270w, /images/products/32403/list-view/2x/upgt180901-an-7021-full-elasticated-all-over-printed-woven-short-color-aqua-1.jpg 540w, /images/products/32403/list-view/3x/upgt180901-an-7021-full-elasticated-all-over-printed-woven-short-color-aqua-1.jpg 810w"
                   data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                   title="Full Elasticated All over Printed Woven Short - Aqua"
                   alt="Full Elasticated All over Printed Woven Short - Aqua"/>
              </div>
            </a>
            <div class="kss-price kss-price--medium">₹399</div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/black-full-elasticated-net-and-georgette-pallazo-2296-black/buy">
              <div class="">
                <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="/images/products/13098/list-view/load/upgt180901-an-7084-color-black-1.jpg"
                    data-srcset="/images/products/13098/list-view/1x/upgt180901-an-7084-color-black-1.jpg 270w, /images/products/13098/list-view/2x/upgt180901-an-7084-color-black-1.jpg 540w, /images/products/13098/list-view/3x/upgt180901-an-7084-color-black-1.jpg 810w"
                    data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                    title="Black Full Elasticated Net and Georgette Pallazo - Black"
                    alt="Black Full Elasticated Net and Georgette Pallazo - Black"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹499</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/girls-blue-ethnic-western-wear-2228-dark-blue/buy">
              <div class="">
               <img class="d-block w-100 img-fluid lazyload blur-up"
                    src="/images/products/10555/list-view/load/upgt181001-sb-1904-color-dark-blue-1.jpg"
                    data-srcset="/images/products/10555/list-view/1x/upgt181001-sb-1904-color-dark-blue-1.jpg 270w, /images/products/10555/list-view/2x/upgt181001-sb-1904-color-dark-blue-1.jpg 540w, /images/products/10555/list-view/3x/upgt181001-sb-1904-color-dark-blue-1.jpg 810w"
                    data-sizes='(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw'
                    title="Girls Blue Ethnic western wear - Dark Blue"
                    alt="Girls Blue Ethnic western wear - Dark Blue"/>
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹1400</div>
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