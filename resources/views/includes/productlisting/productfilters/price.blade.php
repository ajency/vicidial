<script id="filter-price-template" type="text/x-handlebars-template">
    <div class="kss_filter-list">
      <div id="headingThree">
        <label class="w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
          @{{filter_display_name}}<i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapsePrice" class="collapse @{{#if collapsed}} @{{else}} show @{{/if}}" aria-labelledby="headingThree" >
        <div class="card-body">
          <div class="priceRange">
            <input type="text" id="price-range" name="price" value="" data-facet-name="@{{filter_facet_name}}" data-singleton="true" data-slug="@{{slug}}" @{{#if ../disabled_at_zero_count}} @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}} @{{/if}}/>
          </div>
          <div class="row">
            <div class="col-5 col-sm-5">
           <input class="form-control form-control-lg text-muted price-change" value="@{{fromval}}" id="price-min" type="text" placeholder="Min">
            </div>
             <div class="col-2 col-sm-2 text-center">
              <h6 class="align-self-center mt-4">to</h6>
            </div>
              <div class="col-5 col-sm-5">
                 <input class="form-control form-control-lg text-muted price-change" value="@{{toval}}" id="price-max" type="text" placeholder="Max">
            </div>
          </div> 
        </div>
      </div>
    </div>
</script>

<div id="filter-price-template-content"></div>
@section('footjs-price')
<script type="text/javascript" >
   // require('handlebars');
   var source   = document.getElementById("filter-price-template").innerHTML;
   var template = Handlebars.compile(source);
   var priceRangeSlider;
   Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
      return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
  });
   var singleton = (<?= $singleton ?> == 1)?true:false;
   var collapsed = (<?= $collapsed ?> == 1)?true:false;
   var fromval =  <?= ($selected_range["start"])?($selected_range["start"]):0 ?>;
   var toval = <?= ($selected_range["end"])?($selected_range["end"]):0 ?>;
   var minval =  <?= $bucket_range["start"] ?>;
   var maxval = <?= $bucket_range["end"] ?>;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   var display_count = <?= json_encode($display_count) ?>;
   var disabled_at_zero_count = <?= json_encode($disabled_at_zero_count) ?>;
   var is_attribute_param = <?= json_encode($is_attribute_param) ?>;
   console.log("price----"+<?= $singleton ?>)
   var context = {};
   context["display_count"] = display_count;
   context["disabled_at_zero_count"] = disabled_at_zero_count;
   context["is_attribute_param"] = is_attribute_param;
   context["singleton"] = singleton;
   context["collapsed"] = collapsed;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   context["fromval"] = fromval;
   context["toval"] = toval;
   console.log("filter_facet_name====")
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-price-template-content").innerHTML = html;
   console.log("fromval==="+fromval)
   console.log("toval==="+toval)
   $(function(){
    // Init ion range slider
    initializeSlider(fromval,toval,minval,maxval)
    facetCategoryChange($("#price-range"),false,true);
  // Function to update price range on change
   priceRangeSlider = $("#price-range").data("ionRangeSlider");

    initPriceBar = function(from, to) {
      console.log("initPriceBar=="+from+"==="+to)
      return priceRangeSlider.update({
        type: 'double',
        from: from,
        to: to,
        prefix: '<i class="fas fa-rupee-sign" aria-hidden="true"></i> '
      });
    };

   $(document).on('change', '.price-change', function() {
      var from, to;
      from = $('#price-min').val();
      to = $('#price-max').val();
      facetCategoryChange($("#price-range"),true,true);
      return initPriceBar(from, to);
  });

})
 </script>
 @stop