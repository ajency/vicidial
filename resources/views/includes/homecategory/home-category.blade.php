<div class="cat-container">
	@foreach($categories as $category)
		@if ($category['type'] == 'category_box_large')
			@include('includes.homecategory.styles.box-big', ['category' => $category])
		@elseif ($category['type'] == 'category_box_medium')
			@include('includes.homecategory.styles.box-medium', ['category' => $category])
		@elseif ($category['type'] == 'category_box_small')
			@include('includes.homecategory.styles.box-small', ['category' => $category])
		@elseif ($category['type'] == 'category_landscape')
			@include('includes.homecategory.styles.landscape', ['category' => $category])
		@elseif ($category['type'] == 'category_portrait')
			@include('includes.homecategory.styles.portrait', ['category' => $category])
		@endif
	@endforeach
</div>