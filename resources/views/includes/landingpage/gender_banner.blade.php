<picture>
   <source media="(orientation: landscape)"   		
	  data-srcset="{{$banner['images']['landscape']['3x']}} 1536w,
	              {{$banner['images']['landscape']['2x']}} 1024w,
	              {{$banner['images']['landscape']['1x']}} 512w"	                          
			        sizes="57vw">

   <source media="(orientation: portrait)"
		data-srcset="{{$banner['images']['portrait']['3x']}} 1200w,
				    {{$banner['images']['portrait']['2x']}} 700w,
		      		{{$banner['images']['portrait']['1x']}} 400w"
				sizes="100vw">

   <img   	   
		src="{{$banner['images']['landscape']['load']}}"
		data-sizes="100vw"
		class="img-fluid lazyload blur-up w-100"
		alt="{{$banner['element_data']['image']['img_alt']}}"
		title="{{$banner['element_data']['image']['title']}}">
</picture>