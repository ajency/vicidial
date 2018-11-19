<script id="filter-subtype-template" type="text/x-handlebars-template">
  <div class="kss_filter-list">
      <div id="headingTwo">
        <label class=" w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseSubtype" aria-expanded="false" aria-controls="collapseSubtype">
         @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseSubtype" class="collapse@{{#if collapsed}}@{{else}} show @{{/if}}" aria-labelledby="headingTwo" data-field="subtype">
        <div class="card-body pt-2">
          @{{#if singleton }}
          @{{#each items}}
          <div class="custom-radio custom-control">
            @{{> radioTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" }}
            <label for="@{{display_name}}" class="custom-control-label f-w-4">@{{display_name}} 
              @{{#if ../display_count }}
              <span class="sub-text">(@{{count}})</span>
            @{{/if}}
            </label>
          </div>
          @{{/each}}
          @{{else}}
          @{{#each items}}
          <div class="custom-control custom-checkbox" >
            @{{> checkboxTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" }}
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}} 
              @{{#if ../display_count }}
              <span class="sub-text">(@{{count}})</span>
            @{{/if}}
            </label>
          </div> 
          @{{/each}}    
          @{{/if}}
        </div>
      </div>
    </div>
</script>
<div id="filter-subtype-template-content"></div>
@section('footjs-subtype')
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-subtype-template").innerHTML;
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
   context["display_count"] = display_count;
   context["disabled_at_zero_count"] = disabled_at_zero_count;
   context["is_attribute_param"] = is_attribute_param;
   context["singleton"] = singleton;
   context["collapsed"] = collapsed;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-subtype-template-content").innerHTML = html;
 </script>
 @stop