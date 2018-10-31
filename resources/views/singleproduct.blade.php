@extends('layouts.default')

@section('headjs')

 <style type="text/css">
	.hamburger{padding:15px;display:inline-block;font:inherit;color:inherit;text-transform:none;background-color:transparent;border:0;margin:0;overflow:visible}.hamburger-box{width:40px;height:24px;display:inline-block;position:relative}.hamburger-inner,.hamburger-inner::after,.hamburger-inner::before{width:40px;height:4px;background-color:#000;border-radius:4px;position:absolute;display:block}.hamburger-inner{top:50%;margin-top:-2px}.hamburger-inner::after,.hamburger-inner::before{content:""}.hamburger-inner::before{top:-10px}.hamburger-inner::after{bottom:-10px}.hamburger--collapse .hamburger-inner{top:auto;bottom:0}.hamburger--collapse .hamburger-inner::after{top:-20px}:root{--blue:#007bff;--indigo:#6610f2;--purple:#6f42c1;--pink:#e83e8c;--red:#dc3545;--orange:#fd7e14;--yellow:#ffc107;--green:#28a745;--teal:#20c997;--cyan:#17a2b8;--white:#fff;--gray:#6c757d;--gray-dark:#343a40;--primary:#f9bc23;--secondary:#004283;--success:#28a745;--info:#17a2b8;--warning:#ffc107;--danger:#ad110a;--light:#e4e4e4;--dark:#707279;--cancel:#4b4b4b;--breakpoint-xs:0;--breakpoint-sm:576px;--breakpoint-md:768px;--breakpoint-lg:992px;--breakpoint-xl:1200px;--font-family-sans-serif:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";--font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar}@-ms-viewport{width:device-width}nav{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:.85rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;font-family:'Open Sans',sans-serif}hr{margin-bottom:1rem}hr{box-sizing:content-box;height:0;overflow:visible;margin-top:1rem;border:0;border-top:1px solid rgba(0,0,0,.1)}dl,h1,h3,h4,ol,p,ul{margin-top:0}dl,ol,p,ul{margin-bottom:1rem}ul ul{margin-bottom:0}dt{font-weight:700}dd{margin-bottom:.5rem;margin-left:0}a{color:#f9bc23;background-color:transparent;-webkit-text-decoration-skip:objects;text-decoration:none!important}img{vertical-align:middle;border-style:none;opacity:1}label{display:inline-block;margin-bottom:.5rem;font-weight:600}button{border-radius:0}button,input{margin:0}button,input{font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.h1,h1,h3,h4{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}.h1,h1{font-size:2.125rem}h3{font-size:1.4875rem}h4{font-size:1.275rem}.list-inline,.list-unstyled{padding-left:0;list-style:none}.list-inline-item{display:inline-block}.list-inline-item:not(:last-child){margin-right:.5rem}.img-fluid{max-width:100%;height:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:1200px){.container{max-width:1200px}}.row{display:flex;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.col-10,.col-12,.col-2,.col-6{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col-lg-3,.col-lg-5,.col-lg-7,.col-md-12,.col-md-6,.col-sm-12{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col-2{flex:0 0 16.66667%;max-width:16.66667%}.col-6{flex:0 0 50%;max-width:50%}.col-10{flex:0 0 83.33333%;max-width:83.33333%}.col-12{flex:0 0 100%;max-width:100%}.order-2{order:2}@media (min-width:576px){.col-sm-12{flex:0 0 100%;max-width:100%}.order-sm-1{order:1}}@media (min-width:768px){.col-md-6{flex:0 0 50%;max-width:50%}.col-md-12{flex:0 0 100%;max-width:100%}}@media (min-width:992px){.col-lg-3{flex:0 0 25%;max-width:25%}.col-lg-5{flex:0 0 41.66667%;max-width:41.66667%}.col-lg-7{flex:0 0 58.33333%;max-width:58.33333%}}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;border:1px solid transparent;padding:.375rem .75rem;font-size:.85rem;line-height:1.5;border-radius:.25rem}.btn:disabled{opacity:.65}.btn-primary{color:#212529;background-color:#f9bc23;border-color:#f9bc23}.btn-primary:disabled{color:#212529;background-color:#f9bc23;border-color:#f9bc23}.btn-link{background-color:transparent}.btn-link{font-weight:400;color:#f9bc23}.btn-lg{padding:.5rem 1rem;font-size:.9rem;line-height:2;border-radius:.2rem}.btn-block{display:block;width:100%}.collapse:not(.show){display:none}.center img{width:100%}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;padding:.5rem 1rem}.navbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between}.navbar-nav{display:flex;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{flex-basis:100%;flex-grow:1;align-items:center}.navbar-toggler{font-size:.9rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}@media (min-width:992px){.navbar-expand-lg{flex-flow:row nowrap;justify-content:flex-start}.navbar-expand-lg .navbar-nav{flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem}.navbar-expand-lg .navbar-collapse{display:flex!important;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.card{position:relative;display:flex;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.25rem}.card>.list-group:last-child .list-group-item:last-child{border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.card-body{flex:1 1 auto;padding:1.25rem}.card-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,.03);border-bottom:1px solid rgba(0,0,0,.125)}.card-header:first-child{border-radius:calc(.25rem - 1px) calc(.25rem - 1px) 0 0}.card-header+.list-group .list-group-item:first-child{border-top:0}.card-img-top{width:100%;border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.breadcrumb{display:flex;list-style:none;border-radius:.25rem}.breadcrumb{flex-wrap:wrap;padding:.75rem 1rem;margin-bottom:1rem;background-color:#e9ecef}.breadcrumb-item+.breadcrumb-item{padding-left:.5rem}.breadcrumb-item+.breadcrumb-item::before{display:inline-block;padding-right:.5rem;color:#6c757d;content:"/"}.badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem}.badge-light{color:#212529;background-color:#e4e4e4}.alert{position:relative;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid transparent;border-radius:.25rem}.alert-light{color:#777;background-color:#fafafa;border-color:#f7f7f7}.list-group{display:flex;flex-direction:column;padding-left:0;margin-bottom:0}.list-group-item{position:relative;display:block;padding:.75rem 1.25rem;margin-bottom:-1px;background-color:#fff;border:1px solid rgba(0,0,0,.125)}.list-group-item:first-child{border-top-left-radius:.25rem;border-top-right-radius:.25rem}.list-group-item:last-child{margin-bottom:0;border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.list-group-flush .list-group-item{border-right:0;border-left:0;border-radius:0}.list-group-flush:last-child .list-group-item:last-child{border-bottom:0}.close{float:right;font-size:1.275rem;font-weight:700;line-height:1;color:#000;text-shadow:0 1px 0 #fff;opacity:.5}button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}.product-color.checked input+label{opacity:1}.align-middle{vertical-align:middle!important}.bg-transparent{background-color:transparent!important}.border-bottom{border-bottom:1px solid #dee2e6!important}.d-none{display:none!important}.d-block{display:block!important}.d-flex{display:flex!important}.d-inline-flex{display:inline-flex!important}@media (min-width:576px){.d-sm-block{display:block!important}}@media (min-width:768px){.d-md-none{display:none!important}.d-md-block{display:block!important}}.flex-wrap{flex-wrap:wrap!important}.justify-content-center{justify-content:center!important}.justify-content-between{justify-content:space-between!important}.align-items-center{align-items:center!important}.align-items-baseline{align-items:baseline!important}.position-relative{position:relative!important}.position-absolute{position:absolute!important}.w-100{width:100%!important}.h-100{height:100%!important}.m-0{margin:0!important}.mt-0{margin-top:0!important}.mb-0{margin-bottom:0!important}.mb-1{margin-bottom:.25rem!important}.mt-2,.my-2{margin-top:.5rem!important}.mx-2{margin-right:.5rem!important}.mb-2,.my-2{margin-bottom:.5rem!important}.mx-2{margin-left:.5rem!important}.mt-3{margin-top:1rem!important}.mb-3{margin-bottom:1rem!important}.mt-4,.my-4{margin-top:1.5rem!important}.mb-4,.my-4{margin-bottom:1.5rem!important}.ml-4{margin-left:1.5rem!important}.mt-5{margin-top:3rem!important}.p-0{padding:0!important}.pt-0{padding-top:0!important}.pr-0,.px-0{padding-right:0!important}.pb-0{padding-bottom:0!important}.px-0{padding-left:0!important}.pr-1,.px-1{padding-right:.25rem!important}.pl-1,.px-1{padding-left:.25rem!important}.pr-2{padding-right:.5rem!important}.pb-2{padding-bottom:.5rem!important}.pl-2{padding-left:.5rem!important}.pt-3,.py-3{padding-top:1rem!important}.px-3{padding-right:1rem!important}.py-3{padding-bottom:1rem!important}.px-3{padding-left:1rem!important}.mr-auto{margin-right:auto!important}@media (min-width:576px){.mb-sm-2{margin-bottom:.5rem!important}.pr-sm-0{padding-right:0!important}.pl-sm-0{padding-left:0!important}.pr-sm-3{padding-right:1rem!important}.py-sm-4{padding-top:1.5rem!important}.px-sm-4{padding-right:1.5rem!important}.py-sm-4{padding-bottom:1.5rem!important}.px-sm-4{padding-left:1.5rem!important}}@media (min-width:768px){.m-md-2{margin:.5rem!important}.mt-md-4{margin-top:1.5rem!important}}@media (min-width:992px){.mt-lg-0,.my-lg-0{margin-top:0!important}.my-lg-0{margin-bottom:0!important}}.text-left{text-align:left!important}.font-weight-bold{font-weight:700!important}.text-white{color:#fff!important}.text-body{color:#212529!important}.text-muted{color:#6c757d!important}.btn-lg{font-weight:700}@media (min-width:360px) and (max-width:767.98px){.mobile-fixed{position:fixed;left:0;bottom:0;z-index:11;visibility:hidden;box-shadow:2px 1px 11px #464646;padding:10px;-webkit-transform:translateY(63px);transform:translateY(63px);background-color:#fff}}.radio-label{display:inline-block;padding:1em 2em;margin:0;border:2px solid #dee2e6}.radio-input:checked+.radio-label{border-color:#f9bc23;color:#e3a406}.radio-input:disabled+.radio-label{background-color:#e9ecef;opacity:.4}.radio-wrap.w-image .radio-label{padding:0;width:54px}.radio-wrap.kss_variants .radio-label{border:2px solid transparent}.radio-wrap.kss_variants .radio-input:checked+.radio-label{color:#777}.radio-wrap.kss_variants .radio-input:checked+.radio-label img{box-shadow:0 0 0 2px #f9bc23}.radio-wrap.wo-image .radio-label{min-width:100px;padding:10px;text-align:center}@media (min-width:320px) and (max-width:767.98px){.radio-wrap{overflow:scroll}}.radio-wrap label{margin:0 10px 0 0}.radio-wrap label div{text-align:center}.kss_sizes{display:block!important}.kss_sizes .radio-option{font-weight:400}@media (min-width:320px) and (max-width:767.98px){.kss_sizes{overflow:hidden;overflow-x:scroll;display:flex!important}}.kss_sizes label{display:inline-block;margin-bottom:7px!important}@media (min-width:768px) and (max-width:991.98px){.kss_sizes{overflow:hidden;overflow-x:scroll;display:flex!important}}@media (max-width:575.98px){#card-list{padding:10px}}#card-list .product-card{overflow:hidden}.card.product-card{border:0}@media (min-width:320px) and (max-width:767.98px){.card.product-card{background:0 0}}.card.product-card .card-img-top{border-radius:5px}@media (min-width:320px) and (max-width:767.98px){body{font-size:80%}}.f-w-4{font-weight:400}@media (max-width:575.98px){label{font-size:.8rem}}@media (min-width:320px) and (max-width:767.98px){label{font-size:.8rem!important}}.text-black{color:#000}.kss-title{font-size:1.1rem}@media (max-width:575.98px){.kss-title{font-size:.9rem;width:80%}}.kss-price{font-size:1.3rem;font-weight:700}@media (max-width:575.98px){.kss-price{font-size:1.4rem}}.breadcrumb-item a{color:#999;font-size:12px}.product-collapse{position:relative}.product-collapse .btn-link{position:relative;text-decoration:none}.product-collapse .btn-link:after{font-family:"Font Awesome 5 Free";font-weight:900;content:"\f078";position:absolute;right:0;top:17px;color:#495057;transform:rotate(180deg)}.product-collapse .btn-link.collapsed:after{transform:rotate(0deg)}.product-collapse .collapse-head{margin-bottom:15px}.product-collapse .collapse-head button{outline:none}.text-gray{color:#495057}.btn{position:relative}.kss-link{color:#212529;font-size:.9rem;margin-bottom:10px;text-decoration:none!important}.br-0{border:0;background:0 0!important}.icon-md{font-size:1.2em}.kss_icon{width:30px;height:33px;display:inline-block;margin-bottom:-4px}.kss_icon{background:url(../img/sprite.png) no-repeat}.search-icon{background-position:-6px -138px}.profile-icon{background-position:-107px -138px}.bag-icon{background-position:-501px -275px}.top-icon{background:url(../img/sprite.png) no-repeat;width:50px;height:50px;background-position:-223px -119px}.go-top{position:fixed;bottom:2em;right:2em;text-decoration:none;text-align:center;font-size:12px;display:none;padding:1em;z-index:1}@media (min-width:320px) and (max-width:767.98px){.go-top{bottom:5em;right:0;display:none!important}}.kss-alert{border-radius:0;width:300px;color:#fff}@media (min-width:768px){.kss-alert{width:350px}.kss-alert .icon{font-size:1.2em}.kss-alert .message{font-size:1.15em}}.kss-alert .close{position:absolute;right:5px;top:5px;text-shadow:none;color:#fff;opacity:1;outline:0}.kss-alert.sticky-alert{position:fixed;bottom:6.5em;z-index:10;left:0;transform:translateX(-500px)}@media (max-width:768px){.kss-alert.sticky-alert{bottom:4em}}.blur-up{-webkit-filter:blur(5px);filter:blur(5px)}label{font-size:.9rem}.product-color{margin:0;text-align:left}.product-color--single{transform:scale(.7);z-index:1}.product-color--single li input:checked+label:after{font-size:1.25em;top:38%}.product-color.checked input+label:after{content:"\2713";opacity:1;font-size:1.25em;top:40%}.product-color{list-style:none}.product-color li{display:inline-block;position:relative;overflow:hidden;margin:0 1px}.product-color li input{position:absolute;left:0;top:-300%;opacity:0;visibility:hidden}.colorOptions .product-color input:checked+label,.product-color li input:checked+label{opacity:1}.product-color li input:checked+label:after{content:"\2713";opacity:1}.product-color li label{width:36px;height:26px;line-height:26px;display:inline-block;position:relative;border:1px solid #8e8e8e;color:#e4e4e4;text-align:center;opacity:.5;box-sizing:border-box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box}.product-color li label:after{content:"\2713";position:absolute;left:50%;margin-left:-7px;top:50%;margin-top:-7px;font:14px FontAwesome;opacity:0}.overlay-fix{width:100%;height:100vh;background:rgba(0,0,0,.34);position:fixed;top:58px;z-index:99}@media (min-width:320px) and (max-width:767.98px){.overlay-fix{top:74px}}.recent-search{position:absolute;right:7%;top:58px;z-index:9999}@media (min-width:320px) and (max-width:767.98px){.recent-search{right:0;width:100%!important;top:140px}}.search-input{position:absolute;right:7%;top:8px;z-index:9999;background-color:#707279}@media (min-width:320px) and (max-width:767.98px){.search-input span{color:#000!important;position:absolute;bottom:0}}.search-input input{width:100%;height:40px;background:0;color:#fff;border:0;border-bottom:1px solid #cccc}@media (min-width:320px) and (max-width:767.98px){.search-input input{color:#000}}@media (min-width:320px) and (max-width:767.98px){.search-input{position:absolute;top:75px;height:54px;left:0;z-index:999;background:#fff;width:100%!important}.search-input input{width:90%;height:54px;padding-left:5px;outline:none}}.hide-search{position:absolute;right:5px;top:4px;z-index:2}.swipe-arrow{position:absolute;z-index:999;right:20px;top:40%;width:20%!important;visibility:hidden}.header{background-color:#707279}.header a{color:#fff}.recent-search a{color:#000!important}.navbar-toggler{padding:.15rem .45rem}.cart-counter{position:absolute;top:30px;right:-2px}.hamburger-inner,.hamburger-inner::after,.hamburger-inner::before{width:22px;height:2px;background-color:#fff}.hamburger-inner::before{top:-7px}.hamburger--collapse .hamburger-inner::after{top:-14px}.hamburger-box{width:22px;height:18px}@media (min-width:360px) and (max-width:767.98px){.kss-logo{position:absolute;left:40px;top:24px}}@media (max-width:320px){.header ul .list-inline-item{margin-right:.1rem}.header img{width:144px;position:absolute;left:40px;top:26px}}#cd-cart{position:fixed;top:0;height:100%;width:80%;padding-top:10px;overflow-y:auto;overflow-x:hidden;-webkit-overflow-scrolling:touch;box-shadow:0 0 20px rgba(0,0,0,.2);z-index:9999}@media only screen and (min-width:768px){#cd-cart{width:400px}}@media (min-width:360px) and (max-width:767.98px){#cd-cart{width:100%;padding-bottom:68px}}@media (min-width:992px) and (min-width:1199.98px){#cd-cart{width:40%!important}}@media (min-width:1300px){#cd-cart{width:30%!important}}#cd-cart{right:-100%;background:#fff}#cd-cart>*{padding:0 1em}@media only screen and (min-width:1200px){#cd-cart>*{padding:0 1.5em}}#cd-shadow-layer{position:fixed;min-height:100%;width:100%;top:0;left:0;background:rgba(173,181,189,.6);z-index:99;display:none}@media (min-width:360px) and (max-width:767.98px){#cd-shadow-layer{display:none!important}}.colorOptions .product-color label{opacity:1}.cart-loader:after{content:'';position:absolute;width:100%;height:100%;top:0;left:0;background:rgba(255,255,255,.83) url(../img/loader_818e.gif) center center no-repeat;z-index:99999}.prod-slides{height:530px;overflow:hidden}@media (max-width:767px){.prod-slides{height:130vw}}@media only screen and (min-width:768px){.prod-slides{height:450px}}.loader{background:#fff url(../img/loader_818e.gif) center center no-repeat;width:100%;position:absolute;z-index:999;height:100%}.prod-slides li{opacity:0}.center{overflow:overlay}@-webkit-keyframes scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}to{-webkit-transform:scale(1);transform:scale(1);opacity:0}}@keyframes scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}to{-webkit-transform:scale(1);transform:scale(1);opacity:0}}.image{position:relative;background:linear-gradient(#f2f2f2 66%,rgba(242,242,242,0))}.image{margin-bottom:10px;padding-bottom:166.666666667%}.image img,.loading:before{position:absolute;top:0;left:0;width:100%;height:100%}.loading:before{content:"";z-index:1;top:50%;left:50%;margin-top:-16px;margin-left:-16px;width:32px;height:32px;border-radius:32px;-webkit-animation:scaleout 1.2s infinite ease-in-out;animation:scaleout 1.2s infinite ease-in-out;mix-blend-mode:soft-light;background-color:rgba(0,0,0,.9)}.image,.lazyload,.loading{opacity:1}.color-custom-radio{top:-5px;right:-8px}.colorOptions__trigger .down-arrow{transform:rotate(180deg)}.colorOptions__trigger.collapsed .down-arrow{transform:rotate(0deg)}.variant-img-wrapper{height:84px}.variant-img-wrapper img{height:100%;width:100%;object-fit:cover}.variant-placeholder img{background-color:#dadada;padding:0 5px;object-fit:contain}
 </style>

@stop

@section('content')

	<div class="container mt-0 mt-md-4">
		<div class="row">
			<div class="col-sm-12 col-lg-7">
				<!-- Product Images -->
				@include('includes.singleproduct.productimages', ['params' => $params])

				@php $selected_color_id = $params['selected_color_id']; @endphp

				<!-- Product Color-selection Section -->
				@include('includes.singleproduct.productcolorselection', ['params' => $params, 'selected_color_id' => $selected_color_id])
			</div>
			<div class="col-sm-12 col-lg-5">
				<!-- Breadcrumbs -->
				@include('includes.breadcrumbs', ['params' => $params])

				<!-- Product Title & Prices Section -->
				@include('includes.singleproduct.producttitle', ['params' => $params, 'selected_color_id' => $selected_color_id])

				<hr>





				<div class="d-flex justify-content-between mt-4">
					<label class="">Select Size (Age Group)</label>
					<!-- Product Size Chart -->
					<!-- <a href="#sizeModal" class="font-weight-bold kss-link" data-toggle="modal" data-target="#sizeModal">Size Chart</a>

					<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					    <div class="modal-content">
					    	<div class="modal-header">
				    	        <h5 class="modal-title ml-auto">Size Chart</h5>
				    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				    	          <span aria-hidden="true">&times;</span>
				    	        </button>
					    	</div>
					      	<div class="modal-body">
					      		<img src="/img/size_chart.png" class="img-fluid">
					      	</div>
					    </div>
					  </div>
					</div> -->

				</div>
				<!-- Product Size Selection -->
				@include('includes.singleproduct.productsizes', ['params' => $params, 'selected_color_id' => $selected_color_id])

				<div class="row">

					<div class="col-sm-12 col-md-12 col-12 mobile-fixed pb-2 add-bag-btn">

						<!-- <div class="row"> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pr-1">
								<button class="btn btn-outline-secondary btn-lg btn-block">
									<div class="btn-label-initial"><i class="far fa-heart"></i> Save to Wishlist</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Cart</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							</div> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pl-1"> -->
								<button id="cd-add-to-cart" class="btn btn-primary btn-lg btn-block cd-add-to-cart" disabled>
									<div class="btn-label-initial d-flex align-items-center justify-content-center">Select Size</div>
								</button>
							<!-- </div> -->
						<!-- </div> -->
					</div>
				</div>

				<!-- <div class="alert alert-light my-4">
					<div class="d-flex justify-content-between">
						 <label class="text-body">
					 	<i class="fas fa-truck"></i> Check Delivery Options
					 	</label>
						<a class="font-weight-bold kss-link" data-toggle="collapse" href="#kss_pincode" role="button" aria-expanded="false" aria-controls="collapseExample">Add Pincode</a>
					</div>
					<div class="collapse mb-2 mt-4" id="kss_pincode">
					  	<form class="form-inline">
						   	<div class="form-group m-0 w-70">
                           		<input class="form-control form-control-lg" id="city" type="number">
                            	<label class="control-label">Check Pincode</label>
	                      	</div>
						  	<button type="submit" class="btn btn-primary mb-2 mt-2">Check</button>
						</form>
						<h6 class="text-dark mt-2 font-weight-bold">Delivery by 30 Aug, Thursday</h6>
						<br>
					</div>
				 	<p class="text-muted">Tax: Applicable tax on the basis of exact location & discount will be charged at the time of checkout</p>
				</div> -->

				<!-- Details / Additional info / Reviews -->
				@include('includes.singleproduct.productdetails', ['params' => $params])

			</div>
		</div>
	</div>


	<div id="similar" class="container">
		<hr class="mt-5">
		<h3 class="text-left my-4 font-weight-bold">Similar Products</h3>
	  <div id="card-list" class="row">
            <div class="col-lg-3 col-md-6 mb-4 col-6  ">
              <div class="card h-100 product-card">
              	<!-- <i class="fas fa-heart kss_heart"></i> -->
                <a href="#" >
                  <div class="image oh loading loading-01">
                  	<img src="/img/10px/blue-tshirt-10px.jpg" data-srcset="/img/1x/blue-tshirt@1x.jpg 270w, /img/2x/blue-tshirt@2x.jpg 540w, /img/3x/blue-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" />
                 </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
                  </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 col-6  ">
           	  <div class="card h-100 product-card">
           	 		<!-- <i class="fas fa-heart kss_heart"></i> -->
                <a href="#">
                   <div class="image oh loading loading-02">
                  <img src="/img/10px/orange-tshirt-10px.jpg" data-srcset="/img/1x/orange-tshirt@1x.jpg 270w, /img/2x/orange-tshirt@2x.jpg 540w, /img/3x/orange-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" />
                </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
                  </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 col-6   ">
              <div class="card h-100 product-card">
              	<!-- <i class="fas fa-heart kss_heart"></i> -->
                <a href="#">
                   <div class="image oh loading loading-03">
                        <img src="/img/10px/red-tshirt-10px.jpg" data-srcset="/img/1x/red-tshirt@1x.jpg 270w, /img/2x/red-tshirt@2x.jpg 540w, /img/3x/red-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" />
                    </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
                  </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>
                <div class="col-lg-3 col-md-6 mb-4 col-6 ">
              <div class="card h-100 product-card">
               <!--  <i class="fas fa-heart kss_heart"></i> -->
                <a href="#">
                	<div class="image oh loading loading-04">
                		<img src="/img/10px/mix-tshirt-10px.jpg" data-srcset="/img/1x/mix-tshirt@1x.jpg 270w, /img/2x/mix-tshirt@2x.jpg 540w, /img/3x/mix-tshirt@3x.jpg 978w" class="lazyload card-img-top blur-up" sizes="(min-width: 992px) 25vw,50vw" />
                 	</div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
             	    </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>
        </div>
	</div>

	<div class="alert kss-alert sticky-alert d-inline-flex align-items-baseline px-sm-4 py-sm-4 px-3 py-3 fade show" role="alert">
	  <i class="fas fa-check pr-sm-3 pr-2 icon"></i>
	  <div class="message"></div>
	  <button type="button" class="close" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>

@stop

@section('footjs')

	<script type="text/javascript">
	    window.variants = @php echo json_encode($params['variant_group']); @endphp
	</script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
	<script type="text/javascript" src="/js/singleproduct.js"></script>

@stop