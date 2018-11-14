<div class="col-sm-12 col-md-3">
  <div id="accordion" class="kss_filter d-sm-block">
<!--     <%= filters %> -->
    <?php 
    $filters_arr = json_decode(json_encode($filters),true);
    usort($filters_arr, function($a, $b) { 
          return $a["order"] > $b["order"] ? 1 : -1; 
      }); 
    // dd($filters_arr);
    ?>
    @foreach($filters_arr as $filter)
      <?php 
      $file_name = 'includes.productlisting.productfilters.' . $filter["template"]; 
      $items = $filter["items"];
      usort($items, function($a, $b) { 
          return $a["sequence"] > $b["sequence"] ? 1 : -1; 
      }); 
      $filter_parameters = ['items' => $items,'singleton'=>($filter["is_singleton"] == true?1:0),'collapsed'=>($filter["is_collapsed"] == true?1:0),'header'=>$filter["header"],"filter_type" => $filter["filter_type"]];
      if($filter["filter_type"] == "range_filter"){
        $filter_parameters["start"] = $filter["start"];
        $filter_parameters["end"] = $filter["end"];
      }
      ?>

      @include($file_name,$filter_parameters)

    @endforeach
   <!-- //gender -->

 <!--    <div class="kss_filter-list">
      <div id="headingTwo">
        <label class=" w-100 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         Size<i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" >
        <div class="card-body">
       		<div class="custom-control custom-checkbox">
      		  <input type="checkbox" class="custom-control-input" id="customCheck7" disabled>
      		  <label class="custom-control-label f-w-4" for="customCheck7">1-12M <span class="sub-text">(03)</span></label>
      		</div>
      		<div class="custom-control custom-checkbox">
      		  <input type="checkbox" class="custom-control-input" id="customCheck8" disabled>
      		  <label class="custom-control-label f-w-4" for="customCheck8">2-3Y <span class="sub-text">(20)</span></label>
      		</div>
      		<div class="custom-control custom-checkbox">
      		  <input type="checkbox" class="custom-control-input" id="customCheck9">
      		  <label class="custom-control-label f-w-4" for="customCheck9">4-5Y <span class="sub-text">(23)</span></label>
    		  </div>
            <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck10">
            <label class="custom-control-label f-w-4" for="customCheck10">6-7Y <span class="sub-text">(43)</span></label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck11">
            <label class="custom-control-label f-w-4" for="customCheck11">8-9Y <span class="sub-text">(03)</span></label>
          </div>
        </div>
      </div>
    </div> -->






<!--     <div class="kss_filter-list">
      <div id="headingThree">
        <label class=" w-100 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          Tags<i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseFour" class="collapse" aria-labelledby="headingThree" >
        <div class="card-body">
     	    <div class="btn-group mb-1" role="group" aria-label="first group">
          <button type="button" class="btn btn-outline-dark"><i class="fas fa-tag"></i> Toon Tshirt</button>
        </div>
         <div class="btn-group  mb-1" role="group" aria-label="second group">
          <button type="button" class="btn btn-outline-dark"><i class="fas fa-tag"></i> Character Tshirt</button>
        </div>
          <div class="btn-group  mb-1" role="group" aria-label="first group">
          <button type="button" class="btn btn-outline-dark"><i class="fas fa-tag"></i> Diwali Collection </button>
        </div>
         <div class="btn-group  mb-1" role="group" aria-label="second group">
          <button type="button" class="btn btn-outline-dark"><i class="fas fa-tag"></i> Beach Wear</button>
        </div>
          <div class="btn-group  mb-1" role="group" aria-label="first group">
          <button type="button" class="btn btn-outline-dark"><i class="fas fa-tag"></i> Party Wear</button>
        </div>
         <div class="btn-group  mb-1" role="group" aria-label="second group">
          <button type="button" class="btn btn-outline-dark"><i class="fas fa-tag"></i> School Uniform</button>
        </div>
        </div>
      </div>
    </div> -->
<!--       <div class="kss_filter-list">
      <div id="headingfive">
        <label class=" w-100 collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseTwo">
         Brand<i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseFive" class="collapse" aria-labelledby="headingfive" >
        <div class="card-body">
         <div class="custom-control custom-radio">
            <input type="radio" id="radio3" name="radioDisabled" id="customRadioDisabled" class="custom-control-input" disabled>
           <label class="custom-control-label" for="customRadioDisabled">Brand 1</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
            <label class="custom-control-label" for="customRadio2">Brand 2</label>
          </div>
           <div class="custom-control custom-radio">
            <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
            <label class="custom-control-label" for="customRadio3">Brand 3</label>
          </div>
        </div>
      </div>
    </div> -->
      <div class="fixed-bottom d-none footer-filter">
            <div class="row no-gutters px-2 py-2">
                <div class="col-6 text-center">
                  <button type="button" class=" btn btn-lg btn-block btn-link text-dark mt-1 mb-1">Clear All</button>
      
                </div>
                <div class="col-6 text-center">
                    <button type="button" class="btn btn-lg btn-block btn-primary mt-1 mb-1">Apply</button>
                </div>
            </div>
        </div>
  </div>
</div>