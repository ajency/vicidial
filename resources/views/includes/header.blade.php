@php
$menu =  getMenu();
$json['cdn_url'] = CDN::asset('/');
@endphp
<div class="container pl-2 pl-sm-0 pr-2 pr-sm-0">
<nav class="navbar navbar-expand-lg better-bootstrap-nav-left pl-1 pr-1 pb-0 pt-0">

    <div class="megamenu-open menu-toggle pr-3 py-2 d-block d-lg-none">
      <i class="fas fa-bars"></i>
    </div>

    <a href="/" class="header-logo">
      <img src="{{CDN::asset('/img/logo-kss.png') }}" class=" img-fluid m-0 kss-logo" width="180px">
    </a>

    <div class="megamenu">

      <div class="d-flex d-lg-none justify-content-between align-items-center border-bottom border-cancel header-close-trigger header-top">
        <a href="/">
          <img src="{{CDN::asset('/img/logo-kss.png') }}" class=" img-fluid m-3 d-block d-lg-none" width="180px">
        </a>
        <div class="megamenu-close menu-toggle p-3">
          <i class="fas fa-times"></i>
        </div>
      </div>

      <div class="d-flex megamenu__contents">
        <ul class="nav flex-column megamenu--left d-flex d-lg-none">
          <li class="nav-item" data-target="Boys">
            Boys
          </li>
          <li class="nav-item" data-target="Girls">
            Girls
          </li>
          <li class="nav-item" data-target="Infants">
            Infants
          </li>
          <li class="nav-item" data-target="Toys">
            Toys
          </li>
          <li class="nav-item" data-target="Stationery">
            Stationery
          </li>
          <li class="nav-item">
            <a href="/shop/uniforms" class="d-inline font-weight-normal p-0" style="line-height: normal">Uniforms</a>
          </li>
          <!--li class="flex-grow-1 disabled"></li-->
          <li class="nav-item" data-target="otherlinks">
            Other links
          </li>
        </ul>

        <ul class="nav megamenu--right">

              <li>
                  <a class="d-none d-lg-block cursor-pointer">Boys</a>
                  <div class="megamenu-wrapper" data-menu="Boys">
                    
                      <div class="nav-column d-lg-none">
                        <a class="menu-banner-item" href="/boys/junior-7-14-years--toddler-2-7-years/tshirt">
                          <img src="{{CDN::asset('/img/menu/banners/tshirts.jpg')}}" class="menu-item-img img-fluid mb-0 d-lg-none" title="offers">
                        </a>
                      </div>

                      <div class="nav-column d-lg-none">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Supper Offers</div>
                            <ul class="list-unstyled layout--offers">
                              <li>
                                <a href="/shop?pf=tag:flat-50" class="megamenu-link">
                                  <img src="{{CDN::asset('/img/menu/offer/50-off.jpg')}}" class="menu-item-img img-fluid d-lg-none">
                                </a>
                              </li>
                              <li>
                                <a href="/shop?pf=tag:flat-50" class="megamenu-link">
                                  <img src="{{CDN::asset('/img/menu/offer/holiday-off.jpg')}}" class="menu-item-img img-fluid d-lg-none">
                                </a>
                              </li>
                            </ul>
                        </div>                          
                      </div>

                      <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Category</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 0; $i < 2; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['boys'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['boys'][$i]['images']))
                                                <img src="{{$menu['boys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['boys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Brands</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 2; $i < 7; $i++)
                                    <li>
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['boys'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['boys'][$i]['images']))
                                                <img src="{{$menu['boys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['boys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Clothing</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 7; $i < 16; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['boys'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['boys'][$i]['images']))
                                                <img src="{{$menu['boys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['boys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Price</div>

                            <ul class="list-unstyled layout--tags">
                                @for ($i = 16; $i < 20; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['boys'][$i]['element_data']['link']}}">
                                            @if(!is_array($menu['boys'][$i]['images']))
                                                <img src="{{$menu['boys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['boys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Age Group</div>

                            <ul class="list-unstyled layout--2-col">
                                @for ($i = 20; $i < 22; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['boys'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['boys'][$i]['images']))
                                                <img src="{{$menu['boys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['boys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                      

                    <div class="nav-column nav-column--wide d-none d-lg-block">
                        <a href="{{$menu['boys'][22]['element_data']['image']['href']}}" class="d-block">
                          <img  class="d-block w-100 img-fluid offer-img mt-4 mt-lg-0"
                             src="{{$menu['boys'][22]['images']['default']['1x']}}"
                             data-srcset="{{$menu['boys'][22]['images']['default']['2x']}} 2x,
                                          {{$menu['boys'][22]['images']['default']['1x']}} 1x"
                             alt="{{$menu['boys'][22]['element_data']['image']['img_alt']}}"
                             title="{{$menu['boys'][22]['element_data']['image']['title']}}"/>
                        </a>
                        @if($menu['boys'][22]['element_data']['text']['text1'])
                            <div class="row align-items-center mt-2 mb-4 mb-lg-0">
                                <div class="col-7">
                                  <div class="h5 text-primary font-weight-bold">Spotlight on</div>
                                  <div class="text-white">{{$menu['boys'][22]['element_data']['text']['text1']}}</div>
                                </div>
                                <div class="col-5">
                                  <a href="{{$menu['boys'][22]['element_data']['image']['href']}}" class="btn kss-btn kss-btn--mini">Shop now</a>
                                </div>
                            </div>
                        @endif
                        
                    </div>
                  </div>
              </li>

               <li>
                  <a class="d-none d-lg-block cursor-pointer">Girls</a>
                  <div class="megamenu-wrapper" data-menu="Girls">

                    <div class="nav-column d-lg-none">
                      <a class="menu-banner-item" href="/girls/junior-7-14-years--toddler-2-7-years/dress">
                        <img src="{{CDN::asset('/img/menu/banners/dresses.jpg')}}" class="menu-item-img img-fluid mb-0 d-lg-none" title="offers">
                      </a>
                    </div>

                    <div class="nav-column d-lg-none">
                      <div>
                          <div class="nav-column--heading mt-1 mb-2">Supper Offers</div>
                          <ul class="list-unstyled layout--offers">
                            <li>
                              <a href="/shop?pf=tag:flat-50" class="megamenu-link">
                                <img src="{{CDN::asset('/img/menu/offer/50-off.jpg')}}" class="menu-item-img img-fluid d-lg-none">
                              </a>
                            </li>
                            <li>
                              <a href="/shop?pf=tag:flat-50" class="megamenu-link">
                                <img src="{{CDN::asset('/img/menu/offer/holiday-off.jpg')}}" class="menu-item-img img-fluid d-lg-none">
                              </a>
                            </li>
                          </ul>
                      </div>                          
                    </div>

                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Category</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 0; $i < 2; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['girls'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['girls'][$i]['images']))
                                                <img src="{{$menu['girls'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['girls'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Brands</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 2; $i < 7; $i++)
                                    <li>
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['girls'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['girls'][$i]['images']))
                                                <img src="{{$menu['girls'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['girls'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Clothing</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 7; $i < 15; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['girls'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['girls'][$i]['images']))
                                                <img src="{{$menu['girls'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['girls'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Price</div>

                            <ul class="list-unstyled layout--tags">
                                @for ($i = 15; $i < 19; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['girls'][$i]['element_data']['link']}}">
                                            @if(!is_array($menu['girls'][$i]['images']))
                                                <img src="{{$menu['girls'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['girls'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Age Group</div>

                            <ul class="list-unstyled layout--2-col">
                                @for ($i = 19; $i < 21; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['girls'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['girls'][$i]['images']))
                                                <img src="{{$menu['girls'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['girls'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                      

                    <div class="nav-column nav-column--wide d-none d-lg-block">
                        <a href="{{$menu['girls'][21]['element_data']['image']['href']}}" class="d-block">
                          <img  class="d-block w-100 img-fluid offer-img mt-4 mt-lg-0"
                             src="{{$menu['girls'][21]['images']['default']['1x']}}"
                             data-srcset="{{$menu['girls'][21]['images']['default']['2x']}} 2x,
                                          {{$menu['girls'][21]['images']['default']['1x']}} 1x"
                             alt="{{$menu['girls'][21]['element_data']['image']['img_alt']}}"
                             title="{{$menu['girls'][21]['element_data']['image']['title']}}"/>
                        </a>
                        @if($menu['girls'][21]['element_data']['text']['text1'])
                            <div class="row align-items-center mt-2 mb-4 mb-lg-0">
                                <div class="col-7">
                                  <div class="h5 text-primary font-weight-bold">Spotlight on</div>
                                  <div class="text-white">{{$menu['girls'][21]['element_data']['text']['text1']}}</div>
                                </div>
                                <div class="col-5">
                                  <a href="{{$menu['girls'][21]['element_data']['image']['href']}}" class="btn kss-btn kss-btn--mini">Shop now</a>
                                </div>
                            </div>
                        @endif
                        
                    </div>
                  </div>
              </li>

              <li>
                  <a class="d-none d-lg-block cursor-pointer">Infants</a>
                  <div class="megamenu-wrapper" data-menu="Infants">

                    <div class="nav-column d-lg-none">
                      <div>
                          <div class="nav-column--heading mt-1 mb-2">Supper Offers</div>
                          <ul class="list-unstyled layout--offers">
                            <li>
                              <a href="/shop?pf=tag:flat-50" class="megamenu-link">
                                <img src="{{CDN::asset('/img/menu/offer/50-off.jpg')}}" class="menu-item-img img-fluid d-lg-none">
                              </a>
                            </li>
                            <li>
                              <a href="/shop?pf=tag:flat-50" class="megamenu-link">
                                <img src="{{CDN::asset('/img/menu/offer/holiday-off.jpg')}}" class="menu-item-img img-fluid d-lg-none">
                              </a>
                            </li>
                          </ul>
                      </div>                          
                    </div>

                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Category</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 0; $i < 2; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['infants'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['infants'][$i]['images']))
                                                <img src="{{$menu['infants'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['infants'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Brands</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 2; $i < 7; $i++)
                                    <li>
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['infants'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['infants'][$i]['images']))
                                                <img src="{{$menu['infants'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['infants'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Clothing</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 7; $i < 18; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['infants'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['infants'][$i]['images']))
                                                <img src="{{$menu['infants'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['infants'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Price</div>

                            <ul class="list-unstyled layout--tags">
                                @for ($i = 18; $i < 22; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['infants'][$i]['element_data']['link']}}">
                                            @if(!is_array($menu['infants'][$i]['images']))
                                                <img src="{{$menu['infants'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['infants'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                      

                    <div class="nav-column nav-column--wide d-none d-lg-block">
                        <a href="{{$menu['infants'][22]['element_data']['image']['href']}}" class="d-block">
                          <img  class="d-block w-100 img-fluid offer-img mt-4 mt-lg-0"
                             src="{{$menu['infants'][22]['images']['default']['1x']}}"
                             data-srcset="{{$menu['infants'][22]['images']['default']['2x']}} 2x,
                                          {{$menu['infants'][22]['images']['default']['1x']}} 1x"
                             alt="{{$menu['infants'][22]['element_data']['image']['img_alt']}}"
                             title="{{$menu['infants'][22]['element_data']['image']['title']}}"/>
                        </a>
                        @if($menu['infants'][22]['element_data']['text']['text1'])
                            <div class="row align-items-center mt-2 mb-4 mb-lg-0">
                                <div class="col-7">
                                  <div class="h5 text-primary font-weight-bold">Spotlight on</div>
                                  <div class="text-white">{{$menu['infants'][22]['element_data']['text']['text1']}}</div>
                                </div>
                                <div class="col-5">
                                  <a href="{{$menu['infants'][22]['element_data']['image']['href']}}" class="btn kss-btn kss-btn--mini">Shop now</a>
                                </div>
                            </div>
                        @endif
                        
                    </div>
                  </div>
              </li>

              <li>
                  <a class="d-none d-lg-block cursor-pointer">Toys</a>
                  <div class="megamenu-wrapper" data-menu="Toys">

                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Sub-Types</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 0; $i < 2; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['toys'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['toys'][$i]['images']))
                                                <img src="{{$menu['toys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['toys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Price</div>

                            <ul class="list-unstyled layout--tags">
                                @for ($i = 2; $i < 6; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['toys'][$i]['element_data']['link']}}">
                                            @if(!is_array($menu['toys'][$i]['images']))
                                                <img src="{{$menu['toys'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['toys'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>

                    <div class="nav-column nav-column--wide d-none d-lg-block">
                        <a href="{{$menu['toys'][6]['element_data']['image']['href']}}" class="d-block">
                          <img  class="d-block w-100 img-fluid offer-img mt-4 mt-lg-0"
                             src="{{$menu['toys'][6]['images']['default']['1x']}}"
                             data-srcset="{{$menu['toys'][6]['images']['default']['2x']}} 2x,
                                          {{$menu['toys'][6]['images']['default']['1x']}} 1x"
                             alt="{{$menu['toys'][6]['element_data']['image']['img_alt']}}"
                             title="{{$menu['toys'][6]['element_data']['image']['title']}}"/>
                        </a>
                        @if($menu['toys'][6]['element_data']['text']['text1'])
                            <div class="row align-items-center mt-2 mb-4 mb-lg-0">
                                <div class="col-6">
                                  <div class="h5 text-primary font-weight-bold">Spotlight on</div>
                                  <div class="text-white">{{$menu['toys'][6]['element_data']['text']['text1']}}</div>
                                </div>
                                <div class="col-5">
                                  <a href="{{$menu['toys'][6]['element_data']['image']['href']}}" class="btn kss-btn kss-btn--mini">Shop now</a>
                                </div>
                            </div>
                        @endif
                        
                    </div>
                  </div>
              </li>

              <li>
                  <a class="d-none d-lg-block cursor-pointer">Stationery</a>
                  <div class="megamenu-wrapper" data-menu="Stationery">

                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Sub-Types</div>

                            <ul class="list-unstyled layout--3-col">
                                @for ($i = 0; $i < 4; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['stationery'][$i]['element_data']['image']['href']}}">
                                            @if(!is_array($menu['stationery'][$i]['images']))
                                                <img src="{{$menu['stationery'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['stationery'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="nav-column">
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">Shop by Price</div>

                            <ul class="list-unstyled layout--tags">
                                @for ($i = 4; $i < 8; $i++)
                                    <li >
                                        <a class="megamenu-link cursor-pointer" href="{{$menu['stationery'][$i]['element_data']['link']}}">
                                            @if(!is_array($menu['stationery'][$i]['images']))
                                                <img src="{{$menu['stationery'][$i]['images']['default']['2x']}}" class="menu-item-img img-fluid mb-1">
                                            @endif
                                            <span class="title">{{$menu['stationery'][$i]['element_data']['text']['text1']}}</span> 
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>      

                    <div class="nav-column nav-column--wide d-none d-lg-block">
                        <a href="{{$menu['stationery'][8]['element_data']['image']['href']}}" class="d-block">
                          <img  class="d-block w-100 img-fluid offer-img mt-4 mt-lg-0"
                             src="{{$menu['stationery'][8]['images']['default']['1x']}}"
                             data-srcset="{{$menu['stationery'][8]['images']['default']['2x']}} 2x,
                                          {{$menu['stationery'][8]['images']['default']['1x']}} 1x"
                             alt="{{$menu['stationery'][8]['element_data']['image']['img_alt']}}"
                             title="{{$menu['stationery'][8]['element_data']['image']['title']}}"/>
                        </a>
                        @if($menu['stationery'][8]['element_data']['text']['text1'])
                            <div class="row align-items-center mt-2 mb-4 mb-lg-0">
                                <div class="col-7">
                                  <div class="h5 text-primary font-weight-bold">Spotlight on</div>
                                  <div class="text-white">{{$menu['stationery'][8]['element_data']['text']['text1']}}</div>
                                </div>
                                <div class="col-5">
                                  <a href="{{$menu['stationery'][8]['element_data']['image']['href']}}" class="btn kss-btn kss-btn--mini">Shop now</a>
                                </div>
                            </div>
                        @endif
                    </div>
                  </div>
              </li>

            <li>
              <a href="/ideas" class="d-none d-lg-block">Blog</a>
            </li>

            <li>
              <a href="/shop/uniforms" class="d-none d-lg-block">Uniforms</a>
            </li>


            <!-- Other links -->
            <li class="d-lg-none align-self-end">
              <div class="megamenu-wrapper" data-menu="otherlinks">
                <div class="nav-column mb-0">
                  <ul class="list-unstyled">
                    <li><a class="megamenu-link" href="/about-us">About Us</a></li>
                    <li><a class="megamenu-link" href="/contact">Contact Us</a></li>
                    <li><a href="https://cutshort.io/company/omni-edge-retail-private-ltd?career_page=true" class="megamenu-link">Careers</a></li>
                    <li><a class="megamenu-link" href="/faq">FAQ</a></li>
                    <li><a class="megamenu-link" href="/terms-and-conditions">Terms of Use</a></li>
                    <li><a class="megamenu-link" href="/privacy-policy">Privacy Policy</a></li>
                    <li><a class="megamenu-link" href="/ideas">Blog</a></li>
                  </ul>
                </div>
              </div>
            </li>
        </ul>
      </div>
    </div>

    <div class="my-lg-0 ml-auto header-actions">
        <ul class="list-inline mb-2 pt-2">
            <li class="list-inline-item">
                <a class="cursor-pointer" id="cd-my-account-trigger">
                    <i class="kss_icon profile-icon">
                   </i>
                </a>
            </li>
            <li class="list-inline-item pr-0 ">
                <div id="cd-cart-trigger" class="shopping-cart position-relative cursor-pointer">
                   <i class="kss_icon bag-icon cursor-pointer">
                   </i>
                   <span class="badge badge-light cart-counter d-none"><div id="output">0</div></span>
                </div>
            </li>
        </ul>
    </div>
</nav>
</div>