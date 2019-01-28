<div class="stories-grid stories-wrapper">
	@foreach($stories as $story)
		@if ($story['type'] == 'story_box_medium')
			@include('includes.stories.styles.box-medium', ['story' => $story])
		@elseif ($story['type'] == 'story_landscape')
			@include('includes.stories.styles.landscape', ['story' => $story])
		@elseif ($story['type'] == 'story_portrait')
			@include('includes.stories.styles.portrait', ['story' => $story])
		@endif
	@endforeach
</div>