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
              @php if($params['additional_info']->gender) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Gender</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->gender}}</dd>
              @php } @endphp

              @php if($params['additional_info']->age_group) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Age Group</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->age_group}}</dd>
              @php } @endphp

              @php if($params['additional_info']->sleeves) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Sleeves</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->sleeves}}</dd>
              @php } @endphp

              @php if($params['additional_info']->material) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Material</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->material}}</dd>
              @php } @endphp

              @php if($params['additional_info']->occasion) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Occasion</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->occasion}}</dd>
              @php } @endphp

              @php if($params['additional_info']->wash) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Wash</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->wash}}</dd>
              @php } @endphp

              @php if($params['additional_info']->fabric_type) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Fabric Type</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->fabric_type}}</dd>
              @php } @endphp

              @php if($params['additional_info']->product_type) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Product Type</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->product_type}}</dd>
              @php } @endphp

              @php if($params['additional_info']->other_attribute) { @endphp
              <dt class="col-4 col-sm-3"><label class="text-muted f-w-4">Other Attribute</label></dt>
              <dd class="col-8 col-sm-9">{{$params['additional_info']->other_attribute}}</dd>
              @php } @endphp

            </dl>
        </div>
    </div>
  </div>
  @php } @endphp
  <!-- <div class="">
    <div class="collapse-head border-bottom mb-0" id="headingThree">
        <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <label class="mb-0 text-body cursor-pointer">
                Reviews
            </label>
        </button>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body pb-2 px-0">
        <blockquote class="blockquote mb-4">
          <h6 class="mb-1"><strong>It fits perfect and he loved it.</strong></h6>
          <footer class="blockquote-footer"><span class="badge badge-success"><i class="fas fa-star"></i> 4.5 </span> Seema Kothrud, Pune <cite title="Source Title">7 Jul, 2018</cite></footer>
        </blockquote>
         <blockquote class="blockquote mb-4">
          <h6 class="mb-1"><strong>I didn't realize you had clothes for 2T and they're super cute and affordable.</strong></h6>
          <footer class="blockquote-footer"><span class="badge badge-success"><i class="fas fa-star"></i> 4.5 </span> Seema Kothrud, Pune <cite title="Source Title">7 Jul, 2018</cite></footer>
        </blockquote>

      </div>
    </div>
  </div> -->
</div>