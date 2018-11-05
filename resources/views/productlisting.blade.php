@extends('layouts.default')

@section('headjs')

  <script type="text/javascript" src="/js/handlebars.min.js"></script>

  <style type="text/css" media="screen">
    :root{--blue:#007bff;--indigo:#6610f2;--purple:#6f42c1;--pink:#e83e8c;--red:#dc3545;--orange:#fd7e14;--yellow:#ffc107;--green:#28a745;--teal:#20c997;--cyan:#17a2b8;--white:#fff;--gray:#6c757d;--gray-dark:#343a40;--primary:#f9bc23;--secondary:#004283;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#ad110a;--light:#e4e4e4;--dark:#707279;--cancel:#4b4b4b;--breakpoint-xs:0;--breakpoint-sm:576px;--breakpoint-md:768px;--breakpoint-lg:992px;--breakpoint-xl:1200px;--font-family-sans-serif:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";--font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar}@-ms-viewport{width:device-width}nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:.85rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;font-family:'Open Sans',sans-serif}hr{margin-bottom:1rem}hr{box-sizing:content-box;height:0;overflow:visible;margin-top:1rem;border:0;border-top:1px solid rgba(0,0,0,.1)}h5,h6,ul{margin-top:0}ul{margin-bottom:1rem}ul ul{margin-bottom:0}a{color:#f9bc23;background-color:transparent;-webkit-text-decoration-skip:objects;text-decoration:none!important}img{vertical-align:middle;border-style:none}button{border-radius:0}button,input{margin:0}button,input,select{font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.h1,h5,h6{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}.h1{font-size:2.125rem}h5{font-size:1.0625rem}h6{font-size:.85rem}.list-inline,.list-unstyled{padding-left:0;list-style:none}.list-inline-item{display:inline-block}.list-inline-item:not(:last-child){margin-right:.5rem}.img-fluid{max-width:100%;height:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:1200px){.container{max-width:1200px}}.row{display:flex;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.no-gutters{margin-right:0;margin-left:0}.no-gutters>[class*=col-]{padding-right:0;padding-left:0}.col-6{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col-lg-4,.col-md-3,.col-md-6,.col-md-9,.col-sm-12,.col-sm-6{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col-6{flex:0 0 50%;max-width:50%}@media (min-width:576px){.col-sm-6{flex:0 0 50%;max-width:50%}.col-sm-12{flex:0 0 100%;max-width:100%}}@media (min-width:768px){.col-md-3{flex:0 0 25%;max-width:25%}.col-md-6{flex:0 0 50%;max-width:50%}.col-md-9{flex:0 0 75%;max-width:75%}}@media (min-width:992px){.col-lg-4{flex:0 0 33.33333%;max-width:33.33333%}}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:.85rem;line-height:1.5;color:#495057;background-clip:padding-box;border-radius:.25rem}.form-control::-ms-expand{background-color:transparent;border:0}select.form-control:not([size]):not([multiple]){height:calc(2.025rem + 4px)}.form-group{margin-bottom:1rem}.form-inline{display:flex;flex-flow:row wrap;align-items:center}@media (min-width:576px){.form-inline .form-group{display:flex;align-items:center;margin-bottom:0}.form-inline .form-group{flex:0 0 auto;flex-flow:row wrap}.form-inline .form-control{display:inline-block;width:auto;vertical-align:middle}}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;border:1px solid transparent;padding:.375rem .75rem;font-size:.85rem;line-height:1.5;border-radius:.25rem}.btn-primary{color:#212529;background-color:#f9bc23;border-color:#f9bc23}.btn-link{background-color:transparent}.btn-link{font-weight:400;color:#f9bc23}.btn-lg{padding:.5rem 1rem;font-size:.9rem;line-height:2;border-radius:.2rem}.btn-block{display:block;width:100%}.fade:not(.show){opacity:0}.collapse:not(.show){display:none}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;padding:.5rem 1rem}.navbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{font-size:.9rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.25rem}.card>.list-group:last-child .list-group-item:last-child{border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.card-body{flex:1 1 auto;padding:1.25rem}.card-title{margin-bottom:.75rem}.card-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,.03);border-bottom:1px solid rgba(0,0,0,.125)}.card-header:first-child{border-radius:calc(.25rem - 1px) calc(.25rem - 1px) 0 0}.card-header+.list-group .list-group-item:first-child{border-top:0}.card-img-top{width:100%;border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem}.badge-light{color:#212529;background-color:#e4e4e4}.list-group{display:flex;flex-direction:column;padding-left:0;margin-bottom:0}.list-group-item{position:relative;display:block;padding:.75rem 1.25rem;margin-bottom:-1px;background-color:#fff;border:1px solid rgba(0,0,0,.125)}.list-group-item:first-child{border-top-left-radius:.25rem;border-top-right-radius:.25rem}.list-group-item:last-child{margin-bottom:0;border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.list-group-flush .list-group-item{border-right:0;border-left:0;border-radius:0}.list-group-flush:last-child .list-group-item:last-child{border-bottom:0}.close{float:right;font-size:1.275rem;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;opacity:.5}button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}.modal{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;outline:0}.modal-dialog{position:relative;width:auto;margin:.5rem}.modal.fade .modal-dialog{transform:translate(0,-25%)}.modal-content{position:relative;display:flex;flex-direction:column;width:100%;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-radius:.2rem;outline:0}.modal-header{display:flex;align-items:flex-start;justify-content:space-between;padding:1rem;border-bottom:1px solid #e9ecef;border-top-left-radius:.2rem;border-top-right-radius:.2rem}.modal-header .close{padding:1rem;margin:-1rem -1rem -1rem auto}.modal-title{margin-bottom:0;line-height:1.5}@media (min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}}img{opacity:1}.d-none{display:none!important}.d-block{display:block!important}.d-flex{display:flex!important}@media (min-width:576px){.d-sm-block{display:block!important}}@media (min-width:768px){.d-md-none{display:none!important}}.justify-content-center{justify-content:center!important}.align-items-center{align-items:center!important}.float-right{float:right!important}.position-relative{position:relative!important}.fixed-bottom{position:fixed;right:0;left:0}.fixed-bottom{bottom:0}.h-100{height:100%!important}.m-0{margin:0!important}.mb-0{margin-bottom:0!important}.mt-1{margin-top:.25rem!important}.mb-1{margin-bottom:.25rem!important}.mt-2,.my-2{margin-top:.5rem!important}.mb-2,.my-2{margin-bottom:.5rem!important}.ml-4{margin-left:1.5rem!important}.pt-0{padding-top:0!important}.pr-0{padding-right:0!important}.pb-0{padding-bottom:0!important}.pr-1{padding-right:.25rem!important}.pl-1{padding-left:.25rem!important}.py-2{padding-top:.5rem!important}.pr-2,.px-2{padding-right:.5rem!important}.py-2{padding-bottom:.5rem!important}.pl-2,.px-2{padding-left:.5rem!important}.pt-3{padding-top:1rem!important}.mr-auto{margin-right:auto!important}@media (min-width:576px){.mx-sm-3{margin-right:1rem!important}.mx-sm-3{margin-left:1rem!important}.mb-sm-4{margin-bottom:1.5rem!important}.pr-sm-0{padding-right:0!important}.pl-sm-0{padding-left:0!important}}@media (min-width:768px){.mt-md-4{margin-top:1.5rem!important}}@media (min-width:992px){.mt-lg-0,.my-lg-0{margin-top:0!important}.my-lg-0{margin-bottom:0!important}}.text-center{text-align:center!important}.font-weight-bold{font-weight:700!important}.text-white{color:#fff!important}.text-secondary{color:#004283!important}.text-dark{color:#707279!important}.text-muted{color:#6c757d!important}.btn-lg{font-weight:700}@media (max-width:575.98px){#card-list .col-lg-4{padding:8px}}#card-list .product-card{overflow:hidden}#card-list .product-card .overlay{width:100%;opacity:0;position:absolute;top:0;z-index:1;height:100%}@media (min-width:320px) and (max-width:767.98px){#card-list .product-card .overlay{display:none}}.card.product-card{border:0}@media (min-width:320px) and (max-width:767.98px){.card.product-card{background:0 0}}.card.product-card .card-title{font-weight:400;font-size:1rem}@media (max-width:575.98px){.card.product-card .card-title{font-size:.8rem}}.card.product-card .card-img-top{border-radius:5px}.card.product-card .card-body{flex:1 1 auto;padding:10px 0}.card.product-card .product-card__wrapper{height:380px;overflow:hidden}@media (max-width:991px){.card.product-card .product-card__wrapper{height:240px;border:1px solid #eee}}.card .placeholder-img{padding:0 3em;background-color:#e4e4e4;width:100%;height:100%}.kss_filter{overflow:hidden}.kss_filter .fixed-bottom{display:none}@media (min-width:320px) and (max-width:767.98px){.kss_filter{position:fixed;z-index:9999;background:#fff;width:100%;height:100%;top:0;left:730px;padding:16px}}.fixed-bottom{line-height:60px;background-color:#fff;box-shadow:-1px 0 22px #666;z-index:1020}.fixed-bottom .b-r{border-right:1px solid #ccc;height:58px}@media (min-width:320px) and (max-width:767.98px){body{font-size:80%}}.text-black{color:#000}.kss-price{font-size:1.3rem;font-weight:700}.kss-price--smaller{font-size:1.1em}@media (max-width:575.98px){.kss-price{font-size:1.4rem}.kss-price--smaller{font-size:1.1em}}.btn{position:relative}.bl-1{border-left:1px solid #e8eae8}.kss_icon{width:30px;height:33px;display:inline-block;margin-bottom:-4px}.kss_icon{background:url(../img/sprite.png) no-repeat}.kss_sort li{border-bottom:1px solid #f2f2f2}.discount,.latest,.popularity{background-size:295px}.popularity{background-position:-24px -10px}.latest{background-position:-71px -10px}.discount{background-position:-121px -10px}.search-icon{background-position:-6px -138px}.profile-icon{background-position:-107px -138px}.bag-icon{background-position:-501px -275px}.price-h{background-position:-180px -10px;background-size:295px}.top-icon{background:url(../img/sprite.png) no-repeat;width:50px;height:50px;background-position:-223px -119px}.price-l{background-position:-240px -10px;background-size:295px}.go-top{position:fixed;bottom:2em;right:2em;text-decoration:none;text-align:center;font-size:12px;display:none;padding:1em;z-index:1}@media (min-width:320px) and (max-width:767.98px){.go-top{bottom:5em;right:0;display:none!important}}.blur-up{-webkit-filter:blur(5px);filter:blur(5px)}select{width:100%;height:100%;margin:0;color:#fff}select.custom::-ms-expand,select::-ms-expand{display:none}.form-group{position:relative;margin-top:30px}.form-control{border:0;padding:10px 0;background-image:linear-gradient(#f9bc23,#f9bc23),linear-gradient(#d2d2d2,#d2d2d2);background-size:0% 2px,100% 1px;background-position:center bottom,center 100%;background-repeat:no-repeat;border-radius:0;background-color:transparent}select.custom{background-image:url(data:image/svg+xml;charset=utf-8,%3Csvg%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%20fill%3D%22%23555555%22%20%0A%09%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%22-261%20145.2%2024%2024%22%20style%3D%22enable-background%3Anew%20-261%20145.2%2024%2024%3B%22%20xml%3Aspace%3D%22preserve%22%3E%0A%3Cpath%20d%3D%22M-245.3%2C156.1l-3.6-6.5l-3.7%2C6.5%20M-252.7%2C159l3.7%2C6.5l3.6-6.5%22%2F%3E%0A%3C%2Fsvg%3E)!important;padding-right:25px!important;background-repeat:no-repeat!important;background-position:right center!important;-webkit-appearance:none;-moz-appearance:none;appearance:none}.overlay-fix{width:100%;height:100vh;background:rgba(0,0,0,.34);position:fixed;top:58px;z-index:99}@media (min-width:320px) and (max-width:767.98px){.overlay-fix{top:74px}}.recent-search{position:absolute;right:7%;top:58px;z-index:9999}@media (min-width:320px) and (max-width:767.98px){.recent-search{right:0;width:100%!important;top:140px}}.search-input{position:absolute;right:7%;top:8px;z-index:9999;background-color:#707279}@media (min-width:320px) and (max-width:767.98px){.search-input span{color:#000!important;position:absolute;bottom:0}}.search-input input{width:100%;height:40px;background:0;color:#fff;border:0;border-bottom:1px solid #cccc}@media (min-width:320px) and (max-width:767.98px){.search-input input{color:#000}}@media (min-width:320px) and (max-width:767.98px){.search-input{position:absolute;top:75px;height:54px;left:0;z-index:999;background:#fff;width:100%!important}.search-input input{width:90%;height:54px;padding-left:5px;outline:none}}.hide-search{position:absolute;right:5px;top:4px;z-index:2}.header{background-color:#707279}.header a{color:#fff}.recent-search a{color:#000!important}.navbar-toggler{padding:.15rem .45rem}.cart-counter{position:absolute;top:20px;right:2px}.hamburger{display:inline-block;font:inherit;color:inherit;text-transform:none;background-color:transparent;border:0;margin:0;overflow:visible}.hamburger-box{width:22px;height:18px;display:inline-block;position:relative}.hamburger-inner,.hamburger-inner::after,.hamburger-inner::before{border-radius:4px;position:absolute;display:block}.hamburger-inner{top:50%;margin-top:-2px}.hamburger-inner::after,.hamburger-inner::before{content:""}.hamburger-inner::after{bottom:-10px}.hamburger--collapse .hamburger-inner{top:auto;bottom:0}.hamburger-inner,.hamburger-inner::after,.hamburger-inner::before{width:22px;height:2px;background-color:#fff}.hamburger-inner::before{top:-7px}.hamburger--collapse .hamburger-inner::after{top:-14px}@media (min-width:360px) and (max-width:767.98px){.kss-logo{position:absolute;left:40px;top:24px}}@media (max-width:320px){.header ul .list-inline-item{margin-right:.1rem}.header img{width:144px;position:absolute;left:40px;top:26px}}#cd-cart{position:fixed;top:0;height:100%;width:80%;padding-top:10px;overflow-y:auto;overflow-x:hidden;-webkit-overflow-scrolling:touch;box-shadow:0 0 20px rgba(0,0,0,.2);z-index:9999}@media only screen and (min-width:768px){#cd-cart{width:400px}}@media (min-width:360px) and (max-width:767.98px){#cd-cart{width:100%;padding-bottom:68px}}@media (min-width:992px) and (min-width:1199.98px){#cd-cart{width:40%!important}}@media (min-width:1300px){#cd-cart{width:30%!important}}#cd-cart{right:-100%;background:#fff}#cd-cart>*{padding:0 1em}@media only screen and (min-width:1200px){#cd-cart>*{padding:0 1.5em}}#cd-shadow-layer{position:fixed;min-height:100%;width:100%;top:0;left:0;background:rgba(173,181,189,.6);z-index:99;display:none}@media (min-width:360px) and (max-width:767.98px){#cd-shadow-layer{display:none!important}}.cart-loader:after{content:'';position:absolute;width:100%;height:100%;top:0;left:0;background:rgba(255,255,255,.83) url(../img/loader_818e.gif) center center no-repeat;z-index:99999}@-webkit-keyframes scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}to{-webkit-transform:scale(1);transform:scale(1);opacity:0}}@keyframes scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}to{-webkit-transform:scale(1);transform:scale(1);opacity:0}}.loading:before{position:absolute;top:0;left:0;width:100%;height:100%}.loading:before{content:"";z-index:1;top:50%;left:50%;margin-top:-16px;margin-left:-16px;width:32px;height:32px;border-radius:32px;-webkit-animation:scaleout 1.2s infinite ease-in-out;animation:scaleout 1.2s infinite ease-in-out;mix-blend-mode:soft-light;background-color:rgba(0,0,0,.9)}.lazyload,.loading{opacity:1}
  </style>

@stop

@section('content')

	<section>
    <div class="container mt-2 mt-md-4">
     	<div class="row">
     	  <!-- Filters Blade -->
    	  @include('includes.productlisting.filters', ['filters' => $params->filters])
    	  <div class="col-sm-12 col-md-9 bl-1">
    	    <!-- Title, breadcrumbs, sort Blade -->
    	  	@include('includes.productlisting.listingtitle', ['headers' => $params->headers, 'breadcrumbs' => $params->breadcrumbs, 'sort_on' => $params->sort_on])
         
    	    <!-- List of products Blade -->
            @include('includes.productlisting.listingproducts', ['items' => $params->items])

    	  </div>
    	</div>
    </div>
    <br>
    <br>
    <!-- Filters, Sort for mobile Blade -->
    @include('includes.productlisting.filtersmobile', ['sort_on' => $params->sort_on])
  </section>

@stop

@section('footjs')
  <?php
    $facet_display_data = config('product.facet_display_data');

    // usort($facet_display_data, function($a, $b) {
    //       return $a["order"] > $b["order"] ? 1 : -1;
    //   });

    $config_facet_names_arr = array_keys($facet_display_data);
    $facet_value_slug_assoc = json_encode($params->search_result_assoc);
  ?>
  <script type="text/javascript" src="/js/productlisting.js"></script>
  @yield('footjs-gender')
  @yield('footjs-age')
  @yield('footjs-subtype')
  @yield('footjs-category')
  @yield('footjs-filter-tags')
  @yield('footjs-products-list')
  <script type="text/javascript">
      var facet_list = {}
      var config_facet_names_arr = <?= json_encode($config_facet_names_arr);?>;
      var facet_value_slug_assoc = <?= $facet_value_slug_assoc ?>;
      var filter_tags_list = [] ;
      console.log("facet_value_slug_assoc===")
      console.log(facet_value_slug_assoc)
      console.log("facet array===")
      console.log(config_facet_names_arr)
     $('body').on('change', '.facet-category', function() {
      // From the other examples
      console.log("change===")
      var call_ajax = false;
      var facet_name = $(this).data('facet-name')
      var singleton = $(this).data('singleton')
      var slug_name = $(this).data('slug')
      console.log(facet_name)
      console.log(this.checked+"==="+this.value);
      if(this.checked){
        if(facet_list.hasOwnProperty(facet_name)){
          if(facet_list[facet_name].indexOf(this.value) == -1){
            console.log("singleton=="+singleton)
            if(singleton == false){
              facet_list[facet_name].push(this.value)
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              if(fil_index == -1)
                filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
              call_ajax = true;
            }
            else{
              facet_list[facet_name] = [this.value]
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
              if(fil_index == -1){
                if(fil_grp_index == -1)
                  filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
                else{
                  filter_tags_list.splice(fil_grp_index, 1);
                  filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
                }
              }
              call_ajax = true;
            }

          }
        }
        else{
          facet_list[facet_name] = [this.value]
          var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
          if(singleton == true){
            var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
            if(fil_index == -1){
              if(fil_grp_index == -1)
                filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
              else{
                filter_tags_list.splice(fil_grp_index, 1);
                filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
              }
            }
          }
          else{
            if(fil_index == -1)
              filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
          }
          call_ajax = true;
        }

      }
      else{
        console.log("else==")
        if(facet_list.hasOwnProperty(facet_name)){
          console.log("hasproperty=="+this.value+"====="+facet_list[facet_name].indexOf(this.value))
          console.log(facet_list[facet_name])
          if(facet_list[facet_name].indexOf(this.value) > -1){
            console.log("len=="+facet_list[facet_name].length)
            if(facet_list[facet_name].length == 1){
              delete facet_list[facet_name];
              call_ajax = true;
            }
            else{
                var index = facet_list[facet_name].indexOf(this.value);
                if (index !== -1) facet_list[facet_name].splice(index, 1);
                call_ajax = true;
              }
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              filter_tags_list.splice(fil_index, 1);
            }
        }
      }
      console.log(facet_list);


      var url = constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc);
      var data = JSON.stringify({"search_object":facet_list,"listurl":url})
      if(call_ajax == true){
        console.log("filter_tags_list===")
        console.log(filter_tags_list)
        var filtersource   = document.getElementById("filter-tags-template").innerHTML;
        var filtertemplate = Handlebars.compile(filtersource);
        var filtercontext = {};
        filtercontext["filter_tags_list"] = filter_tags_list;
        console.log("filter tags====")
        console.log(filtercontext)
        var filterhtml    = filtertemplate(filtercontext);
        document.getElementById("filter-tags-template-content").innerHTML = filterhtml;

        $.ajax({
        method: "POST",
        url: "/api/rest/v1/product-list",
        data: data,
        dataType: "json",
        contentType: "application/json"
      })
        .done(function( response ) {
          // alert( "Data Saved: " + msg );
          console.log(response);
          var header_context = {};
          $.each(response, function(key,values){
              if(key == "filters"){
                var values_arr = $.map(values, function(el) { return el });
                values_arr.sort(function(obj1, obj2) {
                  // Ascending: first age less than the previous
                  return obj1.order - obj2.order;
                });
                $.each(values, function(vkey,vval){
                  console.log(vval)
                  var templateval = vval.template
                  console.log("template=="+template)
                 var source   = document.getElementById("filter-"+templateval+"-template").innerHTML;
                 var template = Handlebars.compile(source);
                 var singleton = vval.is_singleton;
                 var collapsed = vval.is_collapsed;
                 var filter_display_name = vval.header.display_name;
                 var filter_facet_name = vval.header.facet_name;
                 var context = {};
                 context["singleton"] = singleton;
                 context["collapsed"] = collapsed;
                 context["filter_display_name"] = filter_display_name;
                 context["filter_facet_name"] = filter_facet_name;
                 var items = $.map(vval.items, function(el) { return el });
                 items.sort(function(obj1, obj2) {
                  // Ascending: first age less than the previous
                  return obj1.sequence - obj2.sequence;
                });
                 context["items"] = items;
                 console.log(context)
                 var html    = template(context);
                 console.log(document.getElementById("filter-"+templateval+"-template-content"))
                 document.getElementById("filter-"+templateval+"-template-content").innerHTML = html;
               });
              }
              if(key == "breadcrumbs"){
                 header_context.breadcrumbs = values ;
              }
              if(key == "headers"){
                header_context.headers = values ;
              }
              if(key == "items"){
                   var source   = document.getElementById("products-list-template").innerHTML;
        				   var template = Handlebars.compile(source);
        				   Handlebars.registerHelper('assign', function (varName, varValue, options) {
        						    if (!options.data.root) {
        						        options.data.root = {};
        						    }
        						    options.data.root[varName] = varValue;
        						});
                    Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
                        return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
                    });
                     Handlebars.registerHelper('ifImagesExist', function(arg1, options) {
                        console.log(arg1)
                        var count = Object.keys(arg1).length;
                        return (count > 0) ? options.fn(this) : options.inverse(this);
                    });
        				   var context = {};
        				   context["products"] = values;
        				   console.log(context)
        				   var html    = template(context);
        				   document.getElementById("products-list-template-content").innerHTML = html;
        		}
          });

          var source   = document.getElementById("filter-header-template").innerHTML;
          var template = Handlebars.compile(source);
          var context = {};
          context["breadcrumbs"] = header_context.breadcrumbs ;
          context["headers"] = header_context.headers ;
          var html    = template(context);
          document.getElementById("filter-header-template-content").innerHTML = html;

          console.log(config_facet_names_arr);
          console.log(facet_list)

          window.history.replaceState('categoryPage', 'Category', url);
        });
      }

  });
     $( "input[name='age']" ).trigger( "change" );
      $( "input[name='gender']" ).trigger( "change" );
      $( "input[name='category']" ).trigger( "change" );
      $( "input[name='subtype']" ).trigger( "change" );

      function constructCategoryUrl(facet_names_arr,search_object,facet_value_slug_arr){
        var search_str = "";
        for(item in facet_names_arr){
          var search_cat = "";
          console.log("item--"+facet_names_arr[item])
          var itemval = facet_names_arr[item]
          console.log(search_object)
          console.log(search_object[itemval])
          if(itemval in search_object){
            if(search_object[facet_names_arr[item]].length>1){
              var furl =[]
              for(fitem in search_object[facet_names_arr[item]]){
                furl.push(facet_value_slug_arr[facet_names_arr[item]][search_object[facet_names_arr[item]][fitem]])
              }
              search_cat = furl.join('--');
              search_str += '/'+search_cat;
            }
            else{
              search_cat = search_object[facet_names_arr[item]][0];
              search_str += '/'+facet_value_slug_arr[facet_names_arr[item]][search_cat];
            }

          }


        }
        return search_str;
      }

      function removeFilterTag(slug){
        var elm = $("input[data-slug='"+slug+"'].facet-category")
        var singleton = elm.data("singleton")
        // if(singleton == true)
        elm.removeAttr("checked")
        console.log(elm)
        console.log("single==="+slug)
        elm.trigger( "change" );

      }


  </script>


@stop