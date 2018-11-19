<script id="filter-availability-template" type="text/x-handlebars-template">
  <div class="kss_filter-list">
      <div id="headingTwo">
        <label class=" w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseAvailability" aria-expanded="false" aria-controls="collapseAvailability">
         @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseAvailability" class="collapse@{{#if collapsed}}@{{else}} show @{{/if}}" aria-labelledby="headingTwo" data-field="availability">
        <div class="card-body pt-2">
          @{{#each items}}
          <div class="custom-control custom-checkbox" data-val="@{{display_count_val}}" >
            <input type="checkbox" class="facet-category custom-control-input" onChange="facetCategoryChange(this,true,false,true);" name="availability" value="@{{facet_value}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}" data-singleton="false" data-slug="@{{slug}}" @{{#if ../disabled_at_zero_count}} @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}} @{{/if}} data-collapsable="@{{../collapsed}}" data-attribute-slug="@{{../attribute_slug}}">
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
<div id="filter-availability-template-content"></div>
@section('footjs-availability')
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-availability-template").innerHTML;
   var template = Handlebars.compile(source);
   Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
    console.log("arg1=="+arg1+"===="+arg2)
      return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
  });
   Handlebars.registerHelper('assign', function (varName, varValue, options) {
    console.log("varval=="+varValue)
    if (!options.data.root) {
      options.data.root = {};
    }
    options.data.root[varName] = varValue;
  });
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   var display_count = <?= json_encode($display_count) ?>;
   var disabled_at_zero_count = <?= json_encode($disabled_at_zero_count) ?>;
   var is_attribute_param = <?= json_encode($is_attribute_param) ?>;
   console.log("availability----")
   var context = {};
   context["collapsed"] = collapsed;
   context["display_count"] = display_count;
   context["disabled_at_zero_count"] = disabled_at_zero_count;
   context["is_attribute_param"] = is_attribute_param;
   context["attribute_slug"] = <?= json_encode($attribute_slug) ?>;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-availability-template-content").innerHTML = html;
 </script>
 @stop