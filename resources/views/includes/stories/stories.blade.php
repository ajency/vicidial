<div class="stories-grid stories-wrapper">
	@foreach($stories as $story)
		@if ($story['type'] == 'story_box_medium')
			@include('includes.stories.styles.box-medium', ['story' => $story])
		@elseif ($story['type'] == 'story_landscape', ['story' => $story])
			@include('includes.stories.styles.landscape')
		@elseif ($story['type'] == 'story_portrait', ['story' => $story])
			@include('includes.stories.styles.portrait')
		@endif
	@endforeach
</div>