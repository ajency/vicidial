<!doctype html>
<html amp lang="en">
<head>
    @include('includes.amp-head')
</head>
<body @isset($overflow) class = "overflow-h" @endisset>

	<!-- Start Navbar -->
	<header class="ampstart-headerbar fixed flex justify-start items-center top-0 left-0 right-0 pl2 pr4 ">
	  	<div role="button" aria-label="open sidebar" on="tap:header-sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger  pr2  ">☰
	  	</div>
	  	<a href="/" class="flex">
	    	<amp-img src="{{CDN::asset('/img/logo-kss.png') }}" width="180" height="28" layout="fixed" class="my0 mx-auto " alt="The Blog"></amp-img>
	    </a>
	</header>

	<!-- Start Sidebar -->
	<amp-sidebar id="header-sidebar" class="ampstart-sidebar px3" layout="nodisplay">
	  	<div class="flex justify-start items-center ampstart-sidebar-header">
	    	<div role="button" aria-label="close sidebar" on="tap:header-sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger items-start">✕</div>
	  	</div>
		<nav class="ampstart-sidebar-nav ampstart-nav">
		    <ul class="list-reset m0 p0 ampstart-label">
		        <li class="ampstart-nav-item ampstart-nav-dropdown relative ">
					<!-- Start Dropdown-inline -->
					<amp-accordion layout="container" disable-session-states="" class="ampstart-dropdown">
					  	<section>
						    <header>Boys</header>
						    <ul class="ampstart-dropdown-items list-reset m0 p0">
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Clothing</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Shoes</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Accessories</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">All Products</a></li>
						    </ul>
					  	</section>
					</amp-accordion>
					<!-- End Dropdown-inline -->
	          	</li>
	          	<li class="ampstart-nav-item ampstart-nav-dropdown relative ">
					<!-- Start Dropdown-inline -->
					<amp-accordion layout="container" disable-session-states="" class="ampstart-dropdown">
					  	<section>
						    <header>Girls</header>
						    <ul class="ampstart-dropdown-items list-reset m0 p0">
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Clothing</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Shoes</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Accessories</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">All Products</a></li>
						    </ul>
					  	</section>
					</amp-accordion>
					<!-- End Dropdown-inline -->
	          	</li>
	          	<li class="ampstart-nav-item ampstart-nav-dropdown relative ">
					<!-- Start Dropdown-inline -->
					<amp-accordion layout="container" disable-session-states="" class="ampstart-dropdown">
					  	<section>
						    <header>Infants</header>
						    <ul class="ampstart-dropdown-items list-reset m0 p0">
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Clothing</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Shoes</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Accessories</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">All Products</a></li>
						    </ul>
					  	</section>
					</amp-accordion>
					<!-- End Dropdown-inline -->
	          	</li>
	          	<li class="ampstart-nav-item ampstart-nav-dropdown relative ">
					<!-- Start Dropdown-inline -->
					<amp-accordion layout="container" disable-session-states="" class="ampstart-dropdown">
					  	<section>
						    <header>Toys</header>
						    <ul class="ampstart-dropdown-items list-reset m0 p0">
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Baby Toys</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Plush</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">All Products</a></li>
						    </ul>
					  	</section>
					</amp-accordion>
					<!-- End Dropdown-inline -->
	          	</li>
	          	<li class="ampstart-nav-item ampstart-nav-dropdown relative ">
					<!-- Start Dropdown-inline -->
					<amp-accordion layout="container" disable-session-states="" class="ampstart-dropdown">
					  	<section>
						    <header>Stationery</header>
						    <ul class="ampstart-dropdown-items list-reset m0 p0">
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Bags</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Water Bottles</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Lunch Box/Pencil Case</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">Birthday Decoration</a></li>
						        <li class="ampstart-dropdown-item"><a href="#" class="text-decoration-none">All Products</a></li>
						    </ul>
					  	</section>
					</amp-accordion>
					<!-- End Dropdown-inline -->
	          	</li>
		    </ul>
		</nav>
	</amp-sidebar>
	<!-- End Sidebar -->

    @yield('content')

	@include('includes.amp-foot')

</body>
</html>