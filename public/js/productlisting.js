function facetCategoryChange(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];console.log("change===");var a=!1,l=$(e).data("facet-name"),n=$(e).data("singleton"),s=$(e).data("slug");if(console.log(l),console.log($(e).prop("checked")+"==="+$(e).val()),$(e).prop("checked"))if(facet_list.hasOwnProperty(l)){if(-1==facet_list[l].indexOf($(e).val()))if(console.log("singleton=="+n),0==n){console.log("RAT1====="),facet_list[l].push($(e).val());var i=filter_tags_list.findIndex(function(e){return e.slug==s});-1==i&&filter_tags_list.push({slug:s,value:$(e).val(),group:l}),a=!0}else{console.log("RAT2====="),facet_list[l]=[$(e).val()];var i=filter_tags_list.findIndex(function(e){return e.slug==s}),r=filter_tags_list.findIndex(function(e){return e.group==l});-1==i&&(-1==r?filter_tags_list.push({slug:s,value:$(e).val(),group:l}):(filter_tags_list.splice(r,1),filter_tags_list.push({slug:s,value:$(e).val(),group:l}))),a=!0}}else{console.log("RAT4====="),facet_list[l]=[$(e).val()];var i=filter_tags_list.findIndex(function(e){return e.slug==s});if(1==n){var r=filter_tags_list.findIndex(function(e){return e.group==l});-1==i&&(-1==r?filter_tags_list.push({slug:s,value:$(e).val(),group:l}):(filter_tags_list.splice(r,1),filter_tags_list.push({slug:s,value:$(e).val(),group:l})))}else-1==i&&filter_tags_list.push({slug:s,value:$(e).val(),group:l});a=!0}else if(console.log("else=="),facet_list.hasOwnProperty(l)&&(console.log("RAT5====="),console.log("hasproperty=="+$(e).val()+"====="+facet_list[l].indexOf($(e).val())),console.log(facet_list[l]),facet_list[l].indexOf($(e).val())>-1)){if(console.log("len=="+facet_list[l].length),1==facet_list[l].length)delete facet_list[l],a=!0;else{var o=facet_list[l].indexOf($(e).val());-1!==o&&facet_list[l].splice(o,1),a=!0}var i=filter_tags_list.findIndex(function(e){return e.slug==s});filter_tags_list.splice(i,1)}console.log(facet_list);var c=constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc);console.log("listurl====",c);var g=JSON.stringify({search_object:facet_list,listurl:c});if(1==a){console.log("filter_tags_list==="),console.log(filter_tags_list);var d=document.getElementById("filter-tags-template").innerHTML,f=Handlebars.compile(d),u={};u.filter_tags_list=filter_tags_list,console.log("filter tags===="),console.log(u);var p=f(u);document.getElementById("filter-tags-template-content").innerHTML=p,1==t&&$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:g,dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var t={};$.each(e,function(e,a){if("filters"==e){$.map(a,function(e){return e}).sort(function(e,t){return e.order-t.order}),$.each(a,function(e,t){console.log(t);var a=t.template;console.log("template=="+n);var l=document.getElementById("filter-"+a+"-template").innerHTML,n=Handlebars.compile(l),s=t.is_singleton,i=t.is_collapsed,r=t.header.display_name,o=t.header.facet_name,c={};c.singleton=s,c.collapsed=i,c.filter_display_name=r,c.filter_facet_name=o,Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)});var g=$.map(t.items,function(e){return e});g.sort(function(e,t){return e.sequence-t.sequence}),c.items=g,console.log(c);var d=n(c);console.log(document.getElementById("filter-"+a+"-template-content")),document.getElementById("filter-"+a+"-template-content").innerHTML=d})}if("breadcrumbs"==e&&(t.breadcrumbs=a),"headers"==e&&(t.headers=a),"items"==e){var l=document.getElementById("products-list-template").innerHTML,n=Handlebars.compile(l);Handlebars.registerHelper("assign",function(e,t,a){a.data.root||(a.data.root={}),a.data.root[e]=t}),Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("ifImagesExist",function(e,t){return console.log(e),Object.keys(e).length>0?t.fn(this):t.inverse(this)});var s={};s.products=a,console.log(s);var i=n(s);document.getElementById("products-list-template-content").innerHTML=i}});var a=document.getElementById("filter-header-template").innerHTML,l=Handlebars.compile(a),n={};n.breadcrumbs=t.breadcrumbs,n.headers=t.headers;var s=l(n);document.getElementById("filter-header-template-content").innerHTML=s,console.log(config_facet_names_arr),console.log(facet_list),window.history.replaceState("categoryPage","Category",c)})}}function constructCategoryUrl(e,t,a){var l="";for(item in e){var n="";console.log("item--"+e[item]);var s=e[item];if(console.log(t),console.log(t[s]),s in t)if(t[e[item]].length>1){var i=[];for(fitem in t[e[item]])i.push(a[e[item]][t[e[item]][fitem]]);n=i.join("--"),l+="/"+n}else n=t[e[item]][0],l+="/"+a[e[item]][n]}return l}function removeFilterTag(e){var t=$("input[data-slug='"+e+"'].facet-category");t.data("singleton");t.removeAttr("checked"),console.log(t),console.log("single==="+e),t.trigger("change")}console.log("productlisting==="),console.log(config_facet_names_arr),$(function(){$(".kss_sizes .radio-input").prop("checked",!1),$(".select-size input[type=radio]").change(function(e){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price):jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small><span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>");var t=$(this).closest(".select-size").find("button");t.removeClass("disabled"),t.prop("disabled",!1),t.addClass("cd-add-cart"),t.addClass("align-items-center"),t.addClass("d-flex"),t.addClass("justify-content-center"),t.html('<i class="kss_icon bag-icon-fill icon-sm"></i> Add To Bag')}),$("#price-range").ionRangeSlider({type:"double",from:0,to:500,min:0,max:1e3,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',onChange:function(e){$("#price-min").val(e.from),$("#price-max").val(e.to)}}),priceRangeSlider=$("#price-range").data("ionRangeSlider"),initPriceBar=function(e,t){return priceRangeSlider.update({type:"double",from:e,to:t,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> '})},$(document).on("change",".price-change",function(){var e,t;return e=$("#price-min").val(),t=$("#price-max").val(),initPriceBar(e,t)})});var facet_list={},filter_tags_list=[];console.log("facet_value_slug_assoc==="),console.log(facet_value_slug_assoc),console.log("facet array==="),console.log(config_facet_names_arr),$(document).ready(function(){$("input[name='age']:checked").length&&$.each($("input[name='age']:checked"),function(){facetCategoryChange($(this),!1)}),$("input[name='gender']:checked").length&&$.each($("input[name='gender']:checked"),function(){facetCategoryChange($(this),!1)}),$("input[name='category']:checked").length&&$.each($("input[name='category']:checked"),function(){facetCategoryChange($(this),!1)}),$("input[name='subtype']:checked").length&&$.each($("input[name='subtype']:checked"),function(){facetCategoryChange($(this),!1)})});