<div class="cat-item cat-{{$category['sequence']}} position-relative kss-extension" static_element-id="{{$category['sequence']}}" static_element-display_type="Styles In Focus" static_element-type="{{$category['type']}}">
  <a href="{{$category['element_data']['image']['href']}}">
    <div>{!!$category['element_data']['text']['text1']!!}</div>
    @if (isset($category['images']['original']))
    <img class="d-block w-100 img-fluid lazyload blur-up" src="{{$category['images']['default']['load']}}" 
    data-srcset="{{$category['images']['original']}}" alt="{{$category['element_data']['image']['img_alt']}}" title="{{$category['element_data']['image']['title']}}" />
    @else
    <img class="d-block w-100 img-fluid lazyload blur-up"
        src="{{$category['images']['default']['load']}}"
        data-srcset="{{$category['images']['default']['3x']}} 818w,
                      {{$category['images']['default']['2x']}} 409w,
                      {{$category['images']['default']['1x']}} 272w"
        data-sizes='(min-width: 1200px) 370px, (min-width: 768px) and (max-width: 991px) 46vw, (max-width: 992px) 92vw,  31vw'
        alt="{{$category['element_data']['image']['img_alt']}}"
        title="{{$category['element_data']['image']['title']}}" />
    @endif
    <div>{!!$category['element_data']['text']['text2']!!}</div>
  </a>
</div>