
console.log("productlisting===");
console.log(config_facet_names_arr);

var ajax_data = {};

var page_val = 1;
var collapsable_load_values = {};

$(function () {

  $('.kss_sizes .radio-input').prop('checked', false);

  $(".select-size input[type=radio]").change(function (evt) {
    if (this.dataset['list_price'] == this.dataset['sale_price']) {
      jQuery('#kss-price-' + this.dataset['product_id'] + '-' + this.dataset['color_id']).html('₹' + this.dataset['sale_price']);
    } else {
      jQuery('#kss-price-' + this.dataset['product_id'] + '-' + this.dataset['color_id']).html('₹' + this.dataset['sale_price'] + ' <small class="kss-original-price text-muted">₹' + this.dataset['list_price'] + '</small><span class="kss-discount text-danger">' + this.dataset['discount_per'] + '% OFF</span>');
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
});
var facet_list = {};
var range_facet_list = {};
var filter_tags_list = [];
console.log("facet_value_slug_assoc===");
console.log(facet_value_slug_assoc);
console.log("facet array===");
console.log(config_facet_names_arr);

$(document).ready(function () {
  var page_no = $.url().param('page');
  if (page_no != undefined) page_val = page_no;
  if ($("input[name='age']:checked").length) {
    $.each($("input[name='age']:checked"), function () {
      facetCategoryChange($(this), false);
    });
  }
  if ($("input[name='gender']:checked").length) {
    $.each($("input[name='gender']:checked"), function () {
      facetCategoryChange($(this), false);
    });
  }
  if ($("input[name='category']:checked").length) {
    $.each($("input[name='category']:checked"), function () {
      facetCategoryChange($(this), false);
    });
  }
  if ($("input[name='subtype']:checked").length) {
    $.each($("input[name='subtype']:checked"), function () {
      facetCategoryChange($(this), false);
    });
  }
  if ($("input[name='color']:checked").length) {
    $.each($("input[name='color']:checked"), function () {
      facetCategoryChange($(this), false);
    });
  }

  $('.pl-loader').fadeOut('fast', function () {
    $('body').removeClass('overflow-h');
  });

  $('body').on('shown.bs.collapse', '.collapse', function () {
    collapsable_load_values[$("input[name='" + $(this).data("field") + "']").data("facet-name")] = false;
  });

  $('body').on('hidden.bs.collapse', '.collapse', function () {
    collapsable_load_values[$("input[name='" + $(this).data("field") + "']").data("facet-name")] = true;
  });

  $('body').on('click', "#showMoreProductsBtn", function () {
    $(this).find('.load-icon-cls').removeClass('d-none');
    $(this).prop('disabled', true);
    var page = $.url().param('page');
    var url = window.location.href;
    console.log("page===" + page);
    console.log(url.split("?"));
    var url_arr = url.split("?");
    var appendStr = "";
    if (url_arr.length > 1) appendStr = "&";else appendStr = "?";
    var pageVal = 1;
    if (page == undefined) {
      url = url + appendStr + "page=2";
      pageVal = 2;
    } else {
      url = url.replace(/page=\d+/, "page=" + (parseInt(page) + 1));
      pageVal = parseInt(page) + 1;
    }
    console.log("ul===" + url);
    ajax_data["page"] = pageVal;
    console.log("ajax_data=====");
    console.log(ajax_data);
    $.ajax({
      method: "POST",
      url: "/api/rest/v1/product-list",
      data: JSON.stringify(ajax_data),
      dataType: "json",
      contentType: "application/json"

    }).done(function (response) {
      // alert( "Data Saved: " + msg );
      console.log(response);
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
      Handlebars.registerHelper('assign', function (varName, varValue, options) {
        if (!options.data.root) {
          options.data.root = {};
        }
        options.data.root[varName] = varValue;
      });
      Handlebars.registerHelper('ifEquals', function (arg1, arg2, options) {
        return arg1 == arg2 ? options.fn(this) : options.inverse(this);
      });
      Handlebars.registerHelper('ifImagesExist', function (arg1, options) {
        console.log(arg1);
        var count = Object.keys(arg1).length;
        return count > 0 ? options.fn(this) : options.inverse(this);
      });
      var context = {};
      var list_count = Object.keys(product_list_items).length;
      for (var vkey in product_list_context.products) {
        product_list_items[list_count + vkey] = product_list_context.products[vkey];
      }
      // product_list_items = $.extend(product_list_items, values);
      context["products"] = product_list_items;
      if (Object.keys(product_list_items).length <= 0) {
        $(".productlist__row").addClass('d-none');
        $(".productlist__na").removeClass('d-none');
      }
      context["show_more"] = product_list_context.page.has_next;
      console.log("product_list_items======");
      console.log(product_list_items);
      var html = template(context);
      document.getElementById("products-list-template-content").innerHTML = html;
      window.history.replaceState('categoryPageUrl', 'Category page', url);
    });
  });
});

// $('body').on('change', '.facet-category', function() {
function facetCategoryChange(thisObj) {
  var is_ajax = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var range_filter = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

  // From the other examples
  console.log("change===");
  var call_ajax = false;
  var facet_name = $(thisObj).data('facet-name');
  var singleton = $(thisObj).data('singleton');
  var slug_name = $(thisObj).data('slug');
  console.log(facet_name);
  console.log($(thisObj).prop('checked') + "===" + $(thisObj).val());
  if (range_filter == false) {
    if ($(thisObj).prop('checked')) {
      if (facet_list.hasOwnProperty(facet_name)) {
        if (facet_list[facet_name].indexOf($(thisObj).val()) == -1) {
          console.log("singleton==" + singleton);
          if (singleton == false) {
            console.log("RAT1=====");
            facet_list[facet_name].push($(thisObj).val());
            var fil_index = filter_tags_list.findIndex(function (obj) {
              return obj.slug == slug_name;
            });
            if (fil_index == -1) filter_tags_list.push({ "slug": slug_name, "value": $(thisObj).val(), "group": facet_name });
            call_ajax = true;
          } else {
            console.log("RAT2=====");
            facet_list[facet_name] = [$(thisObj).val()];
            var fil_index = filter_tags_list.findIndex(function (obj) {
              return obj.slug == slug_name;
            });
            var fil_grp_index = filter_tags_list.findIndex(function (obj) {
              return obj.group == facet_name;
            });
            if (fil_index == -1) {
              if (fil_grp_index == -1) filter_tags_list.push({ "slug": slug_name, "value": $(thisObj).val(), "group": facet_name });else {
                filter_tags_list.splice(fil_grp_index, 1);
                filter_tags_list.push({ "slug": slug_name, "value": $(thisObj).val(), "group": facet_name });
              }
            }
            call_ajax = true;
          }
        }
      } else {
        console.log("RAT4=====");
        facet_list[facet_name] = [$(thisObj).val()];
        var fil_index = filter_tags_list.findIndex(function (obj) {
          return obj.slug == slug_name;
        });
        if (singleton == true) {
          var fil_grp_index = filter_tags_list.findIndex(function (obj) {
            return obj.group == facet_name;
          });
          if (fil_index == -1) {
            if (fil_grp_index == -1) filter_tags_list.push({ "slug": slug_name, "value": $(thisObj).val(), "group": facet_name });else {
              filter_tags_list.splice(fil_grp_index, 1);
              filter_tags_list.push({ "slug": slug_name, "value": $(thisObj).val(), "group": facet_name });
            }
          }
        } else {
          if (fil_index == -1) filter_tags_list.push({ "slug": slug_name, "value": $(thisObj).val(), "group": facet_name });
        }
        call_ajax = true;
      }
    } else {
      console.log("else==");
      if (facet_list.hasOwnProperty(facet_name)) {
        console.log("RAT5=====");
        console.log("hasproperty==" + $(thisObj).val() + "=====" + facet_list[facet_name].indexOf($(thisObj).val()));
        console.log(facet_list[facet_name]);
        if (facet_list[facet_name].indexOf($(thisObj).val()) > -1) {
          console.log("len==" + facet_list[facet_name].length);
          if (facet_list[facet_name].length == 1) {
            delete facet_list[facet_name];
            call_ajax = true;
          } else {
            var index = facet_list[facet_name].indexOf($(thisObj).val());
            if (index !== -1) facet_list[facet_name].splice(index, 1);
            call_ajax = true;
          }
          var fil_index = filter_tags_list.findIndex(function (obj) {
            return obj.slug == slug_name;
          });
          filter_tags_list.splice(fil_index, 1);
        }
      }
    }
  } else {
    var min_max_val = $(thisObj).val();
    var min_max_arr = min_max_val.split(";");
    console.log(min_max_arr);
    console.log("facet_name===" + facet_name);
    range_facet_list[facet_name] = {};
    range_facet_list[facet_name]["min"] = min_max_arr[0];
    range_facet_list[facet_name]["max"] = min_max_arr[1];
    call_ajax = true;
  }
  console.log(facet_list);
  console.log("range_facet_list==");
  console.log(range_facet_list);
  // console.log("min==="+range_facet_list[facet_name]["min"])

  var url = constructCategoryUrl(config_facet_names_arr, facet_list, facet_value_slug_assoc);
  console.log("listurl====", url);
  if (url.indexOf("?") !== -1) append_filter_str = "&";else append_filter_str = "?";
  if (Object.keys(range_facet_list).length > 0) {
    console.log(facet_name);
    for (ritem in range_facet_list) {
      var minval = range_facet_list[ritem]["min"];
      var maxval = range_facet_list[ritem]["max"];
      url += append_filter_str + "rf=price:" + minval + "TO" + maxval;
    }
    console.log(range_facet_list[facet_name]);
  }
  console.log("listurl====", url);
  ajax_data = { "search_object": { "primary_filter": facet_list, "range_filter": range_facet_list }, "listurl": url, "page": page_val
    // if( Object.keys(range_facet_list).length>0)
    //   ajax_data["search_object"]["range_filter"] = range_facet_list

  };var data = JSON.stringify(ajax_data);

  if (call_ajax == true) {

    console.log("filter_tags_list===");
    console.log(filter_tags_list);
    if (range_filter == false) {
      var filtersource = document.getElementById("filter-tags-template").innerHTML;
      var filtertemplate = Handlebars.compile(filtersource);
      var filtercontext = {};
      filtercontext["filter_tags_list"] = filter_tags_list;
      console.log("filter tags====");
      console.log(filtercontext);
      var filterhtml = filtertemplate(filtercontext);
      document.getElementById("filter-tags-template-content").innerHTML = filterhtml;
    }
    if (is_ajax == true) {

      $.ajax({
        method: "POST",
        url: "/api/rest/v1/product-list",
        data: data,
        dataType: "json",
        contentType: "application/json"
      }).done(function (response) {
        // alert( "Data Saved: " + msg );
        console.log(response);
        var header_context = {};
        var product_list_context = {};

        $.each(response, function (key, values) {
          if (key == "filters") {
            var values_arr = $.map(values, function (el) {
              return el;
            });
            values_arr.sort(function (obj1, obj2) {
              // Ascending: first age less than the previous
              return obj1.order - obj2.order;
            });
            $.each(values, function (vkey, vval) {
              console.log(vval);
              var templateval = vval.template;
              console.log("template==" + template);
              var source = document.getElementById("filter-" + templateval + "-template").innerHTML;
              var template = Handlebars.compile(source);
              var singleton = vval.is_singleton;
              console.log("collapsable_load_values   1111 ======");
              console.log(collapsable_load_values);
              var collapsed = collapsable_load_values[vval.header.facet_name];
              var filter_display_name = vval.header.display_name;
              var filter_facet_name = vval.header.facet_name;
              var context = {};

              context["singleton"] = singleton;
              context["filter_type"] = vval.filter_type != undefined ? vval.filter_type : "primary_filter";
              context["display_count"] = vval.display_count != undefined ? vval.display_count : false;
              context["is_attribute_param"] = vval.is_attribute_param != undefined ? vval.is_attribute_param : false;
              context["disabled_at_zero_count"] = vval.disabled_at_zero_count != undefined ? vval.disabled_at_zero_count : false;
              context["collapsed"] = collapsed;
              context["filter_display_name"] = filter_display_name;
              context["filter_facet_name"] = filter_facet_name;
              if (vval.filter_type == "range_filter") {
                var fromval = vval.selected_range["start"];
                var toval = vval.selected_range["end"];
                var minval = vval.bucket_range["start"];
                var maxval = vval.bucket_range["end"];
                context["fromval"] = fromval;
                context["toval"] = toval;
              }

              Handlebars.registerHelper('ifEquals', function (arg1, arg2, options) {
                return arg1 == arg2 ? options.fn(this) : options.inverse(this);
              });
              var items = $.map(vval.items, function (el) {
                return el;
              });
              items.sort(function (obj1, obj2) {
                // Ascending: first age less than the previous
                return obj1.sequence - obj2.sequence;
              });
              context["items"] = items;
              console.log(context);
              var html = template(context);
              console.log(document.getElementById("filter-" + templateval + "-template-content"));
              document.getElementById("filter-" + templateval + "-template-content").innerHTML = html;
              if (vval.filter_type == "range_filter") {
                initializeSlider(fromval, toval, minval, maxval);
              }
            });
          }
          if (key == "breadcrumbs") {
            header_context.breadcrumbs = values;
          }
          if (key == "headers") {
            header_context.headers = values;
          }
          if (key == "page") {
            product_list_context.page = values;
          }
          if (key == "items") {
            product_list_context.products = values;
            if (Object.keys(values).length <= 0) {
              $(".productlist__row").addClass('d-none');
              $(".productlist__na").removeClass('d-none');
            }
          }
        });
        var source = document.getElementById("products-list-template").innerHTML;
        var template = Handlebars.compile(source);
        Handlebars.registerHelper('assign', function (varName, varValue, options) {
          if (!options.data.root) {
            options.data.root = {};
          }
          options.data.root[varName] = varValue;
        });
        Handlebars.registerHelper('ifEquals', function (arg1, arg2, options) {
          return arg1 == arg2 ? options.fn(this) : options.inverse(this);
        });
        Handlebars.registerHelper('ifImagesExist', function (arg1, options) {
          console.log(arg1);
          var count = Object.keys(arg1).length;
          return count > 0 ? options.fn(this) : options.inverse(this);
        });
        var context = {};
        context["products"] = product_list_context.products;
        context["show_more"] = product_list_context.page.has_next;
        console.log(context);
        var html = template(context);
        document.getElementById("products-list-template-content").innerHTML = html;
        product_list_items = $.extend({}, product_list_context.products);
        console.log("product_list_items====");
        console.log(product_list_items);

        var source = document.getElementById("filter-header-template").innerHTML;
        var template = Handlebars.compile(source);
        var context = {};
        context["breadcrumbs"] = header_context.breadcrumbs;
        context["headers"] = header_context.headers;
        var html = template(context);
        document.getElementById("filter-header-template-content").innerHTML = html;

        console.log(config_facet_names_arr);
        console.log(facet_list);

        window.history.replaceState('categoryPage', 'Category', url);
      });
    } else {
      collapsable_load_values[$("input[name='age']").data("facet-name")] = $("input[name='age']").data("collapsable");
      collapsable_load_values[$("input[name='category']").data("facet-name")] = $("input[name='category']").data("collapsable");
      collapsable_load_values[$("input[name='color']").data("facet-name")] = $("input[name='color']").data("collapsable");
      collapsable_load_values[$("input[name='gender']").data("facet-name")] = $("input[name='gender']").data("collapsable");
      collapsable_load_values[$("input[name='price']").data("facet-name")] = $("input[name='price']").data("collapsable");
      collapsable_load_values[$("input[name='subtype']").data("facet-name")] = $("input[name='subtype']").data("collapsable");
      console.log("collapsable_load_values case 1===");
      console.log(collapsable_load_values);
    }
  }
}
// });


// $( "input[name='age']" ).trigger( "change" );
// $( "input[name='gender']" ).trigger( "change" );
// $( "input[name='category']" ).trigger( "change" );
// $( "input[name='subtype']" ).trigger( "change" );

function constructCategoryUrl(facet_names_arr, search_object, facet_value_slug_arr) {
  var search_str = "";
  for (item in facet_names_arr) {
    var search_cat = "";
    // console.log("item--"+facet_names_arr[item])
    var itemval = facet_names_arr[item];
    var config_item = facet_display_data_arr[itemval];
    // console.log(search_object)
    // console.log(facet_display_data_arr[itemval])
    // console.log(search_object[itemval])
    if (itemval in search_object) {
      var append_filter_str = "";

      if (search_str.indexOf("?") !== -1) append_filter_str = "&";else append_filter_str = "?";
      if (config_item["filter_type"] == "primary_filter") append_filter_str += "pf";
      if (config_item["filter_type"] == "range_filter") append_filter_str += "rf";
      if (search_object[facet_names_arr[item]].length > 1) {
        var furl = [];
        for (fitem in search_object[facet_names_arr[item]]) {
          furl.push(facet_value_slug_arr[facet_names_arr[item]][search_object[facet_names_arr[item]][fitem]]);
        }
        if (config_item["is_attribute_param"] && config_item["filter_type"] == "primary_filter") {
          search_cat = furl.join(',');
          search_str += append_filter_str + "=" + config_item["template"] + ":" + search_cat;
        } else {
          search_cat = furl.join('--');
          search_str += '/' + search_cat;
        }
      } else {
        search_cat = search_object[facet_names_arr[item]][0];
        if (config_item["is_attribute_param"]) {
          search_str += append_filter_str + "=" + config_item["template"] + ":" + facet_value_slug_arr[facet_names_arr[item]][search_cat];
        } else search_str += '/' + facet_value_slug_arr[facet_names_arr[item]][search_cat];
      }
    }
  }
  return search_str;
}

function removeFilterTag(slug) {
  var elm = $("input[data-slug='" + slug + "'].facet-category");
  var singleton = elm.data("singleton");
  // if(singleton == true)
  elm.removeAttr("checked");
  console.log(elm);
  console.log("single===" + slug);
  elm.trigger("change");
}

function initializeSlider(fromval, toval, minval, maxval) {
  // Init ion range slider
  $('#price-range').ionRangeSlider({
    type: 'double',
    from: fromval,
    to: toval,
    min: minval,
    max: maxval,
    prefix: '<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',
    onChange: function onChange(data) {
      $('#price-min').val(data.from);
      $('#price-max').val(data.to);
    },
    onFinish: function onFinish(data) {
      facetCategoryChange($("#price-range"), true, true);
    }
  });
}