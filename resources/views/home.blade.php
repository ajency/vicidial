@extends('layouts.default')

@section('headjs')

 <style type="text/css">
  :root{--blue:#007bff;--indigo:#6610f2;--purple:#6f42c1;--pink:#e83e8c;--red:#dc3545;--orange:#fd7e14;--yellow:#ffc107;--green:#28a745;--teal:#20c997;--cyan:#17a2b8;--white:#fff;--gray:#6c757d;--gray-dark:#343a40;--primary:#f9bc23;--secondary:#004283;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#ad110a;--light:#e4e4e4;--dark:#707279;--cancel:#4b4b4b;--breakpoint-xs:0;--breakpoint-sm:576px;--breakpoint-md:768px;--breakpoint-lg:992px;--breakpoint-xl:1200px;--font-family-sans-serif:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";--font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar}@-ms-viewport{width:device-width}nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:.85rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;font-family:'Open Sans',sans-serif}hr{margin-bottom:1rem}hr{box-sizing:content-box;height:0;overflow:visible;margin-top:1rem;border:0;border-top:1px solid rgba(0,0,0,.1)}h4,ol,ul{margin-top:0}ol,ul{margin-bottom:1rem}ul ul{margin-bottom:0}a{color:#f9bc23;background-color:transparent;-webkit-text-decoration-skip:objects;text-decoration:none!important}img{vertical-align:middle;border-style:none;opacity:1}label{display:inline-block;margin-bottom:.5rem;font-weight:600}input{margin:0}input{font-family:inherit;font-size:inherit;line-height:inherit}input{overflow:visible}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.h1,h4{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}.h1{font-size:2.125rem}h4{font-size:1.275rem}.list-inline{padding-left:0;list-style:none}.list-inline-item{display:inline-block}.list-inline-item:not(:last-child){margin-right:.5rem}.img-fluid{max-width:100%;height:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:1200px){.container{max-width:1200px}}.row{display:flex;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.card>hr{margin-right:0;margin-left:0}.col-6{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col-md-3{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col-6{flex:0 0 50%;max-width:50%}@media (min-width:768px){.col-md-3{flex:0 0 25%;max-width:25%}}.collapse:not(.show){display:none}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;padding:.5rem 1rem}.navbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{font-size:.9rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.25rem}.card>.list-group:last-child .list-group-item:last-child{border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.card-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,.03);border-bottom:1px solid rgba(0,0,0,.125)}.card-header:first-child{border-radius:calc(.25rem - 1px) calc(.25rem - 1px) 0 0}.card-header+.list-group .list-group-item:first-child{border-top:0}.badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem}.badge-light{color:#212529;background-color:#e4e4e4}.list-group{display:flex;flex-direction:column;padding-left:0;margin-bottom:0}.list-group-item{position:relative;display:block;padding:.75rem 1.25rem;margin-bottom:-1px;background-color:#fff;border:1px solid rgba(0,0,0,.125)}.list-group-item:first-child{border-top-left-radius:.25rem;border-top-right-radius:.25rem}.list-group-item:last-child{margin-bottom:0;border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.list-group-flush .list-group-item{border-right:0;border-left:0;border-radius:0}.list-group-flush:last-child .list-group-item:last-child{border-bottom:0}.carousel,.carousel-inner{position:relative}.carousel-inner{width:100%;overflow:hidden}.carousel-item{position:relative;display:none;align-items:center;width:100%;backface-visibility:hidden;perspective:1000px}.carousel-item.active{display:block}.carousel-indicators{position:absolute;right:0;bottom:10px;left:0;z-index:15;display:flex;justify-content:center;padding-left:0;margin-right:15%;margin-left:15%;list-style:none}.carousel-indicators li{position:relative;flex:0 1 auto;width:30px;height:3px;margin-right:3px;margin-left:3px;text-indent:-999px;background-color:rgba(255,255,255,.5)}.carousel-indicators li::after,.carousel-indicators li::before{position:absolute;left:0;display:inline-block;width:100%;height:10px;content:""}.carousel-indicators li::before{top:-10px}.carousel-indicators li::after{bottom:-10px}.carousel-indicators .active{background-color:#fff}.border-0{border:0!important}.border-dark{border-color:#707279!important}.d-none{display:none!important}.d-block{display:block!important}.w-25{width:25%!important}.w-100{width:100%!important}.h-100{height:100%!important}.m-0{margin:0!important}.mt-2,.my-2{margin-top:.5rem!important}.mb-2,.my-2{margin-bottom:.5rem!important}.mb-3{margin-bottom:1rem!important}.ml-4{margin-left:1.5rem!important}.mt-5{margin-top:3rem!important}.pt-0{padding-top:0!important}.pr-0{padding-right:0!important}.pb-0{padding-bottom:0!important}.pr-1{padding-right:.25rem!important}.pl-1{padding-left:.25rem!important}.pr-2{padding-right:.5rem!important}.pl-2{padding-left:.5rem!important}.p-3{padding:1rem!important}.pt-3{padding-top:1rem!important}.m-auto{margin:auto!important}.mr-auto{margin-right:auto!important}@media (min-width:576px){.pr-sm-0{padding-right:0!important}.pl-sm-0{padding-left:0!important}}@media (min-width:768px){.mb-md-0{margin-bottom:0!important}}@media (min-width:992px){.mt-lg-0,.my-lg-0{margin-top:0!important}.my-lg-0{margin-bottom:0!important}}.text-center{text-align:center!important}.font-weight-bold{font-weight:700!important}.text-white{color:#fff!important}@media (min-width:320px) and (max-width:767.98px){body{font-size:80%}}@media (max-width:575.98px){label{font-size:.8rem}}@media (min-width:320px) and (max-width:767.98px){label{font-size:.8rem!important}}.text-black{color:#000}.kss_icon{width:30px;height:33px;display:inline-block;margin-bottom:-4px}.kss_icon{background:url(../img/sprite.png) no-repeat}.search-icon{background-position:-6px -138px}.profile-icon{background-position:-107px -138px}.bag-icon{background-position:-501px -275px}.top-icon{background:url(../img/sprite.png) no-repeat;width:50px;height:50px;background-position:-223px -119px}.go-top{position:fixed;bottom:2em;right:2em;text-decoration:none;text-align:center;font-size:12px;display:none;padding:1em;z-index:1}@media (min-width:320px) and (max-width:767.98px){.go-top{bottom:5em;right:0;display:none!important}}.blur-up{-webkit-filter:blur(5px);filter:blur(5px)}label{font-size:.9rem}.overlay-fix{width:100%;height:100vh;background:rgba(0,0,0,.34);position:fixed;top:58px;z-index:99}@media (min-width:320px) and (max-width:767.98px){.overlay-fix{top:74px}}.recent-search{position:absolute;right:7%;top:58px;z-index:9999}@media (min-width:320px) and (max-width:767.98px){.recent-search{right:0;width:100%!important;top:140px}}.search-input{position:absolute;right:7%;top:8px;z-index:9999;background-color:#707279}@media (min-width:320px) and (max-width:767.98px){.search-input span{color:#000!important;position:absolute;bottom:0}}.search-input input{width:100%;height:40px;background:0;color:#fff;border:0;border-bottom:1px solid #cccc}@media (min-width:320px) and (max-width:767.98px){.search-input input{color:#000}}@media (min-width:320px) and (max-width:767.98px){.search-input{position:absolute;top:75px;height:54px;left:0;z-index:999;background:#fff;width:100%!important}.search-input input{width:90%;height:54px;padding-left:5px;outline:none}}.hide-search{position:absolute;right:5px;top:4px;z-index:2}.home-slider .home-slide-item{display:none}.home-slider .home-slide-item:first-child{display:block}@media (orientation:landscape){.home-slider{min-height:34vw}}@media (orientation:portrait){.home-slider{min-height:78vw}.home-slider .home-slide-item:first-child{visibility:hidden}}#slider-newarrival{margin-top:-5px}.header{background-color:#707279}.header a{color:#fff}.recent-search a{color:#000!important}.navbar-toggler{padding:.15rem .45rem}.cart-counter{position:absolute;top:30px;right:-2px}.hamburger-inner,.hamburger-inner::after,.hamburger-inner::before{width:22px;height:2px;background-color:#fff}.hamburger-inner::before{top:-7px}.hamburger--collapse .hamburger-inner::after{top:-14px}.hamburger-box{width:22px;height:18px}@media (min-width:360px) and (max-width:767.98px){.kss-logo{position:absolute;left:40px;top:24px}}@media (max-width:320px){.header ul .list-inline-item{margin-right:.1rem}.header img{width:144px;position:absolute;left:40px;top:26px}}#cd-cart{position:fixed;top:0;height:100%;width:80%;padding-top:10px;overflow-y:auto;overflow-x:hidden;-webkit-overflow-scrolling:touch;box-shadow:0 0 20px rgba(0,0,0,.2);z-index:9999}@media only screen and (min-width:768px){#cd-cart{width:400px}}@media (min-width:360px) and (max-width:767.98px){#cd-cart{width:100%;padding-bottom:68px}}@media (min-width:992px) and (min-width:1199.98px){#cd-cart{width:40%!important}}@media (min-width:1300px){#cd-cart{width:30%!important}}#cd-cart{right:-100%;background:#fff}#cd-cart>*{padding:0 1em}@media only screen and (min-width:1200px){#cd-cart>*{padding:0 1.5em}}#cd-shadow-layer{position:fixed;min-height:100%;width:100%;top:0;left:0;background:rgba(173,181,189,.6);z-index:99;display:none}@media (min-width:360px) and (max-width:767.98px){#cd-shadow-layer{display:none!important}}.cart-loader:after{content:'';position:absolute;width:100%;height:100%;top:0;left:0;background:rgba(255,255,255,.83) url(../img/loader_818e.gif) center center no-repeat;z-index:99999}.lazyload{opacity:1}
 </style>

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