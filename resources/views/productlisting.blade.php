@extends('layouts.default')

@section('headjs')

  <script type="text/javascript" src="/js/handlebars.min.js"></script>

@stop

@section('content')

	<section>
    <div class="container mt-2 mt-md-4">
     	<div class="row">
     	  <!-- Filters Blade -->
    	  @include('includes.productlisting.filters', ['filters' => $params->filters])
    	  <div class="col-sm-12 col-md-9 bl-1">
    	    <!-- Title, breadcrumbs, sort Blade -->
    	  	@include('includes.productlisting.listingtitle', ['headers' => $params->headers, 'breadcrumbs' => $params->breadcrumbs, 'sort_on' => $params->sort_on])
          <div id="card-list" class="row">
    	    <!-- List of products Blade -->
            @include('includes.productlisting.listingproducts', ['items' => $params->items])
          </div>
    	  </div>
    	</div>
    </div>
    <br>
    <br>
    <!-- Filters, Sort for mobile Blade -->
    @include('includes.productlisting.filtersmobile', ['sort_on' => $params->sort_on])
  </section>

@stop

@section('footjs')
  <?php
    $facet_display_data = config('product.facet_display_data');

    // usort($facet_display_data, function($a, $b) {
    //       return $a["order"] > $b["order"] ? 1 : -1;
    //   });

    $config_facet_names_arr = array_keys($facet_display_data);
    $facet_value_slug_assoc = json_encode($params->search_result_assoc);
  ?>
  <script type="text/javascript" src="/js/productlisting.js"></script>
    @yield('footjs-gender')
  @yield('footjs-age')
  @yield('footjs-subtype')
  @yield('footjs-category')
  @yield('footjs-filter-tags')
  <script type="text/javascript">
      var facet_list = {}
      var config_facet_names_arr = <?= json_encode($config_facet_names_arr);?>;
      var facet_value_slug_assoc = <?= $facet_value_slug_assoc ?>;
      var filter_tags_list = [] ;
      console.log("facet_value_slug_assoc===")
      console.log(facet_value_slug_assoc)
      console.log("facet array===")
      console.log(config_facet_names_arr)
     $('body').on('change', '.facet-category', function() {
      // From the other examples
      console.log("change===")
      var call_ajax = false;
      var facet_name = $(this).data('facet-name')
      var singleton = $(this).data('singleton')
      var slug_name = $(this).data('slug')
      console.log(facet_name)
      console.log(this.checked+"==="+this.value);
      if(this.checked){
        if(facet_list.hasOwnProperty(facet_name)){
          if(facet_list[facet_name].indexOf(this.value) == -1){
            console.log("singleton=="+singleton)
            if(singleton == false){
              facet_list[facet_name].push(this.value)
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              if(fil_index == -1)
                filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
              call_ajax = true;
            }
            else{
              facet_list[facet_name] = [this.value]
              var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
              var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
              if(fil_index == -1){
                if(fil_grp_index == -1)
                  filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
                else{
                  filter_tags_list.splice(fil_grp_index, 1);
                  filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
                }
              }
              call_ajax = true;
            }

          }
        }
        else{
          facet_list[facet_name] = [this.value]
          var fil_index = filter_tags_list.findIndex(obj => obj.slug==slug_name);
          if(singleton == true){
            var fil_grp_index = filter_tags_list.findIndex(obj => obj.group==facet_name);
            if(fil_index == -1){
              if(fil_grp_index == -1)
                filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
              else{
                filter_tags_list.splice(fil_grp_index, 1);
                filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
              }
            }
          }
          else{
            if(fil_index == -1)
              filter_tags_list.push({"slug":slug_name, "value":this.value, "group":facet_name})
          }
          call_ajax = true;
        }
          
      }
      else{
        console.log("else==")
        if(facet_list.hasOwnProperty(facet_name)){
          console.log("hasproperty=="+this.value+"====="+facet_list[facet_name].indexOf(this.value))
          console.log(facet_list[facet_name])
          if(facet_list[facet_name].indexOf(this.value) > -1){
            console.log("len=="+facet_list[facet_name].length)
            if(facet_list[facet_name].length == 1){
              delete facet_list[facet_name];
              call_ajax = true;
            }
            else{
                var index = facet_list[facet_name].indexOf(this.value);
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
      var data = {"search_object":facet_list,"url":url}
      if(call_ajax == true){
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
        dataType: "json"
      })
        .done(function( response ) {
          // alert( "Data Saved: " + msg );
          console.log(response);
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
                 var source   = document.getElementById("filter-header-template").innerHTML;
                 var template = Handlebars.compile(source);
                 var context = {};
                 context["breadcrumbs"] = values ;
                 var html    = template(context);
                 document.getElementById("filter-header-template-content").innerHTML = html;
              }
          });


          console.log(config_facet_names_arr);
          console.log(facet_list)
          
          window.history.replaceState('categoryPage', 'Category', url);
        });
      }

  });
     $( "input[name='age']" ).trigger( "change" );
      $( "input[name='gender']" ).trigger( "change" );
      $( "input[name='category']" ).trigger( "change" );
      $( "input[name='subtype']" ).trigger( "change" );

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
  </script> 


@stop