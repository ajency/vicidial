
console.log("productlisting===")
console.log(config_facet_names_arr)

$(function(){

    $('.kss_sizes .radio-input').prop('checked',false);

    $(".select-size input[type=radio]").change(function(evt){
        if(this.dataset['list_price'] == this.dataset['sale_price']) {
            jQuery('#kss-price-'+this.dataset['product_id']+'-'+this.dataset['color_id']).html('₹'+this.dataset['sale_price']);
        } else {
            jQuery('#kss-price-'+this.dataset['product_id']+'-'+this.dataset['color_id']).html('₹'+this.dataset['sale_price']+' <small class="kss-original-price text-muted">₹'+this.dataset['list_price']+'</small><span class="kss-discount text-danger">'+this.dataset['discount_per']+'% OFF</span>');
        }

        var buttn = $(this).closest('.select-size').find("button");
        buttn.removeClass("disabled");
        buttn.prop("disabled", false);
        buttn.addClass("cd-add-cart");
        buttn.addClass("align-items-center");
        buttn.addClass("d-flex");
        buttn.addClass("justify-content-center");
        buttn.html('<i class="kss_icon bag-icon-fill icon-sm"></i> Add To Bag');
    });

})
var facet_list = {}
var filter_tags_list = [] ;
console.log("facet_value_slug_assoc===")
console.log(facet_value_slug_assoc)
console.log("facet array===")
console.log(config_facet_names_arr)

$(document).ready(function(){
    if($( "input[name='age']:checked" ).length)
        facetCategoryChange($( "input[name='age']:checked" ),false)
    if($( "input[name='gender']:checked" ).length)
        facetCategoryChange($( "input[name='gender']:checked" ),false)
    if($( "input[name='category']:checked" ).length)
        facetCategoryChange($( "input[name='category']:checked" ),false)
    if($( "input[name='subtype']:checked" ).length)
        facetCategoryChange($( "input[name='subtype']:checked" ),false)
});

// $('body').on('change', '.facet-category', function() {
function facetCategoryChange(thisObj,is_ajax = true)
{
    // From the other examples
    console.log("change===")
    var call_ajax = false;
    var facet_name = $(thisObj).data('facet-name')
    var singleton = $(thisObj).data('singleton')
    var slug_name = $(thisObj).data('slug')
    console.log(facet_name)
    console.log($(thisObj).prop('checked')+"==="+$(thisObj).val());
    if($(thisObj).prop('checked')){
        if(facet_list.hasOwnProperty(facet_name)){
          if(facet_list[facet_name].indexOf($(thisObj).val()) == -1){
            console.log("singleton=="+singleton)
            if(singleton == false){
              facet_list[facet_name].push($(thisObj).val())
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              if(fil_index == -1)
                filter_tags_list.push({"slug":slug_name, "value":$(thisObj).val(), "group":facet_name})
              call_ajax = true;
            }
            else{
              facet_list[facet_name] = [$(thisObj).val()]
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
              if(fil_index == -1){
                if(fil_grp_index == -1)
                  filter_tags_list.push({"slug":slug_name, "value":$(thisObj).val(), "group":facet_name})
                else{
                  filter_tags_list.splice(fil_grp_index, 1);
                  filter_tags_list.push({"slug":slug_name, "value":$(thisObj).val(), "group":facet_name})
                }
              }
              call_ajax = true;
            }

          }
        }
        else{
          facet_list[facet_name] = [$(thisObj).val()]
          var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
          if(singleton == true){
            var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
            if(fil_index == -1){
              if(fil_grp_index == -1)
                filter_tags_list.push({"slug":slug_name, "value":$(thisObj).val(), "group":facet_name})
              else{
                filter_tags_list.splice(fil_grp_index, 1);
                filter_tags_list.push({"slug":slug_name, "value":$(thisObj).val(), "group":facet_name})
              }
            }
          }
          else{
            if(fil_index == -1)
              filter_tags_list.push({"slug":slug_name, "value":$(thisObj).val(), "group":facet_name})
          }
          call_ajax = true;
        }

    }
    else{
        console.log("else==")
        if(facet_list.hasOwnProperty(facet_name)){
          console.log("hasproperty=="+$(thisObj).val()+"====="+facet_list[facet_name].indexOf($(thisObj).val()))
          console.log(facet_list[facet_name])
          if(facet_list[facet_name].indexOf($(thisObj).val()) > -1){
            console.log("len=="+facet_list[facet_name].length)
            if(facet_list[facet_name].length == 1){
              delete facet_list[facet_name];
              call_ajax = true;
            }
            else{
                var index = facet_list[facet_name].indexOf($(thisObj).val());
                if (index !== -1) facet_list[facet_name].splice(index, 1);
                call_ajax = true;
              }
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              filter_tags_list.splice(fil_index, 1);
            }
        }
    }
    console.log(facet_list);


    var url = constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc);
    console.log("listurl====",url)
    var data = JSON.stringify({"search_object":facet_list,"listurl":url})
    if(call_ajax == true){
        if(is_ajax == true) {
            console.log("filter_tags_list===")
            console.log(filter_tags_list)
            var filtersource   = document.getElementById("filter-tags-template").innerHTML;
            var filtertemplate = Handlebars.compile(filtersource);
            var filtercontext = {};
            filtercontext["filter_tags_list"] = filter_tags_list;
            console.log("filter tags====")
            console.log(filtercontext)
            var filterhtml    = filtertemplate(filtercontext);
            document.getElementById("filter-tags-template-content").innerHTML = filterhtml;

            $.ajax({
                method: "POST",
                url: "/api/rest/v1/product-list",
                data: data,
                dataType: "json",
                contentType: "application/json"
            }).done(function( response ) {
                // alert( "Data Saved: " + msg );
                console.log(response);
                var header_context = {};
                $.each(response, function(key,values){
                  if(key == "filters"){
                    var values_arr = $.map(values, function(el) { return el });
                    values_arr.sort(function(obj1, obj2) {
                      // Ascending: first age less than the previous
                      return obj1.order - obj2.order;
                    });
                    $.each(values, function(vkey,vval){
                      console.log(vval)
                      var templateval = vval.template
                      console.log("template=="+template)
                     var source   = document.getElementById("filter-"+templateval+"-template").innerHTML;
                     var template = Handlebars.compile(source);
                     var singleton = vval.is_singleton;
                     var collapsed = vval.is_collapsed;
                     var filter_display_name = vval.header.display_name;
                     var filter_facet_name = vval.header.facet_name;
                     var context = {};
                     context["singleton"] = singleton;
                     context["collapsed"] = collapsed;
                     context["filter_display_name"] = filter_display_name;
                     context["filter_facet_name"] = filter_facet_name;
                     Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
                          return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
                      });
                     var items = $.map(vval.items, function(el) { return el });
                     items.sort(function(obj1, obj2) {
                      // Ascending: first age less than the previous
                      return obj1.sequence - obj2.sequence;
                    });
                     context["items"] = items;
                     console.log(context)
                     var html    = template(context);
                     console.log(document.getElementById("filter-"+templateval+"-template-content"))
                     document.getElementById("filter-"+templateval+"-template-content").innerHTML = html;
                   });
                  }
                  if(key == "breadcrumbs"){
                     header_context.breadcrumbs = values ;
                  }
                  if(key == "headers"){
                    header_context.headers = values ;
                  }
                  if(key == "items"){
                       var source   = document.getElementById("products-list-template").innerHTML;
                               var template = Handlebars.compile(source);
                               Handlebars.registerHelper('assign', function (varName, varValue, options) {
                                        if (!options.data.root) {
                                            options.data.root = {};
                                        }
                                        options.data.root[varName] = varValue;
                                    });
                        Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
                            return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
                        });
                         Handlebars.registerHelper('ifImagesExist', function(arg1, options) {
                            console.log(arg1)
                            var count = Object.keys(arg1).length;
                            return (count > 0) ? options.fn(this) : options.inverse(this);
                        });
                               var context = {};
                               context["products"] = values;
                               console.log(context)
                               var html    = template(context);
                               document.getElementById("products-list-template-content").innerHTML = html;
                    }
                });

                var source   = document.getElementById("filter-header-template").innerHTML;
                var template = Handlebars.compile(source);
                var context = {};
                context["breadcrumbs"] = header_context.breadcrumbs ;
                context["headers"] = header_context.headers ;
                var html    = template(context);
                document.getElementById("filter-header-template-content").innerHTML = html;

                console.log(config_facet_names_arr);
                console.log(facet_list)

                window.history.replaceState('categoryPage', 'Category', url);
            });
        }
    }
}
// });


// $( "input[name='age']" ).trigger( "change" );
// $( "input[name='gender']" ).trigger( "change" );
// $( "input[name='category']" ).trigger( "change" );
// $( "input[name='subtype']" ).trigger( "change" );

function constructCategoryUrl(facet_names_arr,search_object,facet_value_slug_arr){
    var search_str = "";
    for(item in facet_names_arr){
      var search_cat = "";
      console.log("item--"+facet_names_arr[item])
      var itemval = facet_names_arr[item]
      console.log(search_object)
      console.log(search_object[itemval])
      if(itemval in search_object){
        if(search_object[facet_names_arr[item]].length>1){
          var furl =[]
          for(fitem in search_object[facet_names_arr[item]]){
            furl.push(facet_value_slug_arr[facet_names_arr[item]][search_object[facet_names_arr[item]][fitem]])
          }
          search_cat = furl.join('--');
          search_str += '/'+search_cat;
        }
        else{
          search_cat = search_object[facet_names_arr[item]][0];
          search_str += '/'+facet_value_slug_arr[facet_names_arr[item]][search_cat];
        }

      }


    }
    return search_str;
}

function removeFilterTag(slug){
    var elm = $("input[data-slug='"+slug+"'].facet-category")
    var singleton = elm.data("singleton")
    // if(singleton == true)
    elm.removeAttr("checked")
    console.log(elm)
    console.log("single==="+slug)
    elm.trigger( "change" );
}