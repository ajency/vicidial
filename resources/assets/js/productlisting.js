var ajax_data = {}

var page_val = 1;
var collapsable_load_values = {}
Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
  return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
});

Handlebars.registerHelper('assign', function (varName, varValue, options) {
  if (!options.data.root) {
    options.data.root = {};
  }
  options.data.root[varName] = varValue;
});

Handlebars.registerHelper('ifImagesExist', function (arg1, options) {
  var count = Object.keys(arg1).length;
  return count > 0 ? options.fn(this) : options.inverse(this);
});
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

    $(window).bind('popstate', function(){
      window.location.href = window.location.href;
    });

    // Custom search
     $(document).on('click','.search-trigger', function () {  
        searchFilter();
     });

     $(document).on('keypress','#searchStringInp', function (e) {  
        if (e.keyCode == 13) 
          searchFilter();
     });
     // Click outside handled
     $(document).mouseup(function(e) {
        var Click_todo;
        Click_todo = $('.expandSearch');
        if (!Click_todo.is(e.target) && Click_todo.has(e.target).length === 0) {
          if($('.custom-expand-search').val() == ''){
            return $(Click_todo).removeClass('showSearch');  
          }
        }
      });
     // If value passed
     if($('.custom-expand-search').length){
       if($('.custom-expand-search').val() != ''){
        $('.expandSearch').addClass('showSearch');
      } 
     }
    
})
var facet_list = {}
var range_facet_list = {}
var boolean_facet_list = {}
var sort_on_filter = ""
var search_string_filter = ""
var filter_tags_list = [] ;

$(document).ready(function(){
    var page_no = $.url().param('page');
    if(page_no != undefined)
      page_val = page_no


    $('.pl-loader').fadeOut('fast',function(){
      $('body').removeClass('overflow-h');
    })

  $('body').on('shown.bs.collapse','.collapse', function () {
    collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")] = false
  })

  $('body').on('hidden.bs.collapse','.collapse', function () {
    collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")] = true
  })


  $(document).on('click',".more-color",function(){
    $('.color-wrapper .card-body').toggleClass('is-open');
    $(this).text(function(i, v){
       return v === '+ more' ? '- less' : '+ more'
    })
  });

  $('body').on('click',"#showMoreProductsBtn",function(){
    $(this).find('.load-icon-cls').removeClass('d-none')
    $(this).addClass('disabled');
    var page = $.url().param('page');
    var url = window.location.href
    var url_arr = url.split("?")
    var appendStr = ""
    if(url_arr.length > 1)
        appendStr = "&"
    else
        appendStr = "?"
    var pageVal = 1;
    if(page == undefined){
        url = url+appendStr+"page=2"
        pageVal = 2;
    }
    else{
        url = url.replace(/page=\d+/, "page="+(parseInt(page)+1));
        pageVal = (parseInt(page)+1);
    }
    var url_params = new window.URLSearchParams(window.location.search);
    var facet_display_data_keys = Object.keys(facet_display_data_arr)
    var facet_display_data_values = Object.values(facet_display_data_arr)
    for(pair of url_params.entries()) { 
      if(pair[0] == "bf"){
        var filters_arr = pair[1].split("|");
        for(filters_item of filters_arr){
          var filter_pair = filters_item.split(":");
          var bool_item_key = searchItemInArray(facet_display_data_values, filter_pair[0]); 

          // var bool_item_key = facet_display_data_values.filter(function (facet) { return facet.attribute_param == filter_pair[0] });
          if( facet_display_data_keys[bool_item_key] != undefined ){
            if(boolean_facet_list[facet_display_data_keys[bool_item_key]] == undefined )
              ajax_data["search_object"]["boolean_filter"][facet_display_data_keys[bool_item_key]] = JSON.parse(filter_pair[1])
          }

        }
      }
    }
    ajax_data["page"] = pageVal
    $.ajax({
        method: "POST",
        url: "/api/rest/v1/product-list",
        data: JSON.stringify(ajax_data),
        dataType: "json",
        contentType: "application/json"

      }).done(function (response) {
        var product_list_context = {};
        $.each(response, function (key, values) {
          if (key == "page") {
            product_list_context.page = values;
          }
          if (key == "items") {
            product_list_context.products = values;
          }
        });
        var source = document.getElementById("products-list-template").innerHTML;
        var template = Handlebars.compile(source);

        var context = {};
        var list_count = Object.keys(product_list_items).length;
        for (var vkey in product_list_context.products) {
            product_list_items[list_count+vkey] = product_list_context.products[vkey];
        }
        // product_list_items = $.extend(product_list_items, values);
        context["products"] = product_list_items;
        if(Object.keys(product_list_items).length<=0){
          $(".productlist__row").addClass('d-none');
          $(".productlist__na").removeClass('d-none');
        }
        else{
           $(".productlist__row").removeClass('d-none');
           $(".productlist__na").addClass('d-none');
         }
        context["show_more"] = product_list_context.page.has_next
        var html = template(context);
        document.getElementById("products-list-template-content").innerHTML = html;
       window.history.pushState('categoryPageUrl', 'Category page', url);
      });

  })

});

// $('body').on('change', '.facet-category', function() {
function facetCategoryChange(thisObj,is_ajax = true,range_filter = false,boolean_filter = false,sort_on=false,search_string=false)
{
    var call_ajax = false;
    var facet_name = $(thisObj).data('facet-name')
    var singleton = $(thisObj).data('singleton')
    var slug_name = $(thisObj).data('slug')
    var display_name = $(thisObj).data('display-name')
    var final_facet_list = facet_list
    var thisval = $(thisObj).val()
    if(search_string == false){
      if(sort_on == false){
        if(boolean_filter == true){
          final_facet_list = boolean_facet_list
          thisval = ($(thisObj).val() == "true")?true:false;
        }
        if(range_filter == false){
          if($(thisObj).prop('checked')){
              if(final_facet_list.hasOwnProperty(facet_name)){
                if(final_facet_list[facet_name].indexOf($(thisObj).val()) == -1){
                  if(singleton == false){
                    if(boolean_filter == true)
                      final_facet_list[facet_name]= thisval
                    else
                      final_facet_list[facet_name].push(thisval)
                    var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
                    if(fil_index == -1)
                      filter_tags_list.push({"slug":slug_name, "value":display_name, "group":facet_name})
                    call_ajax = true;
                  }
                  else{
                    if(boolean_filter == true)
                      final_facet_list[facet_name] = thisval
                    else
                      final_facet_list[facet_name] = [thisval]
                    var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
                    var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
                    if(fil_index == -1){
                      if(fil_grp_index == -1)
                        filter_tags_list.push({"slug":slug_name, "value":display_name, "group":facet_name})
                      else{
                        filter_tags_list.splice(fil_grp_index, 1);
                        filter_tags_list.push({"slug":slug_name, "value":display_name, "group":facet_name})
                      }
                    }
                    call_ajax = true;
                  }

                }
              }
              else{
                if(boolean_filter == true)
                  final_facet_list[facet_name] = thisval
                else
                  final_facet_list[facet_name] = [thisval]
                var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
                if(singleton == true){
                  var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
                  if(fil_index == -1){
                    if(fil_grp_index == -1)
                      filter_tags_list.push({"slug":slug_name, "value":display_name, "group":facet_name})
                    else{
                      filter_tags_list.splice(fil_grp_index, 1);
                      filter_tags_list.push({"slug":slug_name, "value":display_name, "group":facet_name})
                    }
                  }
                }
                else{
                  if(fil_index == -1)
                    filter_tags_list.push({"slug":slug_name, "value":display_name, "group":facet_name})
                }
                call_ajax = true;
              }

          }
          else{
              if(final_facet_list.hasOwnProperty(facet_name)){
                if(boolean_filter == true){
                  if(final_facet_list[facet_name] == thisval){
                    delete final_facet_list[facet_name];
                    call_ajax = true;
                    var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
                    filter_tags_list.splice(fil_index, 1);
                  }
                }
                else{
                  if(final_facet_list[facet_name].indexOf(thisval) > -1){
                  if(final_facet_list[facet_name].length == 1){
                    delete final_facet_list[facet_name];
                    call_ajax = true;
                  }
                  else{
                      var index = final_facet_list[facet_name].indexOf(thisval);
                      if (index !== -1) final_facet_list[facet_name].splice(index, 1);
                      call_ajax = true;
                    }
                    var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
                    filter_tags_list.splice(fil_index, 1);
                  }
                }
                
              }
          }
        }
        else{
          var min_max_val = $(thisObj).val()
          var min_max_arr = min_max_val.split(";")
          var filter_tag_str = $(thisObj).val().replace(";", "-")
          range_facet_list[facet_name]={}
          range_facet_list[facet_name]["min"] = min_max_arr[0];
          range_facet_list[facet_name]["max"] = min_max_arr[1];
          // var fil_index = filter_tags_list.findIndex(obj => obj.slug=="price");
          var filter_tag_exists = false
          let filInd = -1
          for(fitem in filter_tags_list){
            if(filter_tags_list[fitem]["slug"] == "price")
              filInd = fitem
          }
          if(filInd != -1)
            filter_tags_list.splice(filInd, 1);
          if(range_facet_list[facet_name]["min"] == $(thisObj).data("minval") && range_facet_list[facet_name]["max"] == $(thisObj).data("maxval"))
          {
            filter_tag_exists = false  
          }
          else{
            
            filter_tags_list.push({"slug":slug_name, "value":filter_tag_str, "group":facet_name})
          }
          
          call_ajax = true;
        }
      }
      else{
        sort_on_filter = $(thisObj).val()
        call_ajax = true;
      }
    }
    else{
      search_string_filter = $(thisObj).val()
      call_ajax = true;
    }

    var url = constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc,"");
    if(url.indexOf("?") !== -1)
      append_filter_str = "&"
    else
      append_filter_str = "?"

    var url_params = new window.URLSearchParams(window.location.search);
    if(url_params.get('show_search') != undefined){
      url += append_filter_str+"show_search="+url_params.get('show_search')
    }

    if( Object.keys(range_facet_list).length>0){
      for(ritem in range_facet_list){
        var minval = range_facet_list[ritem]["min"]
        var maxval = range_facet_list[ritem]["max"]
        var noURlChange = false
        if(minval == $("input[data-facet-name='"+ritem+"'].facet-category").data("minval") && maxval == $("input[data-facet-name='"+ritem+"'].facet-category").data("maxval"))
        {
          noURlChange = true
        }
        else
        {
          url += append_filter_str+"rf=price:"+minval+"TO"+maxval;
        }
      }
      
    }

    if( Object.keys(boolean_facet_list).length>0){
      var boolean_url = constructCategoryUrl(config_facet_names_arr,boolean_facet_list,facet_value_slug_assoc,url);
      url = boolean_url
    }

    if(sort_on == true){
      if(url.indexOf("?") !== -1)
        append_filter_str = "&"
      else
        append_filter_str = "?"
      url += append_filter_str+"sort_on="+sort_on_filter
    }
    if(search_string == true){
      if(url.indexOf("?") !== -1)
        append_filter_str = "&"
      else
        append_filter_str = "?"
      url += append_filter_str+"search_string="+search_string_filter
    }

    ajax_data = { "search_object": { "primary_filter" : facet_list,"range_filter" : range_facet_list,"boolean_filter" : boolean_facet_list }, "listurl": url , "page": page_val}
    if(sort_on_filter != "")
      ajax_data["sort_on"]= sort_on_filter
    if(search_string_filter != "")
      ajax_data["search_object"]["search_string"]= search_string_filter
    // if( Object.keys(range_facet_list).length>0)
    //   ajax_data["search_object"]["range_filter"] = range_facet_list
    if ($(window).width() < 767) {
      ajax_data["exclude_in_response"] = ["items"];
    }


    var data = JSON.stringify(ajax_data);

    if(call_ajax == true){
        // if(range_filter == false){
        var filtersource   = document.getElementById("filter-tags-template").innerHTML;
        var filtertemplate = Handlebars.compile(filtersource);
        var filtercontext = {};
        filtercontext["filter_tags_list"] = filter_tags_list;
        var filterhtml    = filtertemplate(filtercontext);
        document.getElementById("filter-tags-template-content").innerHTML = filterhtml;
        $("#filter_head_count").text(filter_tags_list.length)
        // }
        if(is_ajax == true) {

            $.ajax({
                method: "POST",
                url: "/api/rest/v1/product-list",
                data: data,
                dataType: "json",
                contentType: "application/json"
            }).done(function( response ) {
                var header_context = {};
                var product_list_context = {};

                $.each(response, function(key,values){
                  if(key == "filters"){
                    var values_arr = $.map(values, function(el) { return el });
                    values_arr.sort(function(obj1, obj2) {
                      // Ascending: first age less than the previous
                      return obj1.order - obj2.order;
                    });
                    $.each(values, function(vkey,vval){
                      var templateval = vval.template
                      if(templateval != null)
                      {
                     var source   = document.getElementById("filter-"+templateval+"-template").innerHTML;
                     var template = Handlebars.compile(source);
                     var collapsed = collapsable_load_values[vval.header.facet_name];
                     var filter_display_name = vval.header.display_name;
                     var filter_facet_name = vval.header.facet_name;
                     var context = {};
                     if(vval.filter_type != "boolean_filter"){
                      var singleton = vval.is_singleton;
                      context["singleton"] = singleton;
                     }
                     else{
                      context["attribute_slug"] = vval.attribute_slug
                     }
                     context["template"] = templateval
                     context["filter_count"] = filter_tags_list.length;
                     context["filter_type"] = (vval.filter_type != undefined)?vval.filter_type:"primary_filter";
                     context["display_count"] = (vval.display_count != undefined)?vval.display_count:false;
                     context["is_attribute_param"] = (vval.is_attribute_param != undefined)?vval.is_attribute_param:false;
                     context["disabled_at_zero_count"] = (vval.disabled_at_zero_count != undefined)?vval.disabled_at_zero_count:false;
                     context["collapsed"] = collapsed;
                     context["filter_display_name"] = filter_display_name;
                     context["filter_facet_name"] = filter_facet_name;
                     if(vval.filter_type == "range_filter"){
                        var fromval = (vval.selected_range["start"]);
                        var toval = (vval.selected_range["end"]);
                        var minval = (vval.bucket_range["start"]);
                        var maxval = (vval.bucket_range["end"]);
                        context["fromval"] = fromval;
                        context["toval"] = toval;
                        context["minval"] = minval;
                        context["maxval"] = maxval;
                     }

                    var items = vval.items
                    //  var items = $.map(vval.items, function(el) { return el });
                    //  items.sort(function(obj1, obj2) {
                    //   // Ascending: first age less than the previous
                    //   if(vval.sort_order == "asc")
                    //     return obj1[vval.sort_on] - obj2[vval.sort_on];
                    //   else
                    //     return obj2[vval.sort_on] - obj1[vval.sort_on];
                    // });
                     var max_selected_index = -1;
                     var show_more_limit = 10;
                     for(itemk in items){
                      if(items[itemk]["is_selected"] == true)
                        max_selected_index = itemk
                     }
                     var show_more = (show_more_limit > max_selected_index)?true:false;
                     context["items"] = items;
                     context["show_more"] = show_more;
                     var html    = template(context);
                     document.getElementById("filter-"+templateval+"-template-content").innerHTML = html;
                     if(vval.filter_type == "range_filter"){
                        initializeSlider(fromval,toval,minval,maxval)
                        priceRangeSlider = $("#price-range").data("ionRangeSlider");
                        initPriceBar = function(from, to) {
                          return priceRangeSlider.update({
                            type: 'double',
                            from: from,
                            to: to,
                            prefix: '<i class="fas fa-rupee-sign" aria-hidden="true"></i> '
                          });
                        };
                     }
                      }
                   });
                  }
                  if(key == "breadcrumbs"){
                     header_context.breadcrumbs = values ;
                  }
                  if(key == "headers"){
                    header_context.headers = values ;
                  }
                  if(key == "sort_on"){
                    header_context.sort_on = values ;
                  }
                  if(key == "search_string"){
                    header_context.search_string = values ;
                  }
                  if (key == "page") {
                    product_list_context.page = values;
                  }
                  if(key == "items"){
                    product_list_context.products = values;
                    if(Object.keys(values).length<=0){
                      $(".productlist__row").addClass('d-none');
                      $(".productlist__na").removeClass('d-none');
                    }
                    else{
                       $(".productlist__row").removeClass('d-none');
                       $(".productlist__na").addClass('d-none');
                     }

                  }
                });

                if(Object.keys(product_list_context).length>0){
                  var source = document.getElementById("products-list-template").innerHTML;
                  var template = Handlebars.compile(source);

                  var context = {};
                  context["products"] = product_list_context.products;
                  context["show_more"] = product_list_context.page.has_next
                  var html = template(context);
                  document.getElementById("products-list-template-content").innerHTML = html;
                  product_list_items = $.extend({}, product_list_context.products);
                }

                var source   = document.getElementById("filter-header-template").innerHTML;
                var template = Handlebars.compile(source);
                var context = {};
                context["breadcrumbs"] = header_context.breadcrumbs ;
                context["headers"] = header_context.headers ;
                context["sort_on"] = header_context.sort_on ;
                context["search_string"] = header_context.search_string;

                context["show_search"] = (url_params.get('show_search') != undefined)?url_params.get('show_search'):false;
                var html    = template(context);
                document.getElementById("filter-header-template-content").innerHTML = html;
                searchFilter(false);
                window.history.pushState('categoryPage', 'Category', url);
            });
        }
        else{
          collapsable_load_values[$("input[name='age']").data("facet-name")] = $("input[name='age']").data("collapsable")
          collapsable_load_values[$("input[name='category']").data("facet-name")] = $("input[name='category']").data("collapsable")
          collapsable_load_values[$("input[name='color']").data("facet-name")] = $("input[name='color']").data("collapsable")
          collapsable_load_values[$("input[name='gender']").data("facet-name")] = $("input[name='gender']").data("collapsable")
          collapsable_load_values[$("input[name='price']").data("facet-name")] = $("input[name='price']").data("collapsable")
          collapsable_load_values[$("input[name='subtype']").data("facet-name")] = $("input[name='subtype']").data("collapsable")
        }

    }


}
// });


// $( "input[name='age']" ).trigger( "change" );
// $( "input[name='gender']" ).trigger( "change" );
// $( "input[name='category']" ).trigger( "change" );
// $( "input[name='subtype']" ).trigger( "change" );

function constructCategoryUrl(facet_names_arr,search_object,facet_value_slug_arr,search_str){
    // var search_str = "";
    for(item in facet_names_arr){
      var search_cat = "";
      var itemval = facet_names_arr[item]
      var config_item = facet_display_data_arr[itemval]
      if(itemval in search_object){
        var append_filter_str = ""
        if(search_str.indexOf("?") !== -1)
          append_filter_str = "&"
        else
          append_filter_str = "?"
        if(config_item["filter_type"] == "primary_filter")
          append_filter_str += "pf"
        if(config_item["filter_type"] == "range_filter")
          append_filter_str += "rf"
        if(config_item["filter_type"] == "boolean_filter")
          append_filter_str += "bf"
        if(search_object[facet_names_arr[item]].length>1){
          var furl =[]
          if(config_item["filter_type"] == "primary_filter"){
            for(fitem in search_object[facet_names_arr[item]]){
              furl.push(facet_value_slug_arr[facet_names_arr[item]][search_object[facet_names_arr[item]][fitem]])
            }
          }
          if(config_item["filter_type"] == "boolean_filter"){
            for(fitem in search_object[facet_names_arr[item]]){
              furl.push(search_object[facet_names_arr[item]][fitem])
            }
          }

          if(config_item["is_attribute_param"] && (config_item["filter_type"] == "primary_filter")){
            search_cat = furl.join(',');
            search_str += append_filter_str+"="+config_item["template"]+":"+search_cat;
          }
          else if(config_item["is_attribute_param"] && config_item["filter_type"] == "boolean_filter"){
            search_cat = furl.join(',');
            search_str += append_filter_str+"="+search_cat+":"+config_item["attribute_param"];
          }
          else{
            search_cat = furl.join('--');
            search_str += '/'+search_cat;
          }

        }
        else{        
          var slugvalue="";
          if(config_item["is_attribute_param"]){
            if (config_item["filter_type"] == "primary_filter"){

              search_cat = facet_value_slug_arr[facet_names_arr[item]][search_object[facet_names_arr[item]]]
            }
            else{
              search_cat = search_object[facet_names_arr[item]];
            }

            slugvalue = config_item["attribute_param"]
          }
          else{
            search_cat = search_object[facet_names_arr[item]][0];
            slugvalue = facet_value_slug_arr[facet_names_arr[item]][search_cat]
          }
          if(config_item["is_attribute_param"]){
            search_str += append_filter_str+"="+slugvalue+":"+search_cat;
          }
          else
            search_str += '/'+slugvalue;

        }

      }


    }
    return search_str;
}

function removeFilterTag(slug){
    var elm = $("input[data-slug='"+slug+"'].facet-category")
    // var singleton = elm.data("singleton")
    // if(singleton == true)
    if(slug == "price"){
      // var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug);
      // filter_tags_list.splice(fil_index, 1);
      elm.val(elm.data("minval")+";"+elm.data("maxval"))
      facetCategoryChange(elm,true,true);
    }
    else{
      elm.removeAttr("checked")
      elm.trigger( "change" );
    }
}

function initializeSlider(fromval,toval,minval,maxval){
      // Init ion range slider
  $('#price-range').ionRangeSlider({
      type: 'double',
      from: fromval,
      to: toval,
      min: minval,
      max: maxval,
      prefix: '<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',
      onChange: function(data) {
        $('#price-min').val(data.from);
        $('#price-max').val(data.to);

      },
      onFinish: function (data) {
        facetCategoryChange($("#price-range"),true,true);
    },
  });
}

function searchItemInArray(obj, search_item) {
    var returnKey = -1;

    $.each(obj, function(key, info) {
        if (info.attribute_param == search_item) {
           returnKey = key;
           return false;
        };
    });

    return returnKey;

}

$(document).on('click', '.kss_filter_mobile--left .nav-item', function(){
  var filterTab = $(this);
  filterTab.addClass('active').siblings().removeClass('active');
  var mobfilterName = filterTab.data('target');
  $('.kss_filter-list').addClass('d-none');
  $('.kss_filter-list[data-filter="'+mobfilterName+'"]').removeClass('d-none');
  $('.kss_filter-list[data-filter="'+mobfilterName+'"] .collapse').collapse('show');
})


function searchFilter(call_facet_change_evt = true){
  if($('.custom-expand-search').val() != ''){
    $('.expandSearch').addClass('showSearch'); 
    $('.custom-expand-search').focus();
    if(call_facet_change_evt)
      facetCategoryChange($('#searchStringInp'),true,false,false,false,true); 
  }
  else if($('.search-trigger').closest('.expandSearch').hasClass('showSearch')){
    $('.expandSearch').removeClass('showSearch');
  }
  else{
    $('.expandSearch').addClass('showSearch'); 
    $('.custom-expand-search').focus();
  }
}



