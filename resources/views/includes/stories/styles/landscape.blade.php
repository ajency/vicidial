<div class="story-{{$story['sequence']}} position-relative kss-extension" static_element-id="{{$story['sequence']}}" static_element-display_type="Shop By Stories" static_element-type="{{$story['type']}}">
    <a href="{{$story['element_data']['image']['href']}}" class="position-relative trend-box d-block link-card" style="order:0;">
        <p class="custom-text text-uppercase">{!!$story['element_data']['text']['text1']!!}</p>
        @if (isset($story['images']['original']))
        <img class="d-block w-100 img-fluid lazyload blur-up pb-1" src="{{$story['images']['default']['load']}}" 
        data-srcset="{{$story['images']['original']}}" alt="{{$story['element_data']['image']['img_alt']}}" title="{{$story['element_data']['image']['title']}}" />
        @else
        <img class="d-block w-100 img-fluid lazyload blur-up pb-1"
            src="{{$story['images']['default']['load']}}"
            data-srcset="{{$story['images']['default']['3x']}} 1553w,
                         {{$story['images']['default']['2x']}} 778w,
                         {{$story['images']['default']['1x']}} 521w"
            data-sizes='(min-width: 1200px) 780px, (max-width: 992px) 90vw, 63vw'
            alt="{{$story['element_data']['image']['img_alt']}}"
            title="{{$story['element_data']['image']['title']}}"/>
        <p class="custom-text text-uppercase">{!!$story['element_data']['text']['text2']!!}</p>
         @endif
    </a>
</div>