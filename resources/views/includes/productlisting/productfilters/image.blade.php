<script id="filter-image-template" type="text/x-handlebars-template">
  <div class="kss_filter-list" data-filter="@{{template}}">
      <div class="filter-heading">
        <label class=" w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseAvailability" aria-expanded="false" aria-controls="collapseAvailability">
         @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseAvailability" class="collapse@{{#if collapsed}}@{{else}} show @{{/if}}" data-field="@{{template}}">
        <div class="card-body pt-2">
          @{{#each items}}
          <div class="custom-control custom-checkbox" data-val="@{{display_count_val}}" >
            @{{> checkboxTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this,true,false,true);" attribute_slug=attribute_slug display_name=display_name filter_type=../filter_type }}
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}}
            @{{#if ../display_count }}
            <span class="sub-text">(@{{count}})</span>
            @{{/if}}
            </label>
          </div>
          @{{/each}}
        </div>
      </div>
    </div>
</script>
<div id="filter-image-template-content"></div>
@section('footjs-image')
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-image-template").innerHTML;
   var template = Handlebars.compile(source);
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   var display_count = <?= json_encode($display_count) ?>;
   var disabled_at_zero_count = <?= json_encode($disabled_at_zero_count) ?>;
   var is_attribute_param = <?= json_encode($is_attribute_param) ?>;
   var context = {};
   context["template"] = '<?= $template ?>';
   context["filter_type"] = '<?= $filter_type ?>';
   context["collapsed"] = collapsed;
   context["display_count"] = display_count;
   context["disabled_at_zero_count"] = disabled_at_zero_count;
   context["is_attribute_param"] = is_attribute_param;
   context["attribute_slug"] = <?= json_encode($attribute_slug) ?>;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   var html    = template(context);
   document.getElementById("filter-image-template-content").innerHTML = html;
 </script>
 @stop