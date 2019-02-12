
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
    <!-- 1st grid -->
    <div id="card-list" class="overflow-m row productGrid">
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/cap-sleeve-all-over-printed-a-line-dress-1963-pink/buy">
            <div class="">
                <img 
                  src="/images/products/36267/list-view/load/ssgi180901-an-7005-cap-sleeve-all-over-printed-multi-layered-dress-color-pink-1.jpg" 
                  data-srcset="/images/products/36267/list-view/1x/ssgi180901-an-7005-cap-sleeve-all-over-printed-multi-layered-dress-color-pink-1.jpg 270w, /images/products/36267/list-view/2x/ssgi180901-an-7005-cap-sleeve-all-over-printed-multi-layered-dress-color-pink-1.jpg 540w, /images/products/36267/list-view/3x/ssgi180901-an-7005-cap-sleeve-all-over-printed-multi-layered-dress-color-pink-1.jpg 810w" 
                  data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                  class="card-img-top blur-up lazyload" 
                  title="Cap Sleeve All over Printed A-Line dress - Pink" 
                  alt="Cap Sleeve All over Printed A-Line dress - Pink">
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹399</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/pink-full-sleeves-all-over-printed-multi-layered-dress-1919-pink/buy">
            <div class="">
                <img src="/images/products/36183/list-view/load/ssgi180902-pr-5043-color-pink-1.jpg"
                data-srcset="/images/products/36183/list-view/1x/ssgi180902-pr-5043-color-pink-1.jpg 270w, /images/products/36183/list-view/2x/ssgi180902-pr-5043-color-pink-1.jpg 540w, /images/products/36183/list-view/3x/ssgi180902-pr-5043-color-pink-1.jpg 810w" 
                data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                class="card-img-top blur-up lazyload" 
                title="Pink Full Sleeves All over Printed Multi-layered dress - pink" 
                alt="Pink Full Sleeves All over Printed Multi-layered dress - pink">
            </div>
          </a>
          <div class="kss-price kss-price--medium">₹399</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/full-sleeves-solid-fashion-tshirt-1927-pink/buy">
            <div class="">
                <img src="/images/products/36204/list-view/load/ssgi180902-pr-5050-color-pink-1.jpg" 
                data-srcset="/images/products/36204/list-view/1x/ssgi180902-pr-5050-color-pink-1.jpg 270w, /images/products/36204/list-view/2x/ssgi180902-pr-5050-color-pink-1.jpg 540w, /images/products/36204/list-view/3x/ssgi180902-pr-5050-color-pink-1.jpg 810w" 
                data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw" 
                class="card-img-top blur-up lazyload" 
                title="Full Sleeves Solid Fashion Tshirt - pink" 
                alt="Full Sleeves Solid Fashion Tshirt - pink">
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹349</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <div class="card h-100 product-card position-relative">
          <a href="/half-sleeves-striper-polo-tshirt-1914-multi/buy">
            <div class="">
                <img src="/images/products/41089/list-view/load/ssbi180902-pr-5030-color-multi-1.jpg" 
                data-srcset="/images/products/41089/list-view/1x/ssbi180902-pr-5030-color-multi-1.jpg 270w, /images/products/41089/list-view/2x/ssbi180902-pr-5030-color-multi-1.jpg 540w, /images/products/41089/list-view/3x/ssbi180902-pr-5030-color-multi-1.jpg 810w" 
                data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                class="card-img-top blur-up lazyload" 
                title="Half Sleeves Striper Polo Tshirt - Multi" 
                alt="Half Sleeves Striper Polo Tshirt - Multi">
           </div>
          </a>
          <div class="kss-price kss-price--medium">₹349</div>
        </div>
      </div>
    </div>

    <!-- 2nd Grid -->
    <div id="card-list" class="overflow-m row productGrid mt-2">
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative position-relative">
              <a href="/tropical-a-line-dress-with-bow-427-peach/buy">
                <div class="">
                  <img src="/images/products/40801/list-view/load/girl-dress-1503-color-peach-1.jpg" 
                  data-srcset="/images/products/40801/list-view/1x/girl-dress-1503-color-peach-1.jpg 270w, /images/products/40801/list-view/2x/girl-dress-1503-color-peach-1.jpg 540w, /images/products/40801/list-view/3x/girl-dress-1503-color-peach-1.jpg 810w" 
                  data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw" 
                  class="card-img-top blur-up lazyload" 
                  title="Tropical A-line dress with bow - Peach" 
                  alt="Tropical A-line dress with bow - Peach">
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹239</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative position-relative">
              <a href="/full-elasticated-mid-wash-jeans-2262-mid-wash/buy">
                <div class="">
                      <img src="/images/products/36748/list-view/load/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg" 
                      data-srcset="/images/products/36748/list-view/1x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 270w, /images/products/36748/list-view/2x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 540w, /images/products/36748/list-view/3x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 810w" 
                      data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw" 
                      class="card-img-top blur-up lazyload" 
                      title="Full Elasticated Mid Wash Jeans - Mid Wash" 
                      alt="Full Elasticated Mid Wash Jeans - Mid Wash" style="padding-bottom:8px;">
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹499</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative">
              <a href="/half-sleeves-all-over-printed-t-shirt-2063-white/buy">
                <div class="">
                    <img src="/images/products/36477/list-view/load/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg" 
                    data-srcset="/images/products/36477/list-view/1x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 270w, /images/products/36477/list-view/2x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 540w, /images/products/36477/list-view/3x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 810w" 
                    data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                    class="card-img-top blur-up lazyload" 
                    title="Half Sleeves All over Printed T-Shirt - White" 
                    alt="Half Sleeves All over Printed T-Shirt - White">
               </div>
              </a>
              <div class="kss-price kss-price--medium">₹249</div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <div class="card h-100 product-card position-relative">
              <a href="/knit-georgette-blouse-top-2302-red/buy">
                <div class="">
                    <img src="/images/products/36796/list-view/load/upgj180901-an-7087-color-red-1.jpg" 
                    data-srcset="/images/products/36796/list-view/1x/upgj180901-an-7087-color-red-1.jpg 270w, /images/products/36796/list-view/2x/upgj180901-an-7087-color-red-1.jpg 540w, /images/products/36796/list-view/3x/upgj180901-an-7087-color-red-1.jpg 810w" 
                    data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                    class="card-img-top blur-up lazyload" 
                    title=" knit georgette Blouse Top - Red" 
                    alt=" knit georgette Blouse Top - Red">
                </div>
              </a>
              <div class="kss-price kss-price--medium">₹359</div>
            </div>
          </div>
    </div>

    <!-- 3rd Grid -->
    <div id="card-list" class="overflow-m row productGrid mt-2">
        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative position-relative">
            <a href="/denim-camouflage-printed-shorts-1785-mid-wash/buy">
              <div class="">
                  <img src="/images/products/35935/list-view/load/upbt180901-ca-1021-color-mid-wash-1.jpg" 
                  data-srcset="/images/products/35935/list-view/1x/upbt180901-ca-1021-color-mid-wash-1.jpg 270w, /images/products/35935/list-view/2x/upbt180901-ca-1021-color-mid-wash-1.jpg 540w, /images/products/35935/list-view/3x/upbt180901-ca-1021-color-mid-wash-1.jpg 810w" 
                  data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                  class="card-img-top blur-up lazyload" 
                  title="Denim Camouflage Printed Shorts - Mid Wash" 
                  alt="Denim Camouflage Printed Shorts - Mid Wash">
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹359</div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/half-sleeve-stripper-henley-t-shirt-2326-white/buy">
              <div class="">
                  <img src="/images/products/36828/list-view/load/upbj18112-ug-2102-half-sleeve-striper-hooded-tshirt-color-white-10.jpg" 
                  data-srcset="/images/products/36828/list-view/1x/upbj18112-ug-2102-half-sleeve-striper-hooded-tshirt-color-white-10.jpg 270w, /images/products/36828/list-view/2x/upbj18112-ug-2102-half-sleeve-striper-hooded-tshirt-color-white-10.jpg 540w, /images/products/36828/list-view/3x/upbj18112-ug-2102-half-sleeve-striper-hooded-tshirt-color-white-10.jpg 810w" 
                  data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw" 
                  class="card-img-top blur-up lazyload" 
                  title="Half sleeve Stripper Henley T-Shirt - White" 
                  alt="Half sleeve Stripper Henley T-Shirt - White">
              </div>
            </a>
            <div class="kss-price kss-price--medium">₹399</div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/fixed-waist-with-adjustable-elastic-dark-wash-jeans-2128-dark-wash/buy">
              <div class="">
                  <img src="/images/products/36736/list-view/load/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg" 
                  data-srcset="/images/products/36736/list-view/1x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 270w, /images/products/36736/list-view/2x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 540w, /images/products/36736/list-view/3x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 810w" 
                  data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw" 
                  class="card-img-top blur-up lazyload" 
                  title="Fixed waist with adjustable elastic Dark Wash Jeans - Mid Wash" 
                  alt="Fixed waist with adjustable elastic Dark Wash Jeans - Mid Wash" style="padding-bottom:8px;">
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹499</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6">
          <div class="card h-100 product-card position-relative">
            <a href="/half-sleeves-tropical-shirt-461-navy/buy">
              <div class="">
                <img src="/images/products/37840/list-view/load/boys-shirt-2003-color-navy-7.jpg" 
                data-srcset="/images/products/37840/list-view/1x/boys-shirt-2003-color-navy-7.jpg 270w, /images/products/37840/list-view/2x/boys-shirt-2003-color-navy-7.jpg 540w, /images/products/37840/list-view/3x/boys-shirt-2003-color-navy-7.jpg 810w" 
                data-sizes="(min-width: 1200px) 266px, (min-width: 991px) 22vw, 41vw"
                class="card-img-top blur-up lazyload" 
                title="Half sleeves tropical shirt  - Navy" 
                alt="Half sleeves tropical shirt  - Navy">
             </div>
            </a>
            <div class="kss-price kss-price--medium">₹479</div>
          </div>
        </div>
    </div>
    <div class="text-center mt-3">
      <a href="/shop" class="viewall-link">View More <i class="fas fa-chevron-right"></i></a>
    </div>
  </div>
</section>


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