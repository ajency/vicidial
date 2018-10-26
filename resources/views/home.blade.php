@extends('layouts.default')

@section('content')
 <div id="home-slider" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#home-slider" data-slide-to="0" class="active"></li>
    <li data-target="#home-slider" data-slide-to="1"></li>
    <li data-target="#home-slider" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div  class="carousel-item active">
        <picture>
             <source media="(orientation: landscape)" data-srcset='/img/home-banner/home-banner-large.jpg 1676w, /img/home-banner/home-banner-medium.jpg 1200w, /img/home-banner/home-banner-small.jpg  700w,' sizes="100vw">

             <source media="(orientation: portrait)" data-srcset='/img/home-banner/home-banner-2x.jpg  700w, /img/home-banner/home-banner-1x.jpg  400w' sizes="100vw">

             <img src="/img/home-banner/home-banner-10px.jpg "
                 data-sizes="100vw"
                 class="img-fluid lazyload blur-up" alt="Banner1">
           </picture>
      
    </div>
    <div class="carousel-item">
     <picture>
             <source media="(orientation: landscape)" data-srcset='/img/home-banner/home-banner-boys-large.jpg 1676w, /img/home-banner/home-banner-boys-medium.jpg 1200w, /img/home-banner/home-banner-boys-small.jpg  700w,' sizes="100vw">

             <source media="(orientation: portrait)" data-srcset='/img/home-banner/home-banner-boys-2x.jpg  700w, /img/home-banner/home-banner-boys-1x.jpg  400w' sizes="100vw">

             <img src="/img/home-banner/home-banner-boys-10px.jpg "
                 data-sizes="100vw"
                 class="img-fluid lazyload blur-up" alt="Banner2">
           </picture>
    </div>
    <div class="carousel-item">
    <picture>
             <source media="(orientation: landscape)" data-srcset='/img/home-banner/home-banner-infants-large.jpg 1676w, /img/home-banner/home-banner-infants-medium.jpg 1200w, /img/home-banner/home-banner-infants-small.jpg  700w,' sizes="100vw">

             <source media="(orientation: portrait)" data-srcset='/img/home-banner/home-banner-infants-2x.jpg  700w, /img/home-banner/home-banner-infants-2x.jpg  400w' sizes="100vw">

             <img src="/img/home-banner/home-banner-infants-10px.jpg "
                 data-sizes="100vw"
                 class="img-fluid lazyload blur-up" alt="Banner2">
           </picture>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<section class="mt-5">
  <div class="container mb-3">
      <div class="row">
          <div class="col-md-3 col-6 mb-md-0 mb-3">
            <div class="card border-0 text-center pt-3" style="background-color:#EEFAFC;">
                <label class="font-weight-bold m-0">0-2 YEARS</label>
                <h4 class="font-weight-bold ">Infants</h4>
                <hr class="w-25 m-auto border-dark">
                <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/gender/infant-10px.jpg'
         srcset='/img/gender/infant-large.jpg 2000w,
                 /img/gender/infant-medium.jpg 1000w, 
                 /img/gender/infant-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
            </div>
          </div>
          <div class="col-md-3 col-6 mb-md-0 mb-3" >
            <div class="card border-0 text-center pt-3" style="background-color:#F3F3F1;">
                <label class="font-weight-bold m-0">2-14 YEARS</label>
                <h4 class="font-weight-bold">Boys</h4>
                <hr class="w-25 m-auto border-dark">
                 <img class="d-block w-100 img-fluid lazyload blur-up" src='/img/gender/boy-10px.jpg'
         srcset='/img/gender/boy-large.jpg 2000w,
                 /img/gender/boy-medium.jpg 1000w, 
                 /img/gender/boy-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
            </div>
          </div>
          <div class="col-md-3 col-6" >
            <div class="card border-0 text-center pt-3" style="background-color:#F4E6DC;">
                <label class="font-weight-bold m-0">2-14 YEARS</label>
                 <h4 class="font-weight-bold">Girls</h4>
                 <hr class="w-25 m-auto border-dark">
                 <img class="d-block w-100 img-fluid lazyload blur-up" src='/img/gender/girl-10px.jpg'
         srcset='/img/gender/girl-large.jpg 2000w,
                 /img/gender/girl-medium.jpg 1000w, 
                 /img/gender/girl-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
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
       <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/new-arrival/slider-bag-10px.jpg'
         srcset='/img/new-arrival/slider-bag-large.jpg 2000w,
                 /img/new-arrival/slider-bag-medium.jpg 1000w, 
                 /img/new-arrival/slider-bag-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </div>
    <div class="carousel-item">
     <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/new-arrival/slider-toy-10px.jpg'
         srcset='/img/new-arrival/slider-toy-large.jpg 2000w,
                 /img/new-arrival/slider-toy-medium.jpg 1000w, 
                 /img/new-arrival/slider-toy-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </div>
    <div class="carousel-item">
        <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/new-arrival/slider-shoes-10px.jpg'
         srcset='/img/new-arrival/slider-shoes-large.jpg 2000w,
                 /img/new-arrival/slider-shoes-medium.jpg 1000w, 
                 /img/new-arrival/slider-shoes-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
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
<main>
    <article style="background-color:#bce4f8;">
      <div class="p-3">
      <h4 class="font-weight-bold m-0">Party Showstoppers</h4>
      <p>Lorem ipsum dolor sit amet</p>
    </div>
      <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src='/img/collection/baby-woollen-cap-large.jpg'
         srcset='/img/collection/baby-woollen-cap-large.jpg 2000w,
                 /img/collection/baby-woollen-cap-small.jpg 1000w, 
                 /img/collection/baby-woollen-cap-medium.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </article>
    <article style="background-color:#F4D5D3;">    
      <div class="p-3">
      <h4 class="font-weight-bold m-0">House Of Comfort</h4>
      <p>Lorem ipsum dolor sit amet</p>
    </div>
        <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src='/img/collection/party-showstoppers-10px.jpg'
         srcset='/img/collection/party-showstoppers-large.jpg 2000w,
                 /img/collection/party-showstoppers-medium.jpg 1000w, 
                 /img/collection/party-showstoppers-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </article>
  <article style="background-color:#fff8ed;">
      <div class="p-3">
      <h4 class="font-weight-bold m-0">Party Showstoppers</h4>
      <p>Lorem ipsum dolor sit amet</p>
    </div>
          <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src='/img/collection/printed-top-pyjama-set-10px.jpg'
         srcset='/img/collection/printed-top-pyjama-set-large.jpg 2000w,
                 /img/collection/printed-top-pyjama-set-medium.jpg 1000w, 
                 /img/collection/printed-top-pyjama-set-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </article>
    <article style="background-color:#ffda44;">
             <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src='/img/collection/girl-floral-10px.jpg'
         srcset='/img/collection/girl-floral-large.jpg 2000w,
                 /img/collection/girl-floral-medium.jpg 1000w, 
                 /img/collection/girl-floral-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </article>
    <article style="background-color:#F4D5D3;">    
      <div class="p-3">
      <h4 class="font-weight-bold m-0">House Of Comfort</h4>
      <p>Lorem ipsum dolor sit amet</p>
    </div>
        <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src='/img/collection/party-showstoppers-10px.jpg'
         srcset='/img/collection/party-showstoppers-large.jpg 2000w,
                 /img/collection/party-showstoppers-medium.jpg 1000w, 
                 /img/collection/party-showstoppers-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </article>
  <article style="background-color:#F4D5D3;">
      <div class="p-3">
      <h4 class="font-weight-bold m-0">Party Showstoppers</h4>
      <p>Lorem ipsum dolor sit amet</p>
    </div>
            <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src='/img/collection/party-showstoppers-10px.jpg'
         srcset='/img/collection/party-showstoppers-large.jpg 2000w,
                 /img/collection/party-showstoppers-medium.jpg 1000w, 
                 /img/collection/party-showstoppers-small.jpg 700w'
         sizes='(min-width: 768px) 60vw,  100vw' />
    </article>
    
  </main>
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
                  <div class="image oh loading-01 image-loaded">
                   <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/1front-10px.jpg'
         srcset='/img/home-list/1front@1x.jpg 2000w,
                 /img/home-list/1front@2x.jpg 1000w, 
                 /img/home-list/1front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
              </div>
            </div>
       <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
              	
                <a href="#">
                  <div class="image oh loading-01 image-loaded">
                   <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/2front-10px.jpg'
         srcset='/img/home-list/2front@1x.jpg 2000w,
                 /img/home-list/2front@2x.jpg 1000w, 
                 /img/home-list/2front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
             
              </div>
            </div>
     <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
              	
                <a href="#">
                  <div class="image oh loading-01 image-loaded">
                    <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/3front-10px.jpg'
         srcset='/img/home-list/3front@1x.jpg 2000w,
                 /img/home-list/3front@2x.jpg 1000w, 
                 /img/home-list/3front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
           
              </div>
            </div>
   <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
              	
                <a href="#">
                  <div class="image oh loading-01 image-loaded">
                         <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/4front-10px.jpg'
         srcset='/img/home-list/4front@1x.jpg 2000w,
                 /img/home-list/4front@2x.jpg 1000w, 
                 /img/home-list/4front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
              </div>
            </div>
    <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
                
                <a href="/kss/product/">
                  <div class="image oh loading-01 image-loaded">
                        <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/5front-10px.jpg'
         srcset='/img/home-list/5front@1x.jpg 2000w,
                 /img/home-list/5front@2x.jpg 1000w, 
                 /img/home-list/5front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
              </div>
            </div>
       <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
                
                <a href="/kss/product/">
                  <div class="image oh loading-01 image-loaded">
                        <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/6front-10px.jpg'
         srcset='/img/home-list/6front@1x.jpg 2000w,
                 /img/home-list/6front@2x.jpg 1000w, 
                 /img/home-list/6front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
             
              </div>
            </div>
     <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
                
                <a href="/kss/product/">
                  <div class="image oh loading-01 image-loaded">
                         <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/7front-10px.jpg'
         srcset='/img/home-list/7front@1x.jpg 2000w,
                 /img/home-list/7front@2x.jpg 1000w, 
                 /img/home-list/7front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
                 </div>
                </a>
           
              </div>
            </div>
   <div class="col-lg-3 col-md-6 mb-4 col-6  ">

              <div class="card h-100 product-card">
              
                
                <a href="/kss/product/">
                  <div class="image oh loading-01 image-loaded">
                       <img class="d-block w-100 img-fluid lazyload blur-up"  src='/img/home-list/8front-10px.jpg'
         srcset='/img/home-list/8front@1x.jpg 2000w,
                 /img/home-list/8front@2x.jpg 1000w, 
                 /img/home-list/8front@3x.jpg 700w'
         sizes='(min-width: 768px) 60vw,  50vw' />
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