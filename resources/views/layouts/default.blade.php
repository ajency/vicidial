<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body @isset($overflow) class = "overflow-h" @endisset>


<div class="header">
    @include('includes.header')
</div>

<div id="main">

        @yield('content')
		@include('cart')

</div>

@include('includes.scroll')
<div class="container d-block d-md-none my-4 @isset($sticky_btn) sticky_btn_bottom @endisset">
	<div class="row">
		<div class="col-sm-12">
			  <a class="mb-2 py-2 footer-more collapsed" data-toggle="collapse" href="#moreFooter"><span class="space-divider d-flex align-items-center justify-content-between"><span class="footer-more__title">More about Online Shopping at KidSuperStore</span> <i class="fas fa-angle-down icon-down"></i></span></a>
		</div>
	</div>
</div>

<div class="collapse hidden-footer-section" id="moreFooter">
	<footer class="bg-light mt-2 mt-md-4 pb-1 pt-3 pt-md-5">
	    @include('includes.footer')
	</footer>
</div>

@include('includes.foot')

</body>
</html>