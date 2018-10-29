 
<script id="filter-gender-template" type="text/x-handlebars-template">
   <div class="kss_filter-list">
      <div class="d-md-none d-block">
  
      <div class="d-flex">
      <div><h4 class="mt-0">Filter By</h4></div>
      <div class="ml-auto"> <h3 id="kss_hide-filter" class="m-0 kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3></div>
    </div>
        <hr>
      </div>
      <div id="headingOne">
        <label class="w-100" data-target="#collapseGender" aria-expanded="true" aria-controls="collapseGender">
            Gender <i class="fas fa-angle-up float-right"></i>
        </label>
      </div>

      <div id="collapseGender" class="collapsed show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
          
          @{{#if singleton }}
          @{{#each items}}
          <div >
            <input type="radio" name="gender" value="@{{slug}}" @{{#if is_selected }} checked = "checked" @{{/if}}>
            <label for="@{{display_name}}">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div>
          @{{/each}}
          @{{else}}
          @{{#each items}}
          <div class="custom-control custom-checkbox" >
            <input type="checkbox" ame="gender" value="@{{slug}}" class="custom-control-input" @{{#if is_selected }} checked = "checked" @{{/if}}>
            <label class="custom-control-label f-w-4" for="@{{display_name}}">@{{display_name}} <span class="sub-text">(@{{count}})</span></label>
          </div> 
          @{{/each}}    
          @{{/if}}
          
       
        
        </div>
      </div>
    </div>
</script>
<div id="filter-gender-template-content"></div>
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-gender-template").innerHTML;
   var template = Handlebars.compile(source);
   var singleton = (<?= $singleton ?> == 1)?true:false;
   var context = {};
   context["singleton"] = singleton;
   context["items"] = <?= json_encode($items); ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-gender-template-content").innerHTML = html;
 </script>


