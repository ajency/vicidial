@extends('layouts.default')

@php
  if ($gendername == 'boys') {
  	$title = 'Boys';
  	$years = '2 - 7 Years';
  	$box_1_alt= 'Shirts';
  	$box_1_title= 'Shirts';
  	$box_2_alt= 'T-Shirts';
  	$box_2_title= 'T-Shirts';
  	$box_3_alt= 'Ethnic';
  	$box_3_title= 'Ethnic';
  	$box_4_alt= 'Bottoms';
  	$box_4_title= 'Bottoms';
  	$box_5_alt= 'Shorts';
  	$box_5_title= 'Shorts';
  	$box_6_alt= 'Shoes';
  	$box_6_title= 'Shoes';
  } else if ($gendername == 'girls') {
  	$title = 'Girls';
  	$years = '2 - 7 Years';
  	$box_1_alt= 'Dresses';
  	$box_1_title= 'Dresses';
  	$box_2_alt= 'T-Shirts';
  	$box_2_title= 'T-Shirts';
  	$box_3_alt= 'Woven Tops';
  	$box_3_title= 'Woven Tops';
  	$box_4_alt= 'Ethnic';
  	$box_4_title= 'Ethnic';
  	$box_5_alt= 'Denim';
  	$box_5_title= 'Denim';
  	$box_6_alt= 'Bottoms';
  	$box_6_title= 'Bottoms';
  	$box_7_alt= 'Shorts';
  	$box_7_title= 'Shorts';
  	$box_8_alt= 'Shoes';
  	$box_8_title= 'Shoes';
  }
  else{
	$title = 'Infants';
	$years = '0 - 2 Years';
	$box_1_alt= 'Dresses';
  	$box_1_title= 'Dresses';
  	$box_2_alt= 'T-Shirts';
  	$box_2_title= 'T-Shirts';
  	$box_3_alt= 'Bottoms';
  	$box_3_title= 'Bottoms';
  	$box_4_alt= 'Utility';
  	$box_4_title= 'Utility';
  	$box_5_alt= 'Shoes';
  	$box_5_title= 'Shoes';
  	$box_6_alt= '';
  	$box_6_title= '';
  }
@endphp


@section('headjs')

@stop

@section('content')


<div class="container sublanding-container pt-md-4">
   <!-- Breadcrumbs -->
   <div class="row d-none d-md-block">
      <div class="col-12">
         <div class="mb-4">
            @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
         </div>
      </div>
   </div>
   <div class="row">
   	<div class="col-12 gender m-heading text-center">
   		<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach"><span>{{$title}}</span></h3>
		<p class="gender__years text-dark m-detach d-md-none">{{$years}}</p>
   	</div>
   </div>
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box_1_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box_1_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box_1_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_1_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_1_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_1_small.jpg') }} 512w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_1_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/infants/box_1_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/infants/box_1_small.jpg') }} 512w"
					@endif	                          
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box_1_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box_1_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box_1_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_1_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_1_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_1_portrait_small.jpg') }} 400w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_1_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/infants/box_1_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/infants/box_1_portrait_small.jpg') }} 400w"
					@endif
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box_1_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box_1_20px.jpg') }}"
		       	   @else
		       	   	src="{{CDN::asset('/img/gender/infants/box_1_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_1_alt}}" 
		           title="{{$box_1_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/indigo-solid-shirt-449-mid-wash/buy">
							<img src="https://www.kidsuperstore.in/images/products/37777/list-view/load/boys-shirt-1638-color-mid-wash-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37777/list-view/1x/boys-shirt-1638-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/37777/list-view/2x/boys-shirt-1638-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/37777/list-view/3x/boys-shirt-1638-color-mid-wash-1.jpg 810w" sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" title="Indigo solid shirt - Mid Wash" alt="Indigo solid shirt - Mid Wash" srcset="https://www.kidsuperstore.in/images/products/37777/list-view/1x/boys-shirt-1638-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/37777/list-view/2x/boys-shirt-1638-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/37777/list-view/3x/boys-shirt-1638-color-mid-wash-1.jpg 810w">

							<!-- <img src="/images/products/37777/list-view/load/boys-shirt-1638-color-mid-wash-1.jpg" 
							data-srcset="/images/products/37777/list-view/1x/boys-shirt-1638-color-mid-wash-1.jpg 270w, /images/products/37777/list-view/2x/boys-shirt-1638-color-mid-wash-1.jpg 540w, /images/products/37777/list-view/3x/boys-shirt-1638-color-mid-wash-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" 
							title="Indigo solid shirt - Mid Wash" 
							alt="Indigo solid shirt - Mid Wash"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/girls-silver-sequeince-embellished-halter-party-wear-dress-1655-green/buy">
							<img src="https://www.kidsuperstore.in/images/products/39636/list-view/load/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39636/list-view/1x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 270w, https://www.kidsuperstore.in/images/products/39636/list-view/2x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 540w, https://www.kidsuperstore.in/images/products/39636/list-view/3x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Girls Silver Sequeince Embellished Halter Party Wear Dress - Green" alt="Girls Silver Sequeince Embellished Halter Party Wear Dress - Green" srcset="https://www.kidsuperstore.in/images/products/39636/list-view/1x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 270w, https://www.kidsuperstore.in/images/products/39636/list-view/2x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 540w, https://www.kidsuperstore.in/images/products/39636/list-view/3x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 810w">

							<!-- <img src="/images/products/39636/list-view/load/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg" data-srcset="/images/products/39636/list-view/1x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 270w, /images/products/39636/list-view/2x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 540w, /images/products/39636/list-view/3x/tbdmy03-girls-silver-sequeince-embellished-halter-party-wear-dress-color-green-4.jpg 810w" data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Girls Silver Sequeince Embellished Halter Party Wear Dress - Green" 
							alt="Girls Silver Sequeince Embellished Halter Party Wear Dress - Green"> -->
						</a>
						@else
						<a href="/woven-cotton-dress-301-turquoise/buy">
							<img src="https://www.kidsuperstore.in/images/products/37603/list-view/load/dresses-1706-color-turquoise-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37603/list-view/1x/dresses-1706-color-turquoise-1.jpg 270w, https://www.kidsuperstore.in/images/products/37603/list-view/2x/dresses-1706-color-turquoise-1.jpg 540w, https://www.kidsuperstore.in/images/products/37603/list-view/3x/dresses-1706-color-turquoise-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Woven cotton dress - Turquoise" alt="Woven cotton dress - Turquoise" srcset="https://www.kidsuperstore.in/images/products/37603/list-view/1x/dresses-1706-color-turquoise-1.jpg 270w, https://www.kidsuperstore.in/images/products/37603/list-view/2x/dresses-1706-color-turquoise-1.jpg 540w, https://www.kidsuperstore.in/images/products/37603/list-view/3x/dresses-1706-color-turquoise-1.jpg 810w">

							<!-- <img src="/images/products/37603/list-view/load/dresses-1706-color-turquoise-1.jpg" data-srcset="/images/products/37603/list-view/1x/dresses-1706-color-turquoise-1.jpg 270w, /images/products/37603/list-view/2x/dresses-1706-color-turquoise-1.jpg 540w, /images/products/37603/list-view/3x/dresses-1706-color-turquoise-1.jpg 810w"
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Woven cotton dress - Turquoise" 
							alt="Woven cotton dress - Turquoise"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/half-sleeves-tropical-shirt-461-navy/buy">
							<img src="https://www.kidsuperstore.in/images/products/37828/list-view/load/boys-shirt-2003-color-navy-7.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37828/list-view/1x/boys-shirt-2003-color-navy-7.jpg 270w, https://www.kidsuperstore.in/images/products/37828/list-view/2x/boys-shirt-2003-color-navy-7.jpg 540w, https://www.kidsuperstore.in/images/products/37828/list-view/3x/boys-shirt-2003-color-navy-7.jpg 810w" sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" title="Half sleeves tropical  shirt - Navy" alt="Half sleeves tropical  shirt - Navy" srcset="https://www.kidsuperstore.in/images/products/37828/list-view/1x/boys-shirt-2003-color-navy-7.jpg 270w, https://www.kidsuperstore.in/images/products/37828/list-view/2x/boys-shirt-2003-color-navy-7.jpg 540w, https://www.kidsuperstore.in/images/products/37828/list-view/3x/boys-shirt-2003-color-navy-7.jpg 810w">
	<!-- 
							<img src="/images/products/37828/list-view/load/boys-shirt-2003-color-navy-7.jpg" data-srcset="/images/products/37828/list-view/1x/boys-shirt-2003-color-navy-7.jpg 270w, /images/products/37828/list-view/2x/boys-shirt-2003-color-navy-7.jpg 540w, /images/products/37828/list-view/3x/boys-shirt-2003-color-navy-7.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" 
							title="Half sleeves tropical  shirt - Navy" 
							alt="Half sleeves tropical  shirt - Navy"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/all-over-printed-dress-259-peach/buy">
							<img src="https://www.kidsuperstore.in/images/products/37502/list-view/load/dress-op01-color-peach-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37502/list-view/1x/dress-op01-color-peach-1.jpg 270w, https://www.kidsuperstore.in/images/products/37502/list-view/2x/dress-op01-color-peach-1.jpg 540w, https://www.kidsuperstore.in/images/products/37502/list-view/3x/dress-op01-color-peach-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="All over printed dress - Peach" alt="All over printed dress - Peach" srcset="https://www.kidsuperstore.in/images/products/37502/list-view/1x/dress-op01-color-peach-1.jpg 270w, https://www.kidsuperstore.in/images/products/37502/list-view/2x/dress-op01-color-peach-1.jpg 540w, https://www.kidsuperstore.in/images/products/37502/list-view/3x/dress-op01-color-peach-1.jpg 810w">

							<!-- <img src="/images/products/37502/list-view/load/dress-op01-color-peach-1.jpg" 
							data-srcset="/images/products/37502/list-view/1x/dress-op01-color-peach-1.jpg 270w, /images/products/37502/list-view/2x/dress-op01-color-peach-1.jpg 540w, /images/products/37502/list-view/3x/dress-op01-color-peach-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="All over printed dress - Peach" 
							alt="All over printed dress - Peach"> -->
						</a>
						@else
						<a href="/navy-cap-sleeve-sequin-drop-waist-dress-1921-navy/buy">
							<img src="https://www.kidsuperstore.in/images/products/36186/list-view/load/ssgi180902-pr-5044-color-navy-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36186/list-view/1x/ssgi180902-pr-5044-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/36186/list-view/2x/ssgi180902-pr-5044-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/36186/list-view/3x/ssgi180902-pr-5044-color-navy-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Navy Cap Sleeve Sequin Drop Waist Dress - Navy" alt="Navy Cap Sleeve Sequin Drop Waist Dress - Navy" srcset="https://www.kidsuperstore.in/images/products/36186/list-view/1x/ssgi180902-pr-5044-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/36186/list-view/2x/ssgi180902-pr-5044-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/36186/list-view/3x/ssgi180902-pr-5044-color-navy-1.jpg 810w">

							<!-- <img src="/images/products/36186/list-view/load/ssgi180902-pr-5044-color-navy-1.jpg" data-srcset="/images/products/36186/list-view/1x/ssgi180902-pr-5044-color-navy-1.jpg 270w, /images/products/36186/list-view/2x/ssgi180902-pr-5044-color-navy-1.jpg 540w, /images/products/36186/list-view/3x/ssgi180902-pr-5044-color-navy-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" 
							title="Navy Cap Sleeve Sequin Drop Waist Dress - Navy" 
							alt="Navy Cap Sleeve Sequin Drop Waist Dress - Navy"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/half-sleeves-cotton-shirt-256-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/37482/list-view/load/boys-shirt-op05-color-blue-4.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37482/list-view/1x/boys-shirt-op05-color-blue-4.jpg 270w, https://www.kidsuperstore.in/images/products/37482/list-view/2x/boys-shirt-op05-color-blue-4.jpg 540w, https://www.kidsuperstore.in/images/products/37482/list-view/3x/boys-shirt-op05-color-blue-4.jpg 810w" sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" title="Half sleeves cotton shirt - Blue" alt="Half sleeves cotton shirt - Blue" srcset="https://www.kidsuperstore.in/images/products/37482/list-view/1x/boys-shirt-op05-color-blue-4.jpg 270w, https://www.kidsuperstore.in/images/products/37482/list-view/2x/boys-shirt-op05-color-blue-4.jpg 540w, https://www.kidsuperstore.in/images/products/37482/list-view/3x/boys-shirt-op05-color-blue-4.jpg 810w">

							<!-- <img src="/images/products/37482/list-view/load/boys-shirt-op05-color-blue-4.jpg" data-srcset="/images/products/37482/list-view/1x/boys-shirt-op05-color-blue-4.jpg 270w, /images/products/37482/list-view/2x/boys-shirt-op05-color-blue-4.jpg 540w, /images/products/37482/list-view/3x/boys-shirt-op05-color-blue-4.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" class="card-img-top blur-up lazyloaded" 
							title="Half sleeves cotton shirt - Blue" 
							alt="Half sleeves cotton shirt - Blue"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/sleeveless-all-over-stripper-flared-dress-1972-white/buy">
							<img src="https://www.kidsuperstore.in/images/products/36292/list-view/load/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36292/list-view/1x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36292/list-view/2x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36292/list-view/3x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Sleeveless All over Stripper Flared Dress - White" alt="Sleeveless All over Stripper Flared Dress - White" srcset="https://www.kidsuperstore.in/images/products/36292/list-view/1x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36292/list-view/2x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36292/list-view/3x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 810w">

							<!-- <img src="/images/products/36292/list-view/load/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg" 
							data-srcset="/images/products/36292/list-view/1x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 270w, /images/products/36292/list-view/2x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 540w, /images/products/36292/list-view/3x/upgt180901-an-7012-sleeveless-all-over-printed-flared-dress-color-white-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Sleeveless All over Stripper Flared Dress - White" 
							alt="Sleeveless All over Stripper Flared Dress - White"> -->
						</a>
						@else
						<a href="/woven-printed-a-line-dress-939-pink/buy">
							<img src="https://www.kidsuperstore.in/images/products/38088/list-view/load/infant-dress-igdr003-color-pink-4.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38088/list-view/1x/infant-dress-igdr003-color-pink-4.jpg 270w, https://www.kidsuperstore.in/images/products/38088/list-view/2x/infant-dress-igdr003-color-pink-4.jpg 540w, https://www.kidsuperstore.in/images/products/38088/list-view/3x/infant-dress-igdr003-color-pink-4.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Woven printed A-line dress - Pink" alt="Woven printed A-line dress - Pink" srcset="https://www.kidsuperstore.in/images/products/38088/list-view/1x/infant-dress-igdr003-color-pink-4.jpg 270w, https://www.kidsuperstore.in/images/products/38088/list-view/2x/infant-dress-igdr003-color-pink-4.jpg 540w, https://www.kidsuperstore.in/images/products/38088/list-view/3x/infant-dress-igdr003-color-pink-4.jpg 810w">
<!-- 
							<img src="/images/products/38088/list-view/load/infant-dress-igdr003-color-pink-4.jpg" data-srcset="/images/products/38088/list-view/1x/infant-dress-igdr003-color-pink-4.jpg 270w, /images/products/38088/list-view/2x/infant-dress-igdr003-color-pink-4.jpg 540w, /images/products/38088/list-view/3x/infant-dress-igdr003-color-pink-4.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Woven printed A-line dress - Pink" 
							alt="Woven printed A-line dress - Pink"> -->
						</a>
						@endif
					</div>
				</div>	
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="/boys/toddler-2-7-years/shirt" class="btn kss-btn kss-btn--dark">Shop <strong>Shirts</strong></a>
				@elseif ($gendername == 'girls')
					<a href="/girls/toddler-2-7-years/dress" class="btn kss-btn kss-btn--dark">Shop <strong>Dresses</strong></a>
				@else
					<a href="/infant-0-2-years/dress/" class="btn kss-btn kss-btn--dark">Shop <strong>Dresses</strong></a>
				@endif	
			</div>
		</div>
	</div>
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box_2_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box_2_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box_2_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_2_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_2_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_2_small.jpg') }} 512w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_2_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/infants/box_2_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/infants/box_2_small.jpg') }} 512w"
					@endif	                          
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box_2_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box_2_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box_2_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_2_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_2_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_2_portrait_small.jpg') }} 400w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_2_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/infants/box_2_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/infants/box_2_portrait_small.jpg') }} 400w"
					@endif
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box_2_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box_2_20px.jpg') }}"
		       	   @else
		       	   	src="{{CDN::asset('/img/gender/infants/box_2_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_2_alt}}" 
		           title="{{$box_2_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/black-essential-graphic-tshirt-927-black/buy">
							<img src="https://www.kidsuperstore.in/images/products/38050/list-view/load/graphic-t-shirt-1550-color-black-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38050/list-view/1x/graphic-t-shirt-1550-color-black-1.jpg 270w, https://www.kidsuperstore.in/images/products/38050/list-view/2x/graphic-t-shirt-1550-color-black-1.jpg 540w, https://www.kidsuperstore.in/images/products/38050/list-view/3x/graphic-t-shirt-1550-color-black-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Black essential graphic tshirt - Black" alt="Black essential graphic tshirt - Black" srcset="https://www.kidsuperstore.in/images/products/38050/list-view/1x/graphic-t-shirt-1550-color-black-1.jpg 270w, https://www.kidsuperstore.in/images/products/38050/list-view/2x/graphic-t-shirt-1550-color-black-1.jpg 540w, https://www.kidsuperstore.in/images/products/38050/list-view/3x/graphic-t-shirt-1550-color-black-1.jpg 810w">

							<!-- <img src="/images/products/38050/list-view/load/graphic-t-shirt-1550-color-black-1.jpg"
							data-srcset="/images/products/38050/list-view/1x/graphic-t-shirt-1550-color-black-1.jpg 270w, /images/products/38050/list-view/2x/graphic-t-shirt-1550-color-black-1.jpg 540w, /images/products/38050/list-view/3x/graphic-t-shirt-1550-color-black-1.jpg 810w"
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded"
							title="Black essential graphic tshirt - Black" 
							alt="Black essential graphic tshirt - Black"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/half-sleeves-all-over-printed-t-shirt-2063-white/buy">
							<img src="https://www.kidsuperstore.in/images/products/36477/list-view/load/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36477/list-view/1x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36477/list-view/2x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36477/list-view/3x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Half Sleeves All over Printed T-Shirt - White" alt="Half Sleeves All over Printed T-Shirt - White" srcset="https://www.kidsuperstore.in/images/products/36477/list-view/1x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36477/list-view/2x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36477/list-view/3x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 810w">

							<!-- <img src="/images/products/36477/list-view/load/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg" 
							data-srcset="/images/products/36477/list-view/1x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 270w, /images/products/36477/list-view/2x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 540w, /images/products/36477/list-view/3x/upgj180902-co-4033-half-sleeves-all-over-printed-t-shirt-color-white-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Half Sleeves All over Printed T-Shirt - White" 
							alt="Half Sleeves All over Printed T-Shirt - White"> -->
						</a>
						@else
						<a href="/fashion-all-over-printed-polo-tshirt-2014-white/buy">
							<img src="https://www.kidsuperstore.in/images/products/36378/list-view/load/ssbi180902-pr-5081-color-white-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36378/list-view/1x/ssbi180902-pr-5081-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36378/list-view/2x/ssbi180902-pr-5081-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36378/list-view/3x/ssbi180902-pr-5081-color-white-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Fashion All Over Printed Polo Tshirt - White" alt="Fashion All Over Printed Polo Tshirt - White" srcset="https://www.kidsuperstore.in/images/products/36378/list-view/1x/ssbi180902-pr-5081-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36378/list-view/2x/ssbi180902-pr-5081-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36378/list-view/3x/ssbi180902-pr-5081-color-white-1.jpg 810w">

							<!-- <img src="/images/products/36378/list-view/load/ssbi180902-pr-5081-color-white-1.jpg" data-srcset="/images/products/36378/list-view/1x/ssbi180902-pr-5081-color-white-1.jpg 270w, /images/products/36378/list-view/2x/ssbi180902-pr-5081-color-white-1.jpg 540w, /images/products/36378/list-view/3x/ssbi180902-pr-5081-color-white-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Fashion All Over Printed Polo Tshirt - White" 
							alt="Fashion All Over Printed Polo Tshirt - White"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/half-sleeves-polo-t-shirt-252-tomato/buy">
							<img src="https://www.kidsuperstore.in/images/products/37430/list-view/load/boys-polo-t-shirt-op02-color-tomato-10.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37430/list-view/1x/boys-polo-t-shirt-op02-color-tomato-10.jpg 270w, https://www.kidsuperstore.in/images/products/37430/list-view/2x/boys-polo-t-shirt-op02-color-tomato-10.jpg 540w, https://www.kidsuperstore.in/images/products/37430/list-view/3x/boys-polo-t-shirt-op02-color-tomato-10.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Half sleeves polo t-shirt - Tomato" alt="Half sleeves polo t-shirt - Tomato" srcset="https://www.kidsuperstore.in/images/products/37430/list-view/1x/boys-polo-t-shirt-op02-color-tomato-10.jpg 270w, https://www.kidsuperstore.in/images/products/37430/list-view/2x/boys-polo-t-shirt-op02-color-tomato-10.jpg 540w, https://www.kidsuperstore.in/images/products/37430/list-view/3x/boys-polo-t-shirt-op02-color-tomato-10.jpg 810w">

							<!-- <img src="/images/products/37430/list-view/load/boys-polo-t-shirt-op02-color-tomato-10.jpg" 
							data-srcset="/images/products/37430/list-view/1x/boys-polo-t-shirt-op02-color-tomato-10.jpg 270w, /images/products/37430/list-view/2x/boys-polo-t-shirt-op02-color-tomato-10.jpg 540w, /images/products/37430/list-view/3x/boys-polo-t-shirt-op02-color-tomato-10.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Half sleeves polo t-shirt - Tomato" 
							alt="Half sleeves polo t-shirt - Tomato"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/all-over-printed-woven-girls-t-shirt-1502-green/buy">
							<img src="https://www.kidsuperstore.in/images/products/39251/list-view/load/jus-jc58tg058-fs-t-shirt-color-green-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39251/list-view/1x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 270w, https://www.kidsuperstore.in/images/products/39251/list-view/2x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 540w, https://www.kidsuperstore.in/images/products/39251/list-view/3x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="All over printed woven girls t-shirt - Green" alt="All over printed woven girls t-shirt - Green" srcset="https://www.kidsuperstore.in/images/products/39251/list-view/1x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 270w, https://www.kidsuperstore.in/images/products/39251/list-view/2x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 540w, https://www.kidsuperstore.in/images/products/39251/list-view/3x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 810w">

							<!-- <img src="/images/products/39251/list-view/load/jus-jc58tg058-fs-t-shirt-color-green-1.jpg" data-srcset="/images/products/39251/list-view/1x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 270w, /images/products/39251/list-view/2x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 540w, /images/products/39251/list-view/3x/jus-jc58tg058-fs-t-shirt-color-green-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="All over printed woven girls t-shirt - Green" 
							alt="All over printed woven girls t-shirt - Green"> -->
						</a>
						@else
						<a href="/circular-knit-boys-graphic-tshirt-1059-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/38310/list-view/load/infant-boys-t-shirt-3070-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38310/list-view/1x/infant-boys-t-shirt-3070-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/38310/list-view/2x/infant-boys-t-shirt-3070-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/38310/list-view/3x/infant-boys-t-shirt-3070-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Circular knit boys graphic tshirt - Blue" alt="Circular knit boys graphic tshirt - Blue" srcset="https://www.kidsuperstore.in/images/products/38310/list-view/1x/infant-boys-t-shirt-3070-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/38310/list-view/2x/infant-boys-t-shirt-3070-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/38310/list-view/3x/infant-boys-t-shirt-3070-color-blue-1.jpg 810w">

							<!-- <img src="/images/products/38310/list-view/load/infant-boys-t-shirt-3070-color-blue-1.jpg" data-srcset="/images/products/38310/list-view/1x/infant-boys-t-shirt-3070-color-blue-1.jpg 270w, /images/products/38310/list-view/2x/infant-boys-t-shirt-3070-color-blue-1.jpg 540w, /images/products/38310/list-view/3x/infant-boys-t-shirt-3070-color-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Circular knit boys graphic tshirt - Blue" 
							alt="Circular knit boys graphic tshirt - Blue"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/full-sleeves-toddler-car-printed-t-shirt-1838-white/buy">
							<img src="https://www.kidsuperstore.in/images/products/36051/list-view/load/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36051/list-view/1x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36051/list-view/2x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36051/list-view/3x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Full Sleeves Toddler Car Printed T-Shirt - White" alt="Full Sleeves Toddler Car Printed T-Shirt - White" srcset="https://www.kidsuperstore.in/images/products/36051/list-view/1x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36051/list-view/2x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36051/list-view/3x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 810w">

							<!-- <img src="/images/products/36051/list-view/load/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg" 
							data-srcset="/images/products/36051/list-view/1x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 270w, /images/products/36051/list-view/2x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 540w, /images/products/36051/list-view/3x/upbt180901-oc-6015-toddler-boys-hooded-tshirt-color-white-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Full Sleeves Toddler Car Printed T-Shirt - White" alt="Full Sleeves Toddler Car Printed T-Shirt - White"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/navy-girls-graphic-tee-1612-navy/buy">
							<img src="https://www.kidsuperstore.in/images/products/39557/list-view/load/girls-tshirt-1113-color-navy-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39557/list-view/1x/girls-tshirt-1113-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/39557/list-view/2x/girls-tshirt-1113-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/39557/list-view/3x/girls-tshirt-1113-color-navy-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Navy Girl's Graphic Tee - Navy" alt="Navy Girl's Graphic Tee - Navy" srcset="https://www.kidsuperstore.in/images/products/39557/list-view/1x/girls-tshirt-1113-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/39557/list-view/2x/girls-tshirt-1113-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/39557/list-view/3x/girls-tshirt-1113-color-navy-1.jpg 810w">


							<!-- <img src="/images/products/39557/list-view/load/girls-tshirt-1113-color-navy-1.jpg" data-srcset="/images/products/39557/list-view/1x/girls-tshirt-1113-color-navy-1.jpg 270w, /images/products/39557/list-view/2x/girls-tshirt-1113-color-navy-1.jpg 540w, /images/products/39557/list-view/3x/girls-tshirt-1113-color-navy-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Navy Girl's Graphic Tee - Navy" 
							alt="Navy Girl's Graphic Tee - Navy"> -->
						</a>
						@else
						<a href="/red-casual-graphic-t-shirt-1053-red/buy">
							<img src="https://www.kidsuperstore.in/images/products/38301/list-view/load/infant-boys-t-shirt-3062-color-red-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38301/list-view/1x/infant-boys-t-shirt-3062-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/38301/list-view/2x/infant-boys-t-shirt-3062-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/38301/list-view/3x/infant-boys-t-shirt-3062-color-red-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Red Casual Graphic T-Shirt - Red" alt="Red Casual Graphic T-Shirt - Red" srcset="https://www.kidsuperstore.in/images/products/38301/list-view/1x/infant-boys-t-shirt-3062-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/38301/list-view/2x/infant-boys-t-shirt-3062-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/38301/list-view/3x/infant-boys-t-shirt-3062-color-red-1.jpg 810w">

							<!-- <img src="/images/products/38301/list-view/load/infant-boys-t-shirt-3062-color-red-1.jpg" data-srcset="/images/products/38301/list-view/1x/infant-boys-t-shirt-3062-color-red-1.jpg 270w, /images/products/38301/list-view/2x/infant-boys-t-shirt-3062-color-red-1.jpg 540w, /images/products/38301/list-view/3x/infant-boys-t-shirt-3062-color-red-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Red Casual Graphic T-Shirt - Red" 
							alt="Red Casual Graphic T-Shirt - Red"> -->
						</a>
						@endif
					</div>
				</div>	
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="/boys/toddler-2-7-years/tshirt" class="btn kss-btn kss-btn--dark">Shop <strong>T-Shirts</strong></a>
				@elseif ($gendername == 'girls')
					<a href="/girls/toddler-2-7-years/tshirt" class="btn kss-btn kss-btn--dark">Shop <strong>T-Shirts</strong></a>
				@else
					<a href="/infant-0-2-years/tshirt/" class="btn kss-btn kss-btn--dark">Shop <strong>T-Shirts</strong></a>
				@endif	
			</div>
		</div>
	</div>
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box_3_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box_3_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box_3_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_3_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_3_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_3_small.jpg') }} 512w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_3_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/infants/box_3_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/infants/box_3_small.jpg') }} 512w"
					@endif	                          
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box_3_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box_3_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box_3_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_3_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_3_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_3_portrait_small.jpg') }} 400w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_3_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/infants/box_3_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/infants/box_3_portrait_small.jpg') }} 400w"
					@endif
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box_3_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box_3_20px.jpg') }}"
		       	   @else
		       	   	src="{{CDN::asset('/img/gender/infants/box_3_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_3_alt}}" 
		           title="{{$box_3_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/boys-ethnic-wear-2235-gold/buy">
							<img src="https://www.kidsuperstore.in/images/products/36699/list-view/load/upbi181001-sb-1908-color-gold-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36699/list-view/1x/upbi181001-sb-1908-color-gold-1.jpg 270w, https://www.kidsuperstore.in/images/products/36699/list-view/2x/upbi181001-sb-1908-color-gold-1.jpg 540w, https://www.kidsuperstore.in/images/products/36699/list-view/3x/upbi181001-sb-1908-color-gold-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Boys ethnic wear - Gold" alt="Boys ethnic wear - Gold" srcset="https://www.kidsuperstore.in/images/products/36699/list-view/1x/upbi181001-sb-1908-color-gold-1.jpg 270w, https://www.kidsuperstore.in/images/products/36699/list-view/2x/upbi181001-sb-1908-color-gold-1.jpg 540w, https://www.kidsuperstore.in/images/products/36699/list-view/3x/upbi181001-sb-1908-color-gold-1.jpg 810w">

							<!-- <img src="/images/products/36699/list-view/load/upbi181001-sb-1908-color-gold-1.jpg" 
							data-srcset="/images/products/36699/list-view/1x/upbi181001-sb-1908-color-gold-1.jpg 270w, /images/products/36699/list-view/2x/upbi181001-sb-1908-color-gold-1.jpg 540w, /images/products/36699/list-view/3x/upbi181001-sb-1908-color-gold-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Boys ethnic wear - Gold" 
							alt="Boys ethnic wear - Gold"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/knit-georgette-blouse-top-2302-red/buy">
							<img src="https://www.kidsuperstore.in/images/products/36796/list-view/load/upgj180901-an-7087-color-red-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36796/list-view/1x/upgj180901-an-7087-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/36796/list-view/2x/upgj180901-an-7087-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/36796/list-view/3x/upgj180901-an-7087-color-red-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title=" knit georgette Blouse Top - Red" alt=" knit georgette Blouse Top - Red" srcset="https://www.kidsuperstore.in/images/products/36796/list-view/1x/upgj180901-an-7087-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/36796/list-view/2x/upgj180901-an-7087-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/36796/list-view/3x/upgj180901-an-7087-color-red-1.jpg 810w">

							<!-- <img src="/images/products/36796/list-view/load/upgj180901-an-7087-color-red-1.jpg" data-srcset="/images/products/36796/list-view/1x/upgj180901-an-7087-color-red-1.jpg 270w, /images/products/36796/list-view/2x/upgj180901-an-7087-color-red-1.jpg 540w, /images/products/36796/list-view/3x/upgj180901-an-7087-color-red-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="knit georgette Blouse Top - Red" 
							alt="knit georgette Blouse Top - Red"> -->
						</a>
						@else
						<a href="/off-white-full-elasticated-all-over-printed-track-pant-1865-off-white/buy">
							<img src="https://www.kidsuperstore.in/images/products/36114/list-view/load/ssbi180902-pr-5010-color-off-white-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36114/list-view/1x/ssbi180902-pr-5010-color-off-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36114/list-view/2x/ssbi180902-pr-5010-color-off-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36114/list-view/3x/ssbi180902-pr-5010-color-off-white-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Off-white Full Elasticated All over Printed Track Pant - Off White" alt="Off-white Full Elasticated All over Printed Track Pant - Off White" srcset="https://www.kidsuperstore.in/images/products/36114/list-view/1x/ssbi180902-pr-5010-color-off-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/36114/list-view/2x/ssbi180902-pr-5010-color-off-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/36114/list-view/3x/ssbi180902-pr-5010-color-off-white-1.jpg 810w">

							<!-- <img src="/images/products/36114/list-view/load/ssbi180902-pr-5010-color-off-white-1.jpg" data-srcset="/images/products/36114/list-view/1x/ssbi180902-pr-5010-color-off-white-1.jpg 270w, /images/products/36114/list-view/2x/ssbi180902-pr-5010-color-off-white-1.jpg 540w, /images/products/36114/list-view/3x/ssbi180902-pr-5010-color-off-white-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Off-white Full Elasticated All over Printed Track Pant - Off White" 
							alt="Off-white Full Elasticated All over Printed Track Pant - Off White"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/jacket-dhoti-set-1593-red/buy">
							<img src="https://www.kidsuperstore.in/images/products/39439/list-view/load/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39439/list-view/1x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/39439/list-view/2x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/39439/list-view/3x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="JACKET DHOTI SET - Red" alt="JACKET DHOTI SET - Red" srcset="https://www.kidsuperstore.in/images/products/39439/list-view/1x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/39439/list-view/2x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/39439/list-view/3x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 810w">

							<!-- <img src="/images/products/39439/list-view/load/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg" data-srcset="/images/products/39439/list-view/1x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 270w, /images/products/39439/list-view/2x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 540w, /images/products/39439/list-view/3x/lps-dhtbomr-boys-jacket-dhoti-set-color-red-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="JACKET DHOTI SET - Red" 
							alt="JACKET DHOTI SET - Red"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/cap-sleeve-asymmetric-top-2280-peach/buy">
							<img src="https://www.kidsuperstore.in/images/products/36766/list-view/load/upgj180901-oc-6008-color-peach-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36766/list-view/1x/upgj180901-oc-6008-color-peach-1.jpg 270w, https://www.kidsuperstore.in/images/products/36766/list-view/2x/upgj180901-oc-6008-color-peach-1.jpg 540w, https://www.kidsuperstore.in/images/products/36766/list-view/3x/upgj180901-oc-6008-color-peach-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Cap Sleeve Asymmetric Top - Peach" alt="Cap Sleeve Asymmetric Top - Peach" srcset="https://www.kidsuperstore.in/images/products/36766/list-view/1x/upgj180901-oc-6008-color-peach-1.jpg 270w, https://www.kidsuperstore.in/images/products/36766/list-view/2x/upgj180901-oc-6008-color-peach-1.jpg 540w, https://www.kidsuperstore.in/images/products/36766/list-view/3x/upgj180901-oc-6008-color-peach-1.jpg 810w">

							<!-- <img src="/images/products/36766/list-view/load/upgj180901-oc-6008-color-peach-1.jpg" data-srcset="/images/products/36766/list-view/1x/upgj180901-oc-6008-color-peach-1.jpg 270w, /images/products/36766/list-view/2x/upgj180901-oc-6008-color-peach-1.jpg 540w, /images/products/36766/list-view/3x/upgj180901-oc-6008-color-peach-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Cap Sleeve Asymmetric Top - Peach" 
							alt="Cap Sleeve Asymmetric Top - Peach"> -->
						</a>
						@else
						<a href="/23-printed-infant-shorts-1613-yellow/buy">
							<img src="https://www.kidsuperstore.in/images/products/39560/list-view/load/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39560/list-view/1x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 270w, https://www.kidsuperstore.in/images/products/39560/list-view/2x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 540w, https://www.kidsuperstore.in/images/products/39560/list-view/3x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="&quot;23&quot; Printed Infant Shorts - Yellow" alt="&quot;23&quot; Printed Infant Shorts - Yellow" srcset="https://www.kidsuperstore.in/images/products/39560/list-view/1x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 270w, https://www.kidsuperstore.in/images/products/39560/list-view/2x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 540w, https://www.kidsuperstore.in/images/products/39560/list-view/3x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 810w">

						<!-- 	<img src="/images/products/39560/list-view/load/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg" 
							data-srcset="/images/products/39560/list-view/1x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 270w, /images/products/39560/list-view/2x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 540w, /images/products/39560/list-view/3x/tango-425-11486-23-printed-infant-shorts-color-yellow-1.jpg 810w" data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="&quot;23&quot; Printed Infant Shorts - Yellow" 
							alt="&quot;23&quot; Printed Infant Shorts - Yellow"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/jaipuri-print-cotton-kedia-dhoti-set-1599-red/buy">
							<img src="https://www.kidsuperstore.in/images/products/39445/list-view/load/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39445/list-view/1x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/39445/list-view/2x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/39445/list-view/3x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Jaipuri print cotton kedia dhoti set - Red" alt="Jaipuri print cotton kedia dhoti set - Red" srcset="https://www.kidsuperstore.in/images/products/39445/list-view/1x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/39445/list-view/2x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/39445/list-view/3x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 810w">

							<!-- <img src="/images/products/39445/list-view/load/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg" 
							data-srcset="/images/products/39445/list-view/1x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 270w, /images/products/39445/list-view/2x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 540w, /images/products/39445/list-view/3x/bnb-bdk025rd-jaipuri-print-cotton-kedia-dhoti-set-color-red-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Jaipuri print cotton kedia dhoti set - Red" 
							alt="Jaipuri print cotton kedia dhoti set - Red"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/casual-woven-flutter-top-943-beige/buy">
							<img src="https://www.kidsuperstore.in/images/products/38102/list-view/load/toddlers-woven-top-tgtp02-color-beige-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38102/list-view/1x/toddlers-woven-top-tgtp02-color-beige-1.jpg 270w, https://www.kidsuperstore.in/images/products/38102/list-view/2x/toddlers-woven-top-tgtp02-color-beige-1.jpg 540w, https://www.kidsuperstore.in/images/products/38102/list-view/3x/toddlers-woven-top-tgtp02-color-beige-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Casual woven flutter top - Beige" alt="Casual woven flutter top - Beige" srcset="https://www.kidsuperstore.in/images/products/38102/list-view/1x/toddlers-woven-top-tgtp02-color-beige-1.jpg 270w, https://www.kidsuperstore.in/images/products/38102/list-view/2x/toddlers-woven-top-tgtp02-color-beige-1.jpg 540w, https://www.kidsuperstore.in/images/products/38102/list-view/3x/toddlers-woven-top-tgtp02-color-beige-1.jpg 810w">

							<!-- <img src="/images/products/38102/list-view/load/toddlers-woven-top-tgtp02-color-beige-1.jpg" data-srcset="/images/products/38102/list-view/1x/toddlers-woven-top-tgtp02-color-beige-1.jpg 270w, /images/products/38102/list-view/2x/toddlers-woven-top-tgtp02-color-beige-1.jpg 540w, /images/products/38102/list-view/3x/toddlers-woven-top-tgtp02-color-beige-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Casual woven flutter top - Beige" 
							alt="Casual woven flutter top - Beige"> -->
						</a>
						@else
						<a href="/red-car-aop-shorts-1797-orange/buy">
							<img src="https://www.kidsuperstore.in/images/products/35965/list-view/load/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/35965/list-view/1x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 270w, https://www.kidsuperstore.in/images/products/35965/list-view/2x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 540w, https://www.kidsuperstore.in/images/products/35965/list-view/3x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Red Car AOP Shorts - Orange" alt="Red Car AOP Shorts - Orange" srcset="https://www.kidsuperstore.in/images/products/35965/list-view/1x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 270w, https://www.kidsuperstore.in/images/products/35965/list-view/2x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 540w, https://www.kidsuperstore.in/images/products/35965/list-view/3x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 810w">

							<!-- <img src="/images/products/35965/list-view/load/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg" 
							data-srcset="/images/products/35965/list-view/1x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 270w, /images/products/35965/list-view/2x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 540w, /images/products/35965/list-view/3x/ssbi180902-ac-1310-infant-boys-short-color-orange-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Red Car AOP Shorts - Orange" 
							alt="Red Car AOP Shorts - Orange"> -->
						</a>
						@endif
					</div>
				</div>	
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="/boys/toddler-2-7-years/ethnic" class="btn kss-btn kss-btn--dark">Shop <strong>Ethnic</strong></a>
				@elseif ($gendername == 'girls')
					<a href="/girls/toddler-2-7-years/woven-tops" class="btn kss-btn kss-btn--dark">Shop <strong>Woven Tops</strong></a>
				@else
					<a href="/infant-0-2-years/bottoms/" class="btn kss-btn kss-btn--dark">Shop <strong>Bottoms</strong></a>
				@endif	
			</div>
		</div>
	</div>	
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box_4_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box_4_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box_4_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_4_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_4_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_4_small.jpg') }} 512w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_4_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/infants/box_4_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/infants/box_4_small.jpg') }} 512w"
					@endif	                          
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box_4_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box_4_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box_4_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_4_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_4_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_4_portrait_small.jpg') }} 400w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_4_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/infants/box_4_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/infants/box_4_portrait_small.jpg') }} 400w"
					@endif
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box_4_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box_4_20px.jpg') }}"
		       	   @else
		       	   	src="{{CDN::asset('/img/gender/infants/box_4_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_4_alt}}" 
		           title="{{$box_4_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/fixed-waist-with-adjustable-elastic-ombre-jeans-2254-mid-wash/buy">
							<img src="https://www.kidsuperstore.in/images/products/36739/list-view/load/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36739/list-view/1x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36739/list-view/2x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36739/list-view/3x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Fixed waist with adjustable elastic Ombre Jeans - Mid Wash" alt="Fixed waist with adjustable elastic Ombre Jeans - Mid Wash" srcset="https://www.kidsuperstore.in/images/products/36739/list-view/1x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36739/list-view/2x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36739/list-view/3x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 810w">

							<!-- <img src="/images/products/36739/list-view/load/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg" 
							data-srcset="/images/products/36739/list-view/1x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 270w, /images/products/36739/list-view/2x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 540w, /images/products/36739/list-view/3x/upbj181002-ra-1603-fixed-waist-with-adjustable-elastic-ombre-jeans-color-mid-wash-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Fixed waist with adjustable elastic Ombre Jeans - Mid Wash" 
							alt="Fixed waist with adjustable elastic Ombre Jeans - Mid Wash"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/girls-ethnic-wear-2233-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/36689/list-view/load/upgt181001-sb-1906-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36689/list-view/1x/upgt181001-sb-1906-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/36689/list-view/2x/upgt181001-sb-1906-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/36689/list-view/3x/upgt181001-sb-1906-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Girls ethnic wear - Blue" alt="Girls ethnic wear - Blue" srcset="https://www.kidsuperstore.in/images/products/36689/list-view/1x/upgt181001-sb-1906-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/36689/list-view/2x/upgt181001-sb-1906-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/36689/list-view/3x/upgt181001-sb-1906-color-blue-1.jpg 810w">

							<!-- <img src="/images/products/36689/list-view/load/upgt181001-sb-1906-color-blue-1.jpg" data-srcset="/images/products/36689/list-view/1x/upgt181001-sb-1906-color-blue-1.jpg 270w, /images/products/36689/list-view/2x/upgt181001-sb-1906-color-blue-1.jpg 540w, /images/products/36689/list-view/3x/upgt181001-sb-1906-color-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Girls ethnic wear - Blue" 
							alt="Girls ethnic wear - Blue"> -->
						</a>
						@else
						<a href="/pink-cotton-baby-bibs-1078-pink/buy">
							<img src="https://www.kidsuperstore.in/images/products/38354/list-view/load/new-born-3060-color-pink.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38354/list-view/1x/new-born-3060-color-pink.jpg 270w, https://www.kidsuperstore.in/images/products/38354/list-view/2x/new-born-3060-color-pink.jpg 540w, https://www.kidsuperstore.in/images/products/38354/list-view/3x/new-born-3060-color-pink.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Pink cotton baby bibs - Pink" alt="Pink cotton baby bibs - Pink" srcset="https://www.kidsuperstore.in/images/products/38354/list-view/1x/new-born-3060-color-pink.jpg 270w, https://www.kidsuperstore.in/images/products/38354/list-view/2x/new-born-3060-color-pink.jpg 540w, https://www.kidsuperstore.in/images/products/38354/list-view/3x/new-born-3060-color-pink.jpg 810w">

							<!-- <img src="/images/products/38354/list-view/load/new-born-3060-color-pink.jpg" data-srcset="images/products/38354/list-view/1x/new-born-3060-color-pink.jpg 270w, /images/products/38354/list-view/2x/new-born-3060-color-pink.jpg 540w, /images/products/38354/list-view/3x/new-born-3060-color-pink.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Pink cotton baby bibs - Pink" 
							alt="Pink cotton baby bibs - Pink""> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/navy-aop-short-1802-navy/buy">
							<img src="https://www.kidsuperstore.in/images/products/35980/list-view/load/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/35980/list-view/1x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/35980/list-view/2x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/35980/list-view/3x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Navy AOP Short - Navy" alt="Navy AOP Short - Navy" srcset="https://www.kidsuperstore.in/images/products/35980/list-view/1x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/35980/list-view/2x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/35980/list-view/3x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 810w">

							<!-- <img src="/products/35980/list-view/load/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg" 
							data-srcset="/images/products/35980/list-view/1x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 270w, /images/products/35980/list-view/2x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 540w, /images/products/35980/list-view/3x/upbt180902-ac-1305-toddler-boys-shorts-color-navy-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Navy AOP Short - Navy" 
							alt="Navy AOP Short - Navy"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/girls-ethnic-wear-2226-yellow/buy">
							<img src="https://www.kidsuperstore.in/images/products/36681/list-view/load/upgt181001-sb-1902-color-yellow-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36681/list-view/1x/upgt181001-sb-1902-color-yellow-1.jpg 270w, https://www.kidsuperstore.in/images/products/36681/list-view/2x/upgt181001-sb-1902-color-yellow-1.jpg 540w, https://www.kidsuperstore.in/images/products/36681/list-view/3x/upgt181001-sb-1902-color-yellow-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Girls Ethnic wear - Yellow" alt="Girls Ethnic wear - Yellow" srcset="https://www.kidsuperstore.in/images/products/36681/list-view/1x/upgt181001-sb-1902-color-yellow-1.jpg 270w, https://www.kidsuperstore.in/images/products/36681/list-view/2x/upgt181001-sb-1902-color-yellow-1.jpg 540w, https://www.kidsuperstore.in/images/products/36681/list-view/3x/upgt181001-sb-1902-color-yellow-1.jpg 810w">

							<!-- <img src="/images/products/36681/list-view/load/upgt181001-sb-1902-color-yellow-1.jpg" 
							data-srcset="/images/products/36681/list-view/1x/upgt181001-sb-1902-color-yellow-1.jpg 270w, /images/products/36681/list-view/2x/upgt181001-sb-1902-color-yellow-1.jpg 540w, /images/products/36681/list-view/3x/upgt181001-sb-1902-color-yellow-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Girls Ethnic wear - Yellow" 
							alt="Girls Ethnic wear - Yellow"> -->
						</a>
						@else
						<a href="/half-sleeves-printed-rompers-1862-red/buy">
							<img src="https://www.kidsuperstore.in/images/products/36108/list-view/load/ssbi180902-pr-5008-color-red-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36108/list-view/1x/ssbi180902-pr-5008-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/36108/list-view/2x/ssbi180902-pr-5008-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/36108/list-view/3x/ssbi180902-pr-5008-color-red-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Half Sleeves Printed Rompers - Red" alt="Half Sleeves Printed Rompers - Red" srcset="https://www.kidsuperstore.in/images/products/36108/list-view/1x/ssbi180902-pr-5008-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/36108/list-view/2x/ssbi180902-pr-5008-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/36108/list-view/3x/ssbi180902-pr-5008-color-red-1.jpg 810w">

							<!-- <img src="/images/products/36108/list-view/load/ssbi180902-pr-5008-color-red-1.jpg" data-srcset="/images/products/36108/list-view/1x/ssbi180902-pr-5008-color-red-1.jpg 270w, /images/products/36108/list-view/2x/ssbi180902-pr-5008-color-red-1.jpg 540w, /images/products/36108/list-view/3x/ssbi180902-pr-5008-color-red-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Half Sleeves Printed Rompers - Red" 
							alt="Half Sleeves Printed Rompers - Red"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/fixed-waist-with-adjustable-elastic-dark-wash-jeans-2253-mid-wash/buy">
							<img src="https://www.kidsuperstore.in/images/products/36736/list-view/load/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36736/list-view/1x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36736/list-view/2x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36736/list-view/3x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Fixed waist with adjustable elastic Dark Wash Jeans - Mid Wash" alt="Fixed waist with adjustable elastic Dark Wash Jeans - Mid Wash" srcset="https://www.kidsuperstore.in/images/products/36736/list-view/1x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36736/list-view/2x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36736/list-view/3x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 810w">

							<!-- <img src="/images/products/36736/list-view/load/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg" 
							data-srcset="/images/products/36736/list-view/1x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 270w, /images/products/36736/list-view/2x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 540w, /images/products/36736/list-view/3x/upbj181002-ra-1604-fixed-waist-with-adjustable-elastic-dark-wash-jeans-color-mid-wash-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Fixed waist with adjustable elastic Dark Wash Jeans - Mid Wash" 
							alt="Fixed waist with adjustable elastic Dark Wash Jeans - Mid Wash"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/peter-pan-collar-lehnga-choli-for-girls-1602-red/buy">
							<img src="https://www.kidsuperstore.in/images/products/39454/list-view/load/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39454/list-view/1x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/39454/list-view/2x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/39454/list-view/3x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Peter Pan Collar Lehnga Choli for Girls - Red" alt="Peter Pan Collar Lehnga Choli for Girls - Red" srcset="https://www.kidsuperstore.in/images/products/39454/list-view/1x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 270w, https://www.kidsuperstore.in/images/products/39454/list-view/2x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 540w, https://www.kidsuperstore.in/images/products/39454/list-view/3x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 810w">

							<!-- <img src="/images/products/39454/list-view/load/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg" 
							data-srcset="/images/products/39454/list-view/1x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 270w, /images/products/39454/list-view/2x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 540w, /images/products/39454/list-view/3x/bnb-glc017pi-girls-peter-pan-collar-lehnga-choli-color-red-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Peter Pan Collar Lehnga Choli for Girls - Red" 
							alt="Peter Pan Collar Lehnga Choli for Girls - Red"> -->
						</a>
						@else
						<a href="/navy-blue-casual-cotton-rompers-1069-navy/buy">
							<img src="https://www.kidsuperstore.in/images/products/38331/list-view/load/new-born-3026-color-navy-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38331/list-view/1x/new-born-3026-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/38331/list-view/2x/new-born-3026-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/38331/list-view/3x/new-born-3026-color-navy-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Navy blue casual cotton rompers - Navy" alt="Navy blue casual cotton rompers - Navy" srcset="https://www.kidsuperstore.in/images/products/38331/list-view/1x/new-born-3026-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/38331/list-view/2x/new-born-3026-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/38331/list-view/3x/new-born-3026-color-navy-1.jpg 810w">

							<!-- <img src="/images/products/38331/list-view/load/new-born-3026-color-navy-1.jpg" data-srcset="/images/products/38331/list-view/1x/new-born-3026-color-navy-1.jpg 270w, /images/products/38331/list-view/2x/new-born-3026-color-navy-1.jpg 540w, /images/products/38331/list-view/3x/new-born-3026-color-navy-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Navy blue casual cotton rompers - Navy" 
							alt="Navy blue casual cotton rompers - Navy"> -->
						</a>
						@endif
					</div>
				</div>
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="/boys/toddler-2-7-years/bottoms" class="btn kss-btn kss-btn--dark">Shop <strong>Bottoms</strong></a>
				@elseif ($gendername == 'girls')
					<a href="/girls/toddler-2-7-years/ethnic" class="btn kss-btn kss-btn--dark">Shop <strong>Ethnic</strong></a>
				@else
					<a href="/infant-0-2-years/infant-utility/" class="btn kss-btn kss-btn--dark">Shop <strong>Utility</strong></a>
				@endif	
			</div>
		</div>
	</div>		
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box_5_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box_5_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box_5_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_5_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_5_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_5_small.jpg') }} 512w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_5_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/infants/box_5_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/infants/box_5_small.jpg') }} 512w"
					@endif	                          
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box_5_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box_5_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box_5_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_5_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_5_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_5_portrait_small.jpg') }} 400w"
		            @else
		            	data-srcset="{{CDN::asset('/img/gender/infants/box_5_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/infants/box_5_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/infants/box_5_portrait_small.jpg') }} 400w"
					@endif
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box_5_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box_5_20px.jpg') }}"
		       	   @else
		       	   	src="{{CDN::asset('/img/gender/infants/box_5_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_5_alt}}" 
		           title="{{$box_5_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/navy-world-map-printed-short-1805-navy/buy">
							<img src="https://www.kidsuperstore.in/images/products/35989/list-view/load/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/35989/list-view/1x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/35989/list-view/2x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/35989/list-view/3x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Navy World map Printed Short - Navy" alt="Navy World map Printed Short - Navy" srcset="https://www.kidsuperstore.in/images/products/35989/list-view/1x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 270w, https://www.kidsuperstore.in/images/products/35989/list-view/2x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 540w, https://www.kidsuperstore.in/images/products/35989/list-view/3x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 810w">

							<!-- <img src="/images/products/35989/list-view/load/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg" 
							data-srcset="/images/products/35989/list-view/1x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 270w, /images/products/35989/list-view/2x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 540w, /images/products/35989/list-view/3x/upbj180902-ac-1308-junior-boys-shorts-color-navy-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Navy World map Printed Short - Navy" 
							alt="Navy World map Printed Short - Navy"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/full-elasticated-mid-wash-jeans-2262-mid-wash/buy">
							<img src="https://www.kidsuperstore.in/images/products/36748/list-view/load/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36748/list-view/1x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36748/list-view/2x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36748/list-view/3x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Full Elasticated Mid Wash Jeans - Mid Wash" alt="Full Elasticated Mid Wash Jeans - Mid Wash" srcset="https://www.kidsuperstore.in/images/products/36748/list-view/1x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36748/list-view/2x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36748/list-view/3x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 810w">

							<!-- <img src="/images/products/36748/list-view/load/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg" 
							data-srcset="/images/products/36748/list-view/1x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 270w, /images/products/36748/list-view/2x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 540w, /images/products/36748/list-view/3x/upgt181002-ra-1607-full-elasticated-mid-wash-jeans-color-mid-wash-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Full Elasticated Mid Wash Jeans - Mid Wash" 
							alt="Full Elasticated Mid Wash Jeans - Mid Wash"> -->
						</a>
						@else
						<a href="/blue-solid-cotton-socks-booties-1576-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/39404/list-view/load/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39404/list-view/1x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/39404/list-view/2x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/39404/list-view/3x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Blue Solid Cotton Socks Booties - Blue" alt="Blue Solid Cotton Socks Booties - Blue" srcset="https://www.kidsuperstore.in/images/products/39404/list-view/1x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/39404/list-view/2x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/39404/list-view/3x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 810w">

							<!-- <img src="/images/products/39404/list-view/load/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg" 
							data-srcset="/images/products/39404/list-view/1x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 270w, /images/products/39404/list-view/2x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 540w, /images/products/39404/list-view/3x/tw-m7-nb-socks-bootie-with-anti-skid-color-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Blue Solid Cotton Socks Booties - Blue" 
							alt="Blue Solid Cotton Socks Booties - Blue"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/boys-adjustable-elastic-printed-shorts-1790-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/35959/list-view/load/upbj180901-ca-1023-color-blue-4.jpg" data-srcset="https://www.kidsuperstore.in/images/products/35959/list-view/1x/upbj180901-ca-1023-color-blue-4.jpg 270w, https://www.kidsuperstore.in/images/products/35959/list-view/2x/upbj180901-ca-1023-color-blue-4.jpg 540w, https://www.kidsuperstore.in/images/products/35959/list-view/3x/upbj180901-ca-1023-color-blue-4.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Boys Adjustable Elastic printed Shorts - Blue" alt="Boys Adjustable Elastic printed Shorts - Blue" srcset="https://www.kidsuperstore.in/images/products/35959/list-view/1x/upbj180901-ca-1023-color-blue-4.jpg 270w, https://www.kidsuperstore.in/images/products/35959/list-view/2x/upbj180901-ca-1023-color-blue-4.jpg 540w, https://www.kidsuperstore.in/images/products/35959/list-view/3x/upbj180901-ca-1023-color-blue-4.jpg 810w">

							<!-- <img src="/images/products/35959/list-view/load/upbj180901-ca-1023-color-blue-4.jpg" data-srcset="/images/products/35959/list-view/1x/upbj180901-ca-1023-color-blue-4.jpg 270w, /images/products/35959/list-view/2x/upbj180901-ca-1023-color-blue-4.jpg 540w, /images/products/35959/list-view/3x/upbj180901-ca-1023-color-blue-4.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Boys Adjustable Elastic printed Shorts - Blue" 
							alt="Boys Adjustable Elastic printed Shorts - Blue"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/fixed-waist-with-adjustable-elastic-light-wash-jeans-2261-light-wash/buy">
							<img src="https://www.kidsuperstore.in/images/products/36745/list-view/load/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36745/list-view/1x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36745/list-view/2x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36745/list-view/3x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Fixed waist with adjustable elastic Light Wash Jeans - Light Wash" alt="Fixed waist with adjustable elastic Light Wash Jeans - Light Wash" srcset="https://www.kidsuperstore.in/images/products/36745/list-view/1x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/36745/list-view/2x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/36745/list-view/3x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 810w">

							<!-- <img src="/images/products/36745/list-view/load/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg" 
							data-srcset="/images/products/36745/list-view/1x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 270w, /images/products/36745/list-view/2x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 540w, /images/products/36745/list-view/3x/upgt181002-ra-1606-fixed-waist-with-adjustable-elastic-light-wash-jeans-color-light-wash-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Fixed waist with adjustable elastic Light Wash Jeans - Light Wash" 
							alt="Fixed waist with adjustable elastic Light Wash Jeans - Light Wash"> -->
						</a>
						@else
						<a href="/blue-cotton-crocheted-booties-1570-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/39387/list-view/load/tw-m1-nb-crocheted-bootie-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/39387/list-view/1x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/39387/list-view/2x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/39387/list-view/3x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Blue Cotton Crocheted Booties - Blue" alt="Blue Cotton Crocheted Booties - Blue" srcset="https://www.kidsuperstore.in/images/products/39387/list-view/1x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/39387/list-view/2x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/39387/list-view/3x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 810w">

							<!-- <img src="/images/products/39387/list-view/load/tw-m1-nb-crocheted-bootie-color-blue-1.jpg" 
							data-srcset="/images/products/39387/list-view/1x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 270w, /images/products/39387/list-view/2x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 540w, /images/products/39387/list-view/3x/tw-m1-nb-crocheted-bootie-color-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Blue Cotton Crocheted Booties - Blue" 
							alt="Blue Cotton Crocheted Booties - Blue"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys')
						<a href="/printed-shorts-1801-white/buy">
							<img src="https://www.kidsuperstore.in/images/products/35977/list-view/load/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/35977/list-view/1x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/35977/list-view/2x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/35977/list-view/3x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Printed Shorts - White" alt="Printed Shorts - White" srcset="https://www.kidsuperstore.in/images/products/35977/list-view/1x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 270w, https://www.kidsuperstore.in/images/products/35977/list-view/2x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 540w, https://www.kidsuperstore.in/images/products/35977/list-view/3x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 810w">

						<!-- 	<img src="/images/products/35977/list-view/load/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg" 
							data-srcset="/images/products/35977/list-view/1x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 270w, /images/products/35977/list-view/2x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 540w, /images/products/35977/list-view/3x/upbt180902-ac-1304-toddler-boys-shorts-color-white-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Printed Shorts - White" 
							alt="Printed Shorts - White"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/casual-girl-denim-shorts-310-mid-wash/buy">
							<img src="https://www.kidsuperstore.in/images/products/37630/list-view/load/girl-shorts1020-color-mid-wash-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37630/list-view/1x/girl-shorts1020-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/37630/list-view/2x/girl-shorts1020-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/37630/list-view/3x/girl-shorts1020-color-mid-wash-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Casual girl denim shorts - Mid Wash" alt="Casual girl denim shorts - Mid Wash" srcset="https://www.kidsuperstore.in/images/products/37630/list-view/1x/girl-shorts1020-color-mid-wash-1.jpg 270w, https://www.kidsuperstore.in/images/products/37630/list-view/2x/girl-shorts1020-color-mid-wash-1.jpg 540w, https://www.kidsuperstore.in/images/products/37630/list-view/3x/girl-shorts1020-color-mid-wash-1.jpg 810w">

							<!-- <img src="/images/products/37630/list-view/load/girl-shorts1020-color-mid-wash-1.jpg" 
							data-srcset="/images/products/37630/list-view/1x/girl-shorts1020-color-mid-wash-1.jpg 270w, /images/products/37630/list-view/2x/girl-shorts1020-color-mid-wash-1.jpg 540w, /images/products/37630/list-view/3x/girl-shorts1020-color-mid-wash-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Casual girl denim shorts - Mid Wash" 
							alt="Casual girl denim shorts - Mid Wash"> -->
						</a>
						@else
						<a href="/disney-d628-boys-blue-winnie-the-pooh-casual-shoes-2774-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/40432/list-view/load/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/40432/list-view/1x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/40432/list-view/2x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/40432/list-view/3x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Disney D628 Boys Blue Winnie The Pooh Casual Shoes  - Blue" alt="Disney D628 Boys Blue Winnie The Pooh Casual Shoes  - Blue" srcset="https://www.kidsuperstore.in/images/products/40432/list-view/1x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/40432/list-view/2x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/40432/list-view/3x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 810w">

							<!-- <img src="/images/products/40432/list-view/load/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg" data-srcset="/images/products/40432/list-view/1x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 270w, /images/products/40432/list-view/2x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 540w, /images/products/40432/list-view/3x/d-628-disney-d628-boys-blue-winnie-the-pooh-casual-shoes-color-blue-1.jpg 810w" data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Disney D628 Boys Blue Winnie The Pooh Casual Shoes  - Blue" 
							alt="Disney D628 Boys Blue Winnie The Pooh Casual Shoes  - Blue"> -->
						</a>
						@endif
					</div>
				</div>
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="/boys/toddler-2-7-years/short" class="btn kss-btn kss-btn--dark">Shop <strong>Shorts</strong></a>
				@elseif ($gendername == 'girls')
					<a href="/girls/toddler-2-7-years/jeans" class="btn kss-btn kss-btn--dark">Shop <strong>Denim</strong></a>
				@else
					<a href="/shoes/infant-0-2-years/" class="btn kss-btn kss-btn--dark">Shop <strong>Shoes</strong></a>
				@endif	
			</div>
		</div>
	</div>
	@if ($gendername != 'infants')		
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		       		@if ($gendername == 'boys')
		              data-srcset="{{CDN::asset('/img/gender/boys/box_6_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/boys/box_6_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/boys/box_6_small.jpg') }} 512w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_6_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_6_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_6_small.jpg') }} 512w"
					@endif	                          
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		       		@if ($gendername == 'boys')
		            	data-srcset="{{CDN::asset('/img/gender/boys/box_6_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/boys/box_6_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/boys/box_6_portrait_small.jpg') }} 400w"
		            @elseif ($gendername == 'girls')
		            	data-srcset="{{CDN::asset('/img/gender/girls/box_6_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_6_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_6_portrait_small.jpg') }} 400w"
					@endif
		            sizes="100vw">

		       <img
		       	   @if ($gendername == 'boys') 
		       	   	src="{{CDN::asset('/img/gender/boys/box_6_20px.jpg') }}"
		       	   @elseif ($gendername == 'girls')
		       	   	src="{{CDN::asset('/img/gender/girls/box_6_20px.jpg') }}"
		       	   @endif
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_6_alt}}" 
		           title="{{$box_6_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/disney-mickey-black-shoe-2672-black/buy">
							<img src="https://www.kidsuperstore.in/images/products/40204/list-view/load/d613a-disney-mickey-black-shoe-color-black-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/40204/list-view/1x/d613a-disney-mickey-black-shoe-color-black-1.jpg 270w, https://www.kidsuperstore.in/images/products/40204/list-view/2x/d613a-disney-mickey-black-shoe-color-black-1.jpg 540w, https://www.kidsuperstore.in/images/products/40204/list-view/3x/d613a-disney-mickey-black-shoe-color-black-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="DISNEY MICKEY BLACK SHOE - Black" alt="DISNEY MICKEY BLACK SHOE - Black" srcset="https://www.kidsuperstore.in/images/products/40204/list-view/1x/d613a-disney-mickey-black-shoe-color-black-1.jpg 270w, https://www.kidsuperstore.in/images/products/40204/list-view/2x/d613a-disney-mickey-black-shoe-color-black-1.jpg 540w, https://www.kidsuperstore.in/images/products/40204/list-view/3x/d613a-disney-mickey-black-shoe-color-black-1.jpg 810w">

							<!-- <img src="/images/products/40204/list-view/load/d613a-disney-mickey-black-shoe-color-black-1.jpg" 
							data-srcset="/images/products/40204/list-view/1x/d613a-disney-mickey-black-shoe-color-black-1.jpg 270w, /images/products/40204/list-view/2x/d613a-disney-mickey-black-shoe-color-black-1.jpg 540w, /images/products/40204/list-view/3x/d613a-disney-mickey-black-shoe-color-black-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded"
							title="DISNEY MICKEY BLACK SHOE - Black" 
							alt="DISNEY MICKEY BLACK SHOE - Black"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/ligh-blue-casual-printed-leggings-192-light-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/37330/list-view/load/printed-leggings-0005-color-light-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37330/list-view/1x/printed-leggings-0005-color-light-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/37330/list-view/2x/printed-leggings-0005-color-light-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/37330/list-view/3x/printed-leggings-0005-color-light-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Ligh blue casual printed Leggings - Light Blue" alt="Ligh blue casual printed Leggings - Light Blue" srcset="https://www.kidsuperstore.in/images/products/37330/list-view/1x/printed-leggings-0005-color-light-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/37330/list-view/2x/printed-leggings-0005-color-light-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/37330/list-view/3x/printed-leggings-0005-color-light-blue-1.jpg 810w">

							<!-- <img src="/images/products/37330/list-view/load/printed-leggings-0005-color-light-blue-1.jpg" 
							data-srcset="/images/products/37330/list-view/1x/printed-leggings-0005-color-light-blue-1.jpg 270w, /images/products/37330/list-view/2x/printed-leggings-0005-color-light-blue-1.jpg 540w, /images/products/37330/list-view/3x/printed-leggings-0005-color-light-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Ligh blue casual printed Leggings - Light Blue" 
							alt="Ligh blue casual printed Leggings - Light Blue"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/superman-blue-sandal-2736-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/40338/list-view/load/w004-superman-blue-sandal-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/40338/list-view/1x/w004-superman-blue-sandal-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/40338/list-view/2x/w004-superman-blue-sandal-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/40338/list-view/3x/w004-superman-blue-sandal-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="SUPERMAN BLUE SANDAL - Blue" alt="SUPERMAN BLUE SANDAL - Blue" srcset="https://www.kidsuperstore.in/images/products/40338/list-view/1x/w004-superman-blue-sandal-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/40338/list-view/2x/w004-superman-blue-sandal-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/40338/list-view/3x/w004-superman-blue-sandal-color-blue-1.jpg 810w">

							<!-- <img src="/images/products/40338/list-view/load/w004-superman-blue-sandal-color-blue-1.jpg" 
							data-srcset="/images/products/40338/list-view/1x/w004-superman-blue-sandal-color-blue-1.jpg 270w, /images/products/40338/list-view/2x/w004-superman-blue-sandal-color-blue-1.jpg 540w, /images/products/40338/list-view/3x/w004-superman-blue-sandal-color-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="SUPERMAN BLUE SANDAL - Blue" 
							alt="SUPERMAN BLUE SANDAL - Blue"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/fixed-waist-with-adjustable-elastic-solid-trouser-2341-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/36834/list-view/load/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36834/list-view/1x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/36834/list-view/2x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/36834/list-view/3x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Fixed waist with adjustable elastic Solid Trouser - Sky Blue" alt="Fixed waist with adjustable elastic Solid Trouser - Sky Blue" srcset="https://www.kidsuperstore.in/images/products/36834/list-view/1x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/36834/list-view/2x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/36834/list-view/3x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 810w">
<!-- 
							<img src="/images/products/36834/list-view/load/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg" 
							data-srcset="/images/products/36834/list-view/1x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 270w, /images/products/36834/list-view/2x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 540w, /images/products/36834/list-view/3x/upgt18112-ug-2111-fixed-waist-with-adjustable-elastic-solid-trouser-color-sky-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Fixed waist with adjustable elastic Solid Trouser - Sky Blue"
							alt="Fixed waist with adjustable elastic Solid Trouser - Sky Blue"> -->
						</a>
						@endif
					</div>
					<div class="product-group__col">
						@if ($gendername == 'boys') 
						<a href="/batman-black-clog-2666-black/buy">
							<img src="https://www.kidsuperstore.in/images/products/40189/list-view/load/w600-batman-black-clog-color-black-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/40189/list-view/1x/w600-batman-black-clog-color-black-1.jpg 270w, https://www.kidsuperstore.in/images/products/40189/list-view/2x/w600-batman-black-clog-color-black-1.jpg 540w, https://www.kidsuperstore.in/images/products/40189/list-view/3x/w600-batman-black-clog-color-black-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="BATMAN BLACK CLOG - Black" alt="BATMAN BLACK CLOG - Black" srcset="https://www.kidsuperstore.in/images/products/40189/list-view/1x/w600-batman-black-clog-color-black-1.jpg 270w, https://www.kidsuperstore.in/images/products/40189/list-view/2x/w600-batman-black-clog-color-black-1.jpg 540w, https://www.kidsuperstore.in/images/products/40189/list-view/3x/w600-batman-black-clog-color-black-1.jpg 810w">

							<!-- <img src="/images/products/40189/list-view/load/w600-batman-black-clog-color-black-1.jpg" 
							data-srcset="/images/products/40189/list-view/1x/w600-batman-black-clog-color-black-1.jpg 270w, /images/products/40189/list-view/2x/w600-batman-black-clog-color-black-1.jpg 540w, /images/products/40189/list-view/3x/w600-batman-black-clog-color-black-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="BATMAN BLACK CLOG - Black" 
							alt="BATMAN BLACK CLOG - Black"> -->
						</a>
						@elseif ($gendername == 'girls')
						<a href="/cotton-printed-track-pant-193-blue/buy">
							<img src="https://www.kidsuperstore.in/images/products/37333/list-view/load/printed-leggings-0002-color-blue-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37333/list-view/1x/printed-leggings-0002-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/37333/list-view/2x/printed-leggings-0002-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/37333/list-view/3x/printed-leggings-0002-color-blue-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Cotton printed track pant - Blue" alt="Cotton printed track pant - Blue" srcset="https://www.kidsuperstore.in/images/products/37333/list-view/1x/printed-leggings-0002-color-blue-1.jpg 270w, https://www.kidsuperstore.in/images/products/37333/list-view/2x/printed-leggings-0002-color-blue-1.jpg 540w, https://www.kidsuperstore.in/images/products/37333/list-view/3x/printed-leggings-0002-color-blue-1.jpg 810w">
<!-- 
							<img src="/images/products/37333/list-view/load/printed-leggings-0002-color-blue-1.jpg" 
							data-srcset="/images/products/37333/list-view/1x/printed-leggings-0002-color-blue-1.jpg 270w, /images/products/37333/list-view/2x/printed-leggings-0002-color-blue-1.jpg 540w, /images/products/37333/list-view/3x/printed-leggings-0002-color-blue-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Cotton printed track pant - Blue" 
							alt="Cotton printed track pant - Blue"> -->
						</a>
						@endif
					</div>
				</div>
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				@if ($gendername == 'boys')
					<a href="/boys/toddler-2-7-years" class="btn kss-btn kss-btn--dark">Shop <strong>Shoes</strong></a>
				@elseif ($gendername == 'girls')
					<a href="/girls/toddler-2-7-years/bottoms" class="btn kss-btn kss-btn--dark">Shop <strong>Bottoms</strong></a>
				@endif	
			</div>
		</div>
	</div>	
	@endif	
	@if ($gendername == 'girls')		
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		            data-srcset="{{CDN::asset('/img/gender/girls/box_7_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_7_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_7_small.jpg') }} 512w"
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		            data-srcset="{{CDN::asset('/img/gender/girls/box_7_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_7_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_7_portrait_small.jpg') }} 400w"
		            sizes="100vw">

		       <img
		       	   src="{{CDN::asset('/img/gender/girls/box_7_20px.jpg') }}"
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_7_alt}}" 
		           title="{{$box_7_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						<a href="/full-elasticated-all-over-printed-woven-short-2056-brown/buy">
							<img src="https://www.kidsuperstore.in/images/products/36459/list-view/load/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/36459/list-view/1x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 270w, https://www.kidsuperstore.in/images/products/36459/list-view/2x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 540w, https://www.kidsuperstore.in/images/products/36459/list-view/3x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Full Elasticated All over Printed Woven Short - Brown" alt="Full Elasticated All over Printed Woven Short - Brown" srcset="https://www.kidsuperstore.in/images/products/36459/list-view/1x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 270w, https://www.kidsuperstore.in/images/products/36459/list-view/2x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 540w, https://www.kidsuperstore.in/images/products/36459/list-view/3x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 810w">

							<!-- <img src="/images/products/36459/list-view/load/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg" data-srcset="/images/products/36459/list-view/1x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 270w, /images/products/36459/list-view/2x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 540w, /images/products/36459/list-view/3x/upgt180901-an-7022-full-elasticated-all-over-printed-woven-short-color-brown-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
							class="card-img-top blur-up lazyloaded" 
							title="Full Elasticated All over Printed Woven Short - Brown" 
							alt="Full Elasticated All over Printed Woven Short - Brown""> -->
						</a>
					</div>
					<div class="product-group__col">
					<a href="/pink-cotton-girls-shorts-283-pink/buy">
						<img src="https://www.kidsuperstore.in/images/products/37561/list-view/load/girl-short-1029-color-pink-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37561/list-view/1x/girl-short-1029-color-pink-1.jpg 270w, https://www.kidsuperstore.in/images/products/37561/list-view/2x/girl-short-1029-color-pink-1.jpg 540w, https://www.kidsuperstore.in/images/products/37561/list-view/3x/girl-short-1029-color-pink-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Pink cotton girls shorts - Pink" alt="Pink cotton girls shorts - Pink" srcset="https://www.kidsuperstore.in/images/products/37561/list-view/1x/girl-short-1029-color-pink-1.jpg 270w, https://www.kidsuperstore.in/images/products/37561/list-view/2x/girl-short-1029-color-pink-1.jpg 540w, https://www.kidsuperstore.in/images/products/37561/list-view/3x/girl-short-1029-color-pink-1.jpg 810w">

						<!-- <img src="/images/products/37561/list-view/load/girl-short-1029-color-pink-1.jpg" data-srcset="/images/products/37561/list-view/1x/girl-short-1029-color-pink-1.jpg 270w, /images/products/37561/list-view/2x/girl-short-1029-color-pink-1.jpg 540w, /images/products/37561/list-view/3x/girl-short-1029-color-pink-1.jpg 810w" 
						data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
						class="card-img-top blur-up lazyloaded" 
						title="Pink cotton girls shorts - Pink" 
						alt="Pink cotton girls shorts - Pink"> -->
					</a>
					</div>
					<div class="product-group__col">
					<a href="/girls-casual-woven-short-274-blush/buy">
						<img src="https://www.kidsuperstore.in/images/products/37549/list-view/load/shorts-1018-color-blush-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/37549/list-view/1x/shorts-1018-color-blush-1.jpg 270w, https://www.kidsuperstore.in/images/products/37549/list-view/2x/shorts-1018-color-blush-1.jpg 540w, https://www.kidsuperstore.in/images/products/37549/list-view/3x/shorts-1018-color-blush-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Girls casual woven short - Blush" alt="Girls casual woven short - Blush" srcset="https://www.kidsuperstore.in/images/products/37549/list-view/1x/shorts-1018-color-blush-1.jpg 270w, https://www.kidsuperstore.in/images/products/37549/list-view/2x/shorts-1018-color-blush-1.jpg 540w, https://www.kidsuperstore.in/images/products/37549/list-view/3x/shorts-1018-color-blush-1.jpg 810w">

						<!-- <img src="/images/products/37549/list-view/load/shorts-1018-color-blush-1.jpg" data-srcset="/images/products/37549/list-view/1x/shorts-1018-color-blush-1.jpg 270w, /images/products/37549/list-view/2x/shorts-1018-color-blush-1.jpg 540w, /images/products/37549/list-view/3x/shorts-1018-color-blush-1.jpg 810w" 
						data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
						class="card-img-top blur-up lazyloaded" 
						title="Girls casual woven short - Blush" 
						alt="Girls casual woven short - Blush"> -->
					</a>
					</div>
				</div>
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				<a href="/girls/toddler-2-7-years/short" class="btn kss-btn kss-btn--dark">Shop <strong>Shorts</strong></a>
			</div>
		</div>
	</div>	
	<div class="row mb-md-4 pb-md-4">
		<div class="col-md-7 pr-md-0 img-hero">
			<picture>
		       <source media="(orientation: landscape)"
		            data-srcset="{{CDN::asset('/img/gender/girls/box_8_large.jpg') }} 1536w,
		                          {{CDN::asset('/img/gender/girls/box_8_medium.jpg') }} 1024w,
		                          {{CDN::asset('/img/gender/girls/box_8_small.jpg') }} 512w"
		            sizes="57vw">

		       <source media="(orientation: portrait)"
		            data-srcset="{{CDN::asset('/img/gender/girls/box_8_portrait_large.jpg') }} 1200w,
		                          {{CDN::asset('/img/gender/girls/box_8_portrait_medium.jpg') }} 700w,
		                          {{CDN::asset('/img/gender/girls/box_8_portrait_small.jpg') }} 400w"
		            sizes="100vw">

		       <img
		       	   src="{{CDN::asset('/img/gender/girls/box_8_20px.jpg') }}"
		           data-sizes="100vw"
		           class="img-fluid lazyload blur-up w-100"
		           alt="{{$box_8_alt}}" 
		           title="{{$box_8_title}}">
		    </picture>
		</div>
		<div class="col-md-5 d-flex">
			<div class="gender text-center d-flex align-items-center flex-column justify-content-between flex-1">
				<div class="product-group d-flex mb-md-3">
					<div class="product-group__col">
						<a href="/floral-party-wear-bally-1120-pink/buy">
							<img src="https://www.kidsuperstore.in/images/products/38461/list-view/load/tuskey-241-floral-party-wear-bally-color-pink-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38461/list-view/1x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 270w, https://www.kidsuperstore.in/images/products/38461/list-view/2x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 540w, https://www.kidsuperstore.in/images/products/38461/list-view/3x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Floral Party Wear Bally - Pink" alt="Floral Party Wear Bally - Pink" srcset="https://www.kidsuperstore.in/images/products/38461/list-view/1x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 270w, https://www.kidsuperstore.in/images/products/38461/list-view/2x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 540w, https://www.kidsuperstore.in/images/products/38461/list-view/3x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 810w">

							<!-- <img src="/images/products/38461/list-view/load/tuskey-241-floral-party-wear-bally-color-pink-1.jpg" 
							data-srcset="/images/products/38461/list-view/1x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 270w, /images/products/38461/list-view/2x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 540w, /images/products/38461/list-view/3x/tuskey-241-floral-party-wear-bally-color-pink-1.jpg 810w" 
							data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw" 
							class="card-img-top blur-up lazyloaded" 
							title="Floral Party Wear Bally - Pink" 
							alt="Floral Party Wear Bally - Pink"> -->
						</a>
					</div>
					<div class="product-group__col">
					<a href="/maroon-velvet-party-wear-bally-1119-maroon/buy">
						<img src="https://www.kidsuperstore.in/images/products/38455/list-view/load/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38455/list-view/1x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 270w, https://www.kidsuperstore.in/images/products/38455/list-view/2x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 540w, https://www.kidsuperstore.in/images/products/38455/list-view/3x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Maroon Velvet Party Wear Bally - Maroon" alt="Maroon Velvet Party Wear Bally - Maroon" srcset="https://www.kidsuperstore.in/images/products/38455/list-view/1x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 270w, https://www.kidsuperstore.in/images/products/38455/list-view/2x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 540w, https://www.kidsuperstore.in/images/products/38455/list-view/3x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 810w">

						<!-- <img src="/images/products/38455/list-view/load/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg" 
						data-srcset="/images/products/38455/list-view/1x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 270w, /images/products/38455/list-view/2x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 540w, /images/products/38455/list-view/3x/tuskey-240-maroon-velvet-party-wear-bally-color-maroon-1.jpg 810w" 
						data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
						class="card-img-top blur-up lazyloaded" 
						title="Maroon Velvet Party Wear Bally - Maroon" 
						alt="Maroon Velvet Party Wear Bally - Maroon"> -->
					</a>
					</div>
					<div class="product-group__col">
					<a href="/copper-velcro-party-wear-bally-1092-copper/buy">
						<img src="https://www.kidsuperstore.in/images/products/38388/list-view/load/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg" data-srcset="https://www.kidsuperstore.in/images/products/38388/list-view/1x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 270w, https://www.kidsuperstore.in/images/products/38388/list-view/2x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 540w, https://www.kidsuperstore.in/images/products/38388/list-view/3x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 810w" sizes="(min-width: 1200px) 270px,(min-width: 992px) 22vw,(min-width: 768px) 33vw, 45vw" class="card-img-top blur-up lazyloaded" title="Copper Velcro Party Wear Bally - Copper" alt="Copper Velcro Party Wear Bally - Copper" srcset="https://www.kidsuperstore.in/images/products/38388/list-view/1x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 270w, https://www.kidsuperstore.in/images/products/38388/list-view/2x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 540w, https://www.kidsuperstore.in/images/products/38388/list-view/3x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 810w">

						<!-- <img src="/images/products/38388/list-view/load/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg" 
						data-srcset="/images/products/38388/list-view/1x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 270w, /images/products/38388/list-view/2x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 540w, /images/products/38388/list-view/3x/tuskey-209-copper-velcro-party-wear-bally-color-copper-1.jpg 810w" 
						data-sizes="(min-width: 1200px) 182px,(min-width: 992px) 13vw,(min-width: 768px) 33vw, 53vw"
						class="card-img-top blur-up lazyloaded" 
						title="Copper Velcro Party Wear Bally - Copper" 
						alt="Copper Velcro Party Wear Bally - Copper"> -->
					</a>
					</div>
				</div>
				<h3 class="gender__name font-weight-bold text-dark text-uppercase m-detach">{{$title}}</h3>
				<p class="gender__years text-dark m-detach">{{$years}}</p>
				<a href="/shoes/girls/toddler-2-7-years" class="btn kss-btn kss-btn--dark">Shop <strong>Shoes</strong></a>
			</div>
		</div>
	</div>		
	@endif			
</div>

@stop


@section('footjs')

<script type="text/javascript">
	// $(function(){
	// 	$('.sublanding-container > .row').each(function(){
	// 		var title_years = $(this).find('.m-detach').detach();
	// 		$(this).find('.img-hero').append(title_years);
	// 	})
	// });
</script>

@stop