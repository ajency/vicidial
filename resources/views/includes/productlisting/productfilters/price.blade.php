<script id="filter-price-template" type="text/x-handlebars-template">
    <div class="kss_filter-list">
      <div id="headingThree">
        <label class="w-100 mb-0 pb-3 cursor-pointer @{{#if collapsed}} collapsed @{{/if}}" data-toggle="collapse" data-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
          @{{filter_display_name}}<i class="fas fa-angle-up float-right"></i>
        </label>
      </div>
      <div id="collapsePrice" class="collapse @{{#if collapsed}} @{{else}} show @{{/if}}" aria-labelledby="headingThree" >
        <div class="card-body pt-2">
          <div class="priceRange mx-3">
            <input type="text" id="price-range" name="price" value="" onChange="facetCategoryChange(this,true,true);" data-facet-name="@{{../filter_facet_name}}" data-singleton="true" data-slug="@{{slug}}" @{{#if disabled_at_zero_count}} @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}} @{{/if}}/>
          </div>
          <div class="row mt-3">
            <div class="col-5 col-sm-5">
           <input class="form-control form-control-lg text-muted price-change" id="price-min" type="text" placeholder="Min">
            </div>
             <div class="col-2 col-sm-2 text-center">
              <h6 class="align-self-center mt-4">to</h6>
            </div>
              <div class="col-5 col-sm-5">
                 <input class="form-control form-control-lg text-muted price-change" id="price-max" type="text" placeholder="Max">
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
   var fromval =  <?= ($filter_type == "range_filter")?$start:0 ?>;
   var toval = <?= ($filter_type == "range_filter")?$end:0 ?>;
   var filter_display_name = '<?= $header["display_name"] ?>';
   var filter_facet_name = '<?= $header["facet_name"] ?>';
   console.log("price----"+<?= $singleton ?>)
   var context = {};
   context["singleton"] = singleton;
   context["collapsed"] = collapsed;
   context["filter_display_name"] = filter_display_name;
   context["filter_facet_name"] = filter_facet_name;
   context["items"] = <?= json_encode($items); ?>;
   console.log(context)
   var html    = template(context);
   document.getElementById("filter-price-template-content").innerHTML = html;
   console.log("fromval==="+fromval)
   console.log("toval==="+toval)
   $(function(){
    // Init ion range slider
    $('#price-range').ionRangeSlider({
      type: 'double',
      from: fromval,
      to: toval,
      min: 0,
      max: 25000,
      prefix: '<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',
      onChange: function(data) {
        $('#price-min').val(data.from);
        $('#price-max').val(data.to);
      }
  });

  // Function to update price range on change
   priceRangeSlider = $("#price-range").data("ionRangeSlider");

    initPriceBar = function(from, to) {
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
      return initPriceBar(from, to);
  });

})
 </script>
 @stop