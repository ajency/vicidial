<div class="accordion product-collapse" id="accordionExample">
  @php if($params['description']) { @endphp
  <div class="">
    <div class="collapse-head border-bottom mb-0" id="headingOne">
        <button class="btn btn-link btn-block text-left py-3 px-0 br-0 " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <label class="mb-0 text-body cursor-pointer">
                Details
            </label>
        </button>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body pb-2 px-0">
            <p>{{$params['description']}}</p>
        </div>
    </div>
  </div>
  @php } @endphp

  @php if($params['additional_info']) { @endphp
  <div class="">
    <div class="collapse-head border-bottom mb-0" id="headingTwo">
        <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <label class="mb-0 text-body cursor-pointer">
                Additional Info
            </label>
        </button>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body pb-2 px-0">
            <dl class="row">
              @php if($params['additional_info']->product_gender) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Gender</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->product_gender}}</dd>
              @php } @endphp

              @php if($params['additional_info']->product_age_group) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Age Group</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->product_age_group}}</dd>
              @php } @endphp

              @php if($params['additional_info']->sleeves) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Sleeves</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->sleeves}}</dd>
              @php } @endphp

              @php if($params['additional_info']->material) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Material</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->material}}</dd>
              @php } @endphp

              @php if($params['additional_info']->occasion) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Occasion</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->occasion}}</dd>
              @php } @endphp

              @php if($params['additional_info']->wash) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Wash</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->wash}}</dd>
              @php } @endphp

              @php if($params['additional_info']->fabric_type) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Fabric Type</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->fabric_type}}</dd>
              @php } @endphp

              @php if($params['additional_info']->product_type) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Product Type</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->product_type}}</dd>
              @php } @endphp

              @php if($params['additional_info']->other_attribute) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Other Attribute</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->other_attribute}}</dd>
              @php } @endphp

              @php if($params['additional_info']->brand) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Brand</label></dt>
              <dd class="col-8 col-sm-9 text-capitalize">{{$params['additional_info']->brand}}</dd>
              @php } @endphp

            </dl>
        </div>
    </div>
  </div>
  @php } @endphp


  <div class="">
    <div class="collapse-head border-bottom mb-0" id="headingThree">
        <button class="btn btn-link btn-block text-left py-3 px-0 br-0" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <label class="mb-0 text-body cursor-pointer">
                Tags
            </label>
        </button>
    </div>
    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
        <div class="card-body pb-2 px-0">
          <ul class="list-inline d-flex flex-sm-wrap kss-tags">
            @php foreach($params['metatags'] as $metatag) { @endphp
              <li><a href="{{$metatag->href}}">{{$metatag->name}}</a></li>
            @php } @endphp
          </ul>
        </div>
    </div>
  </div>

</div>