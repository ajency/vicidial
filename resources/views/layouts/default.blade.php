<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>


<div class="header">
    @include('includes.header')
</div>

<div id="main">

        @yield('content')

</div>

<footer class="bg-light mt-5 pb-5 pt-5">
    @include('includes.footer')
</footer>

@include('includes.foot')

</body>
</html>