<script id="filter-color-template" type="text/x-handlebars-template">
      <div class="kss_filter-list" data-filter="@{{template}}">
        <div class="filter-heading">
          <label class="w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseColor" aria-expanded="false" aria-controls="collapseColor">
            @{{filter_display_name}}<i class="fas fa-angle-up float-right"></i>
          </label>
        </div>
        <div id="collapseColor" class="collapse@{{#if show_more}} color-wrapper @{{/if}} @{{#if collapsed}}@{{else}} show @{{/if}}" data-field="@{{template}}">
          <div class="card-body pt-2 pb-2">
             @{{#if singleton }}
             @{{#each items}}
              <div class="custom-control custom-radio color-filter d-flex">
              @{{> radioTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" display_name=display_name filter_type=../filter_type }}
                <label class="custom-control-label f-w-4 d-flex align-items-center" for="@{{facet_value}}">
                  <span class="color-box" style="background-color:@{{facet_value}};"></span>
                  <span class="color-name pl-2 text-capitalize">@{{display_name}}</span>
                  <!-- <span class="sub-text filter-count pl-1">(150)</span> -->
                  @{{#if ../display_count }}
                    <span class="sub-text filter-count pl-1">(@{{count}})</span>
                  @{{/if}}
                </label>
              </div>
              @{{/each}}
              @{{else}}
              @{{#each items}}
              <div class="custom-control custom-checkbox color-filter d-flex">
                @{{> checkboxTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" display_name=display_name filter_type=../filter_type }}
                <label class="custom-control-label f-w-4 d-flex align-items-center" for="@{{facet_value}}">
                  <span class="color-box" style="background-color:@{{facet_value}};"></span>
                  <span class="color-name pl-2 text-capitalize">@{{display_name}}</span>
                  <!-- <span class="sub-text filter-count pl-1">(150)</span> -->
                  @{{#if ../display_count }}
                    <span class="sub-text filter-count pl-1">(@{{count}})</span>
                  @{{/if}}
                </label>
              </div>
              @{{/each}}
              @{{/if}}
          </div>
          <span class="more-color">+ more</span>
        </div>
    </div>
</script>
<div id="filter-color-template-content"></div>
@section('footjs-color')
<?php
  $selected_colors = array_column($items, 'is_selected');
  $show_more_limit = 10;
  $max_selected_index = array_search(true, array_reverse($selected_colors,true))+1;
  $show_more = ($show_more_limit > $max_selected_index)?true:false;
  // dd($show_more);
  // dd($selected_colors,array_search(true, array_reverse($selected_colors,true)));
?>
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-color-template").innerHTML;
   var template = Handlebars.compile(source);
   var singleton = (<?= $singleton ?> == 1)?true:false;
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   var display_count = <?= json_encode($display_count) ?>;
   var disabled_at_zero_count = <?= json_encode($disabled_at_zero_count) ?>;
   var is_attribute_param = <?= json_encode($is_attribute_param) ?>;
   var context = {};
   context["template"] = '<?= $template ?>';
   context["filter_type"] = '<?= $filter_type ?>';
   context["singleton"] = singleton;
   context["collapsed"] = collapsed;
   context["display_count"] = display_count;
   context["show_more"] = <?= json_encode($show_more);?>;
   context["disabled_at_zero_count"] = disabled_at_zero_count;
   context["is_attribute_param"] = is_attribute_param;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   var html    = template(context);
   document.getElementById("filter-color-template-content").innerHTML = html;
 </script>
 @stop