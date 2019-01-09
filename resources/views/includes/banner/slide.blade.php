<!-- Individual slides goes here -->

<div class="home-slide-item">
  <a href="/shop">
    <!-- Picture tag to provide separate set of images as per query -->
    <picture>
      <!-- Landscape source -->
       <source media="(orientation: landscape)"
              data-srcset="{{CDN::asset('/img/home-banner/banner1_jan_large.jpg') }} 2000w,
                          {{CDN::asset('/img/home-banner/banner1_jan_medium.jpg') }} 1200w,
                          {{CDN::asset('/img/home-banner/banner1_jan_small.jpg') }} 700w"
              sizes="100vw">
      <!-- Portrait source -->
       <source media="(orientation: portrait)"
              data-srcset="{{CDN::asset('/img/home-banner/banner1_jan_portrait_large.jpg') }} 1200w,
                          {{CDN::asset('/img/home-banner/banner1_jan_portrait_medium.jpg') }} 700w,
                          {{CDN::asset('/img/home-banner/banner1_jan_portrait_small.jpg') }} 400w"
              sizes="100vw">
      <!-- Picture Source get pass to image source(src) with 20px image -->
       <img src="{{CDN::asset('/img/home-banner/banner1_jan_20px.jpg') }}"
           data-sizes="100vw"
           class="img-fluid lazyload blur-up w-100" alt="Shop And Get Four Super Offers" title="Shop And Get Four Super Offers">
    </picture>
  </a>
</div>

<div class="home-slide-item">
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
</div>  

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