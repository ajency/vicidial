<nav aria-label="breadcrumb" class="">
	<ol class="breadcrumb mb-1 bg-transparent p-0">
	@if(isset($shop))
		<li class="breadcrumb-item"><a href="/shop">Shop</a></li>
	@else
		<li class="breadcrumb-item"><a href="/">Home</a></li>
	@endif
	@php foreach ($breadcrumbs['list'] as $item) { @endphp
	    <li class="breadcrumb-item"><a href="{{$item['href']}}">{{$item['name']}}</a></li>
    @php } @endphp
    @php if($breadcrumbs['current']!='') { @endphp
    	<li class="breadcrumb-item active"><a>{{$breadcrumbs['current']}}</a></li>
    @php } @endphp
	</ol>
</nav>