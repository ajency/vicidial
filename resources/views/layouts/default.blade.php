<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body @isset($overflow) class = "overflow-hidden" @endisset>


<div class="header">
    @include('includes.header')
</div>

<div id="main">

        @yield('content')
		@include('cart') 
</div>

@include('includes.scroll')

<footer class="bg-light mt-5 pb-1 pt-5">
    @include('includes.footer')
</footer>

@include('includes.foot')

</body>
</html>