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
      $filter_parameters = ['items' => $items,'singleton'=>($filter["is_singleton"] == true?1:0),'collapsed'=>($filter["is_collapsed"] == true?1:0),'header'=>$filter["header"],"filter_type" => $filter["filter_type"], "display_count"=> $filter["display_count"], "is_attribute_param"=> $filter["is_attribute_param"], "disabled_at_zero_count"=> $filter["disabled_at_zero_count"]];
      if($filter["filter_type"] == "range_filter"){
        $filter_parameters["start"] = $filter["start"];
        $filter_parameters["end"] = $filter["end"];
      }
      ?>

      @include($file_name,$filter_parameters)

    @endforeach
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