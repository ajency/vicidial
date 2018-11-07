<script id="filter-category-template" type="text/x-handlebars-template"> 
  <div class="kss_filter-list mt-1">
      <div class="d-md-none d-block">
        <div class="d-flex">
          <div><h4 class="mt-0">Filter By</h4></div>
          <div class="ml-auto"> <h3 id="kss_hide-filter" class="m-0 kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3></div>
        </div>
        <hr>
      </div>
      <div id="headingTwo">
        <label class=" w-100 @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
         @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseCategory" class="collapse @{{#if collapsed}} @{{else}} show @{{/if}}" aria-labelledby="headingTwo" >
        <div class="card-body">
          @{{#if singleton }}
          @{{#each items}}
          <div class="custom-radio custom-control">
            <input type="radio" class="facet-category custom-control-input" name="category" value="@{{facet_value}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}" data-singleton="true" data-slug="@{{slug}}" @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}}>
            <label for="@{{display_name}}" class="custom-control-label f-w-4">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div>
          @{{/each}}
          @{{else}}
          @{{#each items}}
          <div class="custom-control custom-checkbox" >
            <input type="checkbox" class="facet-category custom-control-input" name="category" value="@{{facet_value}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}" data-singleton="false" data-slug="@{{slug}}" @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}}>
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
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
   Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
      return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
  });
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   var context = {};
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