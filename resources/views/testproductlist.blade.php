<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
@foreach ($links as $link)
    <p><a href="{{$link}}"> {{ $link }}</a></p>
@endforeach

</body>
</html>