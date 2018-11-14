<script id="filter-age-template" type="text/x-handlebars-template">
  <div class="kss_filter-list">
      <div id="headingTwo">
        <label class=" w-100 mb-0 pb-2 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseAge" aria-expanded="false" aria-controls="collapseAge">
         @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseAge" class="collapse @{{#if collapsed}} @{{else}} show @{{/if}}" aria-labelledby="headingTwo" >
        <div class="card-body">
          @{{#if singleton }}
          @{{#each items}}
          <div class="custom-radio custom-control">
            <input type="radio" class="facet-category custom-control-input" onChange="facetCategoryChange(this);" name="age" value="@{{facet_value}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}" data-singleton="true" data-slug="@{{slug}}" @{{#if disabled_at_zero_count}} @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}} @{{/if}}>
            <label for="@{{display_name}}" class="custom-control-label f-w-4">@{{display_name}} 
            @{{#if display_count }}
              <span class="sub-text">(@{{count}})</span>
            @{{/if}}
            </label>
          </div>
          @{{/each}}
          @{{else}}
          @{{#each items}}
          <div class="custom-control custom-checkbox" >
            <input type="checkbox" class="facet-category custom-control-input" onChange="facetCategoryChange(this);" name="age" value="@{{facet_value}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}" data-singleton="false" data-slug="@{{slug}}" @{{#if disabled_at_zero_count}} @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}} @{{/if}}>
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}} 
            @{{#if display_count }}
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
<div id="filter-age-template-content"></div>
@section('footjs-age')
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-age-template").innerHTML;
   var template = Handlebars.compile(source);
   Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
      return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
  });
   var singleton = (<?= $singleton ?> == 1)?true:false;
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   console.log("age----"+<?= $singleton ?>)
   var context = {};
   context["singleton"] = singleton;
   context["collapsed"] = collapsed;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-age-template-content").innerHTML = html;
 </script>
 @stop