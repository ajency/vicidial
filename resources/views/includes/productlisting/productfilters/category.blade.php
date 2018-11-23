<script id="filter-category-template" type="text/x-handlebars-template"> 
  <div class="kss_filter-list mt-1">
      <div class="d-md-none d-block sticky-mob-filter">
        <div class="d-flex">
          <div class="filter-head">
            <h4 class="mt-0">Filter</h4>
            <p class="filter-head__caption">@{{filter_count}} Filters Applied</p>
          </div>
          <div class="ml-auto"> <h3 id="kss_hide-filter" class="m-0 kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3></div>
        </div>
      </div>
      <hr class="sticky-space">
      <div id="headingTwo">
        <label class=" w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
         @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseCategory" class="collapse@{{#if collapsed}}@{{else}} show @{{/if}}" aria-labelledby="headingTwo" data-field="category">
        <div class="card-body pt-2">
          @{{#if singleton }}
          @{{#each items}}
          <div class="custom-radio custom-control">
            @{{> radioTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" display_name=display_name }}
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
            @{{> checkboxTemplate template=../template facet_value=facet_value is_selected=is_selected filter_facet_name=../filter_facet_name slug=slug disabled_at_zero_count=../disabled_at_zero_count count=count collapsed=../collapsed changeEvent="facetCategoryChange(this);" attribute_slug="" display_name=display_name }}
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
<div id="filter-category-template-content"></div>
@section('footjs-category')
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-category-template").innerHTML;
   var template = Handlebars.compile(source);
   var singleton = (<?= $singleton ?> == 1)?true:false;
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   var context = {};
   var display_count = <?= json_encode($display_count) ?>;
   var disabled_at_zero_count = <?= json_encode($disabled_at_zero_count) ?>;
   var is_attribute_param = <?= json_encode($is_attribute_param) ?>;
   context["template"] = '<?= $template ?>';
   context["filter_count"] = filter_tags_list.length;
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
   document.getElementById("filter-category-template-content").innerHTML = html;
 </script>
 @stop