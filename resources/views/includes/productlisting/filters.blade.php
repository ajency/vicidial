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
      $filter_parameters = ['items' => $items,'collapsed'=>($filter["is_collapsed"] == true?1:0),'header'=>$filter["header"],"filter_type" => $filter["filter_type"], "display_count"=> $filter["display_count"], "is_attribute_param"=> $filter["is_attribute_param"], "disabled_at_zero_count"=> $filter["disabled_at_zero_count"],'template'=>$filter["template"]];
      if(isset($filter["is_singleton"])){
        $filter_parameters['singleton'] = ($filter["is_singleton"] == true?1:0);
      }
      if($filter["filter_type"] == "boolean_filter"){
        $filter_parameters["attribute_slug"]=$filter["attribute_slug"];
      }
      if($filter["filter_type"] == "range_filter"){
        $filter_parameters["bucket_range"] = $filter["bucket_range"];
        $filter_parameters["selected_range"] = $filter["selected_range"];
      }
      ?>

      @include($file_name,$filter_parameters)

    @endforeach
      <div class="fixed-bottom d-none footer-filter">
            <div class="row no-gutters">
                <!-- <div class="col-6 text-center">
                  <button type="button" class=" btn btn-lg btn-block btn-link text-dark mt-1 mb-1">Clear All</button>
                </div> -->
                <div class="col-12 text-center d-flex">
                    <button type="button" id="kss_hide-filter" class="btn kss-btn kss-btn--big">Apply</button>
                </div>
            </div>
        </div>
  </div>
</div>