<script id="filter-color-template" type="text/x-handlebars-template">
      <div class="kss_filter-list">
        <div id="headingThree">
          <label class="w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseColor" aria-expanded="false" aria-controls="collapseColor">
            @{{filter_display_name}}<i class="fas fa-angle-up float-right"></i>
          </label>
        </div>
        <div id="collapseColor" class="collapse@{{#if collapsed}}@{{else}} show @{{/if}}" aria-labelledby="headingThree" data-field="color">
          <div class="card-body pt-2">
         
            <ul class="product-color product-color--filter p-0">
             @{{#if singleton }}
             @{{#each items}}
              <li>
              @{{> radioTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" display_name=display_name }}
              <label for="@{{facet_value}}" style="background-color:@{{facet_value}};"></label>
              </li>
              @{{/each}}
              @{{else}}
              @{{#each items}}
              <li>
              @{{> checkboxTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" display_name=display_name }}
              <label for="@{{facet_value}}" style="background-color:@{{facet_value}};"></label>
              </li>
              @{{/each}}
              @{{/if}}
            </ul>

          </div>
        </div>
    </div>
</script>
<div id="filter-color-template-content"></div>
@section('footjs-color')
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
   console.log("color----"+<?= $singleton ?>)
   var context = {};
   context["template"] = '<?= $template ?>';
   context["singleton"] = singleton;
   context["collapsed"] = collapsed;
   context["display_count"] = display_count;
   context["disabled_at_zero_count"] = disabled_at_zero_count;
   context["is_attribute_param"] = is_attribute_param;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-color-template-content").innerHTML = html;
 </script>
 @stop