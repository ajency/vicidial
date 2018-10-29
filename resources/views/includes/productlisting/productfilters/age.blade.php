<script id="filter-age-template" type="text/x-handlebars-template">
  <div class="kss_filter-list">
      <div id="headingTwo">
        <label class=" w-100 collapsed" data-toggle="collapse" data-target="#collapseAge" aria-expanded="false" aria-controls="collapseAge">
         Age<i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapseAge" class="collapse" aria-labelledby="headingTwo" >
        <div class="card-body">
       		@{{#each items}}
          @{{#if is_singleton}}
          <div >
            <input type="radio" name="gender" value="@{{slug}}" @{{#if is_selected }} checked = "checked" @{{/if}}>
            <label for="@{{display_name}}">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div>
          @{{else}}
          <div class="custom-control custom-checkbox">
            <input type="checkbox" value="@{{slug}}" class="custom-control-input" @{{#if is_selected }} checked = "checked" @{{/if}}>
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div>     
          @{{/if}}
          @{{/each}}
        </div>
      </div>
    </div>
</script>
<div id="filter-age-template-content"></div>
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-age-template").innerHTML;
   var template = Handlebars.compile(source);
   var context = { "items" : <?= json_encode($items); ?> };
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-age-template-content").innerHTML = html;
 </script>