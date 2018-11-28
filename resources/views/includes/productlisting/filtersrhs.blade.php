<div class="kss_filter_mobile--right">
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
            $file_name = ($filter["template"] != null)?'includes.productlisting.productfilters.' . $filter["template"]:'';
            $items = $filter["items"];
            $filter_parameters = ['items' => $items,'collapsed'=>($filter["is_collapsed"] == true?1:0),'header'=>$filter["header"],"filter_type" => $filter["filter_type"], "display_count"=> $filter["display_count"], "is_attribute_param"=> $filter["is_attribute_param"], "disabled_at_zero_count"=> $filter["disabled_at_zero_count"],'template'=>$filter["template"],'custom_attributes'=>$filter["custom_attributes"]];
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
            if($filter["template"] != null)
            {
            ?>
            @include($file_name,$filter_parameters)
            <?php
            }
            ?>
        @endforeach
      </div>
    </div>