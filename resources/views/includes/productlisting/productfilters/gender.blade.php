 
<script id="filter-gender-template" type="text/x-handlebars-template">
   <div class="kss_filter-list">
      <div id="headingOne">
        <label class="w-100 @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapseGender" aria-expanded="true" aria-controls="collapseGender">
            @{{filter_display_name}} <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>

      <div id="collapseGender" class="collapse @{{#if collapsed}} @{{else}} show @{{/if}}" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
          
          @{{#if singleton }}
          @{{#each items}}
          <div class="custom-radio custom-control">
            <input type="radio" class="facet-category custom-control-input" name="gender" value="@{{slug}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}">
            <label for="@{{display_name}}" class="custom-control-label f-w-4">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div>
          @{{/each}}
          @{{else}}
          @{{#each items}}
          <div class="custom-control custom-checkbox" >
            <input type="checkbox" class="facet-category" name="gender" value="@{{slug}}" class="custom-control-input" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{../filter_facet_name}}">
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div> 
          @{{/each}}    
          @{{/if}}
          
       
        
        </div>
      </div>
    </div>
</script>
<div id="filter-gender-template-content"></div>
@section('footjs-gender')

  <script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-gender-template").innerHTML;
   var template = Handlebars.compile(source);
   var singleton = (<?= $singleton ?> == 1)?true:false;
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
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
   document.getElementById("filter-gender-template-content").innerHTML = html;
 </script>

@stop



