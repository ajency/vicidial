@php
$json = json_decode(file_get_contents(config_path() . "/static_responses/menu.json"), true);
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
            <!-- Boys -->
            @php
            foreach($json['menu'] as $item) {
              if($item['type'] != 'Blog' && $item['type'] != 'Uniforms') {
            @endphp
              <li>
                  <a class="d-none d-lg-block cursor-pointer">{{$item['type']}}</a>
                  <div class="megamenu-wrapper" data-menu="{{$item['type']}}">
                    
                      <!-- Mobile Menu Banner -->
                      @php
                      if($item['type'] == 'Boys') {
                      @endphp
                        <div class="nav-column d-lg-none">
                          <div class="menu-banner-item" href="/boys/junior-7-14-years--toddler-2-7-years/tshirt">
                            <img src="{{CDN::asset('/img/menu/banners/tshirts.jpg')}}" class="menu-item-img img-fluid mb-0 d-lg-none" title="offers">
                          </div>
                        </div>
                      @php
                      }

                      if($item['type'] == 'Girls') {
                      @endphp
                        <div class="nav-column d-lg-none">
                          <div class="menu-banner-item" href="/girls/junior-7-14-years--toddler-2-7-years/dress">
                            <img src="{{CDN::asset('/img/menu/banners/dresses.jpg')}}" class="menu-item-img img-fluid mb-0 d-lg-none" title="offers">
                          </div>
                        </div>
                      @php
                      }
                      @endphp

                      <!-- Supper Offers -->
                      @php
                      if($item['type'] == 'Boys' || $item['type'] == 'Girls' || $item['type'] == 'Infants') {
                      @endphp
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
                      @php
                      }
                      @endphp

                      @php
                      foreach($item['rows'] as $row) {
                      @endphp
                      <div class="nav-column">
                        @php
                        foreach($row['menus'] as $menu) {
                        @endphp
                        <div>
                            <div class="nav-column--heading mt-1 mb-2">{{$menu['shop_by']}}</div>
                            <ul class="list-unstyled @php if($menu['shop_by'] == 'Shop by Category' || $menu['shop_by'] == 'Shop by Clothing' || $menu['shop_by'] == 'Shop by Brands' || $menu['shop_by'] == 'Shop by Sub-Types' || $menu['shop_by'] == 'Shop by Gender') { @endphp layout--3-col @php } if($menu['shop_by'] == 'Shop by Price') { @endphp layout--tags  @php } if($menu['shop_by'] == 'Shop by Age Group') { @endphp layout--2-col @php } @endphp">
                            @php
                            foreach($menu['data'] as $type) {
                            @endphp
                              <li>
                                <a class="megamenu-link @php if($type['title'] == 'View all products') { @endphp megamenu-link--primary @php } @endphp" href="{{$type['link']}}" title="{{$type['title']}}">
                                @php
                                if(isset($type['image'])) {
                                @endphp
                                  <img src="{{CDN::asset('/'.$type['image'])}}" class="menu-item-img img-fluid mb-1">
                                @php
                                }
                                @endphp
                                  <span class="title">{{$type['title']}}</span> 
                                </a>
                              </li>
                            @php
                            }
                            @endphp
                            </ul>
                        </div>
                        @php
                        }
                        @endphp
                      </div>
                      @php
                      }
                      @endphp

                      @php
                      if(isset($item['image_section'])) {
                      @endphp
                        <div class="nav-column nav-column--wide d-none d-lg-block">
                            <a href="{{$item['image_section']['href']}}" class="d-block">
                              <img  class="d-block w-100 img-fluid offer-img mt-4 mt-lg-0"
                                 src="{{CDN::asset('/'.$item['image_section']['images']['1x'])}}"
                                 data-srcset="{{CDN::asset('/'.$item['image_section']['images']['2x'])}} 2x,
                                              {{CDN::asset('/'.$item['image_section']['images']['1x'])}} 1x"
                                 alt="{{$item['image_section']['img_alt']}}"
                                 title="{{$item['image_section']['title']}}"/>
                            </a>
                            @php
                            if(isset($item['image_section']['text'])) {
                            @endphp
                            <div class="row align-items-center mt-2 mb-4 mb-lg-0">
                                <div class="col-7">
                                  <div class="h5 text-primary font-weight-bold">Spotlight on</div>
                                  <div class="text-white">{{$item['image_section']['text']}}</div>
                                </div>
                                <div class="col-5">
                                  <a href="{{$item['image_section']['href']}}" class="btn kss-btn kss-btn--mini">Shop now</a>
                                </div>
                            </div>
                            @php
                            }
                            @endphp
                        </div>
                      @php
                      }
                      @endphp
                  </div>
              </li>
            @php
              }
            }
            @endphp

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