function facetCategoryChange(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];arguments.length>2&&void 0!==arguments[2]&&arguments[2];console.log("change===");var a=!1,s=$(e).data("facet-name"),l=$(e).data("singleton"),o=$(e).data("slug");if(console.log(s),console.log($(e).prop("checked")+"==="+$(e).val()),$(e).prop("checked"))if(facet_list.hasOwnProperty(s)){if(-1==facet_list[s].indexOf($(e).val()))if(console.log("singleton=="+l),0==l){console.log("RAT1====="),facet_list[s].push($(e).val());var n=filter_tags_list.findIndex(function(e){return e.slug==o});-1==n&&filter_tags_list.push({slug:o,value:$(e).val(),group:s}),a=!0}else{console.log("RAT2====="),facet_list[s]=[$(e).val()];var n=filter_tags_list.findIndex(function(e){return e.slug==o}),i=filter_tags_list.findIndex(function(e){return e.group==s});-1==n&&(-1==i?filter_tags_list.push({slug:o,value:$(e).val(),group:s}):(filter_tags_list.splice(i,1),filter_tags_list.push({slug:o,value:$(e).val(),group:s}))),a=!0}}else{console.log("RAT4====="),facet_list[s]=[$(e).val()];var n=filter_tags_list.findIndex(function(e){return e.slug==o});if(1==l){var i=filter_tags_list.findIndex(function(e){return e.group==s});-1==n&&(-1==i?filter_tags_list.push({slug:o,value:$(e).val(),group:s}):(filter_tags_list.splice(i,1),filter_tags_list.push({slug:o,value:$(e).val(),group:s})))}else-1==n&&filter_tags_list.push({slug:o,value:$(e).val(),group:s});a=!0}else if(console.log("else=="),facet_list.hasOwnProperty(s)&&(console.log("RAT5====="),console.log("hasproperty=="+$(e).val()+"====="+facet_list[s].indexOf($(e).val())),console.log(facet_list[s]),facet_list[s].indexOf($(e).val())>-1)){if(console.log("len=="+facet_list[s].length),1==facet_list[s].length)delete facet_list[s],a=!0;else{var r=facet_list[s].indexOf($(e).val());-1!==r&&facet_list[s].splice(r,1),a=!0}var n=filter_tags_list.findIndex(function(e){return e.slug==o});filter_tags_list.splice(n,1)}console.log(facet_list);var c=constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc);console.log("listurl====",c),ajax_data={search_object:{primary_filter:facet_list,range_filter:range_facet_list},listurl:c,page:page_val};var d=JSON.stringify(ajax_data);if(1==a){console.log("filter_tags_list==="),console.log(filter_tags_list);var g=document.getElementById("filter-tags-template").innerHTML,u=Handlebars.compile(g),p={};p.filter_tags_list=filter_tags_list,console.log("filter tags===="),console.log(p);var f=u(p);document.getElementById("filter-tags-template-content").innerHTML=f,1==t&&$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:d,dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var t={},a={};$.each(e,function(e,s){if("filters"==e){$.map(s,function(e){return e}).sort(function(e,t){return e.order-t.order}),$.each(s,function(e,t){console.log(t);var a=t.template;console.log("template=="+l);var s=document.getElementById("filter-"+a+"-template").innerHTML,l=Handlebars.compile(s),o=t.is_singleton,n=t.is_collapsed,i=t.header.display_name,r=t.header.facet_name,c={};c.singleton=o,c.filter_type=void 0!=t.filter_type?t.filter_type:"primary_filter",c.display_count=void 0!=t.display_count&&t.display_count,c.is_attribute_param=void 0!=t.is_attribute_param&&t.is_attribute_param,c.disabled_at_zero_count=void 0!=t.disabled_at_zero_count&&t.disabled_at_zero_count,c.collapsed=n,c.filter_display_name=i,c.filter_facet_name=r,Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)});var d=$.map(t.items,function(e){return e});d.sort(function(e,t){return e.sequence-t.sequence}),c.items=d,console.log(c);var g=l(c);console.log(document.getElementById("filter-"+a+"-template-content")),document.getElementById("filter-"+a+"-template-content").innerHTML=g})}"breadcrumbs"==e&&(t.breadcrumbs=s),"headers"==e&&(t.headers=s),"page"==e&&(a.page=s),"items"==e&&(a.products=s)});var s=document.getElementById("products-list-template").innerHTML,l=Handlebars.compile(s);Handlebars.registerHelper("assign",function(e,t,a){a.data.root||(a.data.root={}),a.data.root[e]=t}),Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("ifImagesExist",function(e,t){return console.log(e),Object.keys(e).length>0?t.fn(this):t.inverse(this)});var o={};o.products=a.products,o.show_more=a.page.has_next,console.log(o);var n=l(o);document.getElementById("products-list-template-content").innerHTML=n,product_list_items=$.extend({},a.products),console.log("product_list_items===="),console.log(product_list_items);var s=document.getElementById("filter-header-template").innerHTML,l=Handlebars.compile(s),o={};o.breadcrumbs=t.breadcrumbs,o.headers=t.headers;var n=l(o);document.getElementById("filter-header-template-content").innerHTML=n,console.log(config_facet_names_arr),console.log(facet_list),window.history.replaceState("categoryPage","Category",c)})}}function constructCategoryUrl(e,t,a){var s="";for(item in e){var l="";console.log("item--"+e[item]);var o=e[item];if(console.log(t),console.log(t[o]),o in t)if(t[e[item]].length>1){var n=[];for(fitem in t[e[item]])n.push(a[e[item]][t[e[item]][fitem]]);l=n.join("--"),s+="/"+l}else l=t[e[item]][0],s+="/"+a[e[item]][l]}return s}function removeFilterTag(e){var t=$("input[data-slug='"+e+"'].facet-category");t.data("singleton");t.removeAttr("checked"),console.log(t),console.log("single==="+e),t.trigger("change")}console.log("productlisting==="),console.log(config_facet_names_arr);var ajax_data={},page_val=1;$(function(){$(".kss_sizes .radio-input").prop("checked",!1),$(".select-size input[type=radio]").change(function(e){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price):jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small><span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>");var t=$(this).closest(".select-size").find("button");t.removeClass("disabled"),t.prop("disabled",!1),t.addClass("cd-add-cart"),t.addClass("align-items-center"),t.addClass("d-flex"),t.addClass("justify-content-center"),t.html('<i class="kss_icon bag-icon-fill icon-sm"></i> Add To Bag')})});var facet_list={},range_facet_list={},filter_tags_list=[];console.log("facet_value_slug_assoc==="),console.log(facet_value_slug_assoc),console.log("facet array==="),console.log(config_facet_names_arr),$(document).ready(function(){var e=$.url().param("page");void 0!=e&&(page_val=e),$("input[name='age']:checked").length&&$.each($("input[name='age']:checked"),function(){facetCategoryChange($(this),!1)}),$("input[name='gender']:checked").length&&$.each($("input[name='gender']:checked"),function(){facetCategoryChange($(this),!1)}),$("input[name='category']:checked").length&&$.each($("input[name='category']:checked"),function(){facetCategoryChange($(this),!1)}),$("input[name='subtype']:checked").length&&$.each($("input[name='subtype']:checked"),function(){facetCategoryChange($(this),!1)}),$(".pl-loader").fadeOut(2e3,function(){$("body").removeClass("overflow-h")}),$("body").on("click","#showMoreProductsBtn",function(){$(this).find(".load-icon-cls").removeClass("d-none");var e=$.url().param("page"),t=window.location.href;console.log("page==="+e),console.log(t.split("?"));var a=t.split("?"),s="";s=a.length>1?"&":"?";var l=1;void 0==e?(t=t+s+"page=2",l=2):(t=t.replace(/page=\d+/,"page="+(parseInt(e)+1)),l=parseInt(e)+1),console.log("ul==="+t),ajax_data.page=l,console.log("ajax_data====="),console.log(ajax_data),$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:JSON.stringify(ajax_data),dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var a={};$.each(e,function(e,t){"page"==e&&(a.page=t),"items"==e&&(a.products=t)});var s=document.getElementById("products-list-template").innerHTML,l=Handlebars.compile(s);Handlebars.registerHelper("assign",function(e,t,a){a.data.root||(a.data.root={}),a.data.root[e]=t}),Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("ifImagesExist",function(e,t){return console.log(e),Object.keys(e).length>0?t.fn(this):t.inverse(this)});var o={},n=Object.keys(product_list_items).length;for(var i in a.products)product_list_items[n+i]=a.products[i];o.products=product_list_items,o.show_more=a.page.has_next,console.log("product_list_items======"),console.log(product_list_items);var r=l(o);document.getElementById("products-list-template-content").innerHTML=r,window.history.replaceState("categoryPageUrl","Category page",t)})})});