<div class="container mt-4 mt-md-5 py-4">
    <!-- For Additional/Related links -->
	<ul class="related-search d-flex align-items-center py-3 py-md-0 pl-0 mb-0">
	@php foreach($params['related_search'] as $search) { @endphp
		<li class="related-search__links list-unstyled">
			<a href="{{$search['href']}}">
			{{$search['name']}}
				<i class="fas fa-chevron-right d-md-none"></i>
			</a>
		</li>
	@php } @endphp
	</ul>	
	<!-- Stories link -->
	<ul class="related-search d-flex align-items-center py-3 py-md-0 pl-0 stories-links mt-md-5">
		@php foreach($params['metatags'] as $metatag) { @endphp
		<li class="related-search__links list-unstyled">
			<a href="{{$metatag->href}}">
				{{$metatag->name}}
				<i class="fas fa-chevron-right d-md-none"></i>
			</a>
		</li>
		@php } @endphp
	</ul>
</div>