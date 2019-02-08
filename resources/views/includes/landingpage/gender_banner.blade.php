<picture>
   <source media="(orientation: landscape)"
	  data-srcset="{{$landing['images']['landscape']['3x']}} 1536w,
	              {{$landing['images']['landscape']['2x']}} 1024w,
	              {{$landing['images']['landscape']['1x']}} 512w" 
			      media="(min-width: 1200) 48vw, (min-width: 992px) 57vw">

   <source media="(orientation: portrait)"
		data-srcset="{{$landing['images']['portrait']['3x']}} 1200w,
				    {{$landing['images']['portrait']['2x']}} 700w,
		      		{{$landing['images']['portrait']['1x']}} 400w"
				media="(min-width: 768px) 57vw, 100vw">
   <img   	   
		src="{{$landing['images']['landscape']['load']}}"
		data-sizes="100vw"
		class="img-fluid lazyload blur-up w-100"
		alt="{{$landing['element_data']['image']['img_alt']}}"
		title="{{$landing['element_data']['image']['title']}}">
</picture>