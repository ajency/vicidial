function facetCategoryChange(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],a=arguments.length>2&&void 0!==arguments[2]&&arguments[2],l=arguments.length>3&&void 0!==arguments[3]&&arguments[3],o=arguments.length>4&&void 0!==arguments[4]&&arguments[4];console.log("change===");var s=!1,r=$(e).data("facet-name"),i=$(e).data("singleton"),n=$(e).data("slug"),c=$(e).data("display-name");console.log(r),console.log($(e).prop("checked")+"==="+$(e).val());var _=facet_list,d=$(e).val();if(0==o)if(1==l&&(_=boolean_facet_list,d="true"==$(e).val()),0==a){if($(e).prop("checked"))if(_.hasOwnProperty(r)){if(-1==_[r].indexOf($(e).val()))if(console.log("singleton=="+i),0==i){console.log("RAT1====="),1==l?_[r]=d:_[r].push(d);var f=filter_tags_list.findIndex(function(e){return e.slug==n});-1==f&&filter_tags_list.push({slug:n,value:c,group:r}),s=!0}else{console.log("RAT2====="),_[r]=1==l?d:[d];var f=filter_tags_list.findIndex(function(e){return e.slug==n}),g=filter_tags_list.findIndex(function(e){return e.group==r});-1==f&&(-1==g?filter_tags_list.push({slug:n,value:c,group:r}):(filter_tags_list.splice(g,1),filter_tags_list.push({slug:n,value:c,group:r}))),s=!0}}else{console.log("RAT4====="),_[r]=1==l?d:[d];var f=filter_tags_list.findIndex(function(e){return e.slug==n});if(1==i){var g=filter_tags_list.findIndex(function(e){return e.group==r});-1==f&&(-1==g?filter_tags_list.push({slug:n,value:c,group:r}):(filter_tags_list.splice(g,1),filter_tags_list.push({slug:n,value:c,group:r})))}else-1==f&&filter_tags_list.push({slug:n,value:c,group:r});console.log("filter_tags_list rat4===="),console.log(filter_tags_list),s=!0}else if(console.log("else=="),_.hasOwnProperty(r))if(console.log("RAT5====="),console.log(_[r]),1==l){if(_[r]==d){delete _[r],s=!0;var f=filter_tags_list.findIndex(function(e){return e.slug==n});filter_tags_list.splice(f,1)}}else if(_[r].indexOf(d)>-1){if(console.log("len=="+_[r].length),1==_[r].length)delete _[r],s=!0;else{var p=_[r].indexOf(d);-1!==p&&_[r].splice(p,1),s=!0}var f=filter_tags_list.findIndex(function(e){return e.slug==n});filter_tags_list.splice(f,1)}}else{var u=$(e).val(),m=u.split(";"),v=$(e).val().replace(";","-");console.log(m),console.log("facet_name==="+r),range_facet_list[r]={},range_facet_list[r].min=m[0],range_facet_list[r].max=m[1],console.log("filter_tags_list before===="),console.log(filter_tags_list),console.log("filter_tags_list after===="),console.log(filter_tags_list);var h=-1;for(fitem in filter_tags_list)"price"==filter_tags_list[fitem].slug&&(h=fitem);-1!=h&&filter_tags_list.splice(h,1),range_facet_list[r].min==$(e).data("minval")&&range_facet_list[r].max==$(e).data("maxval")?!1:filter_tags_list.push({slug:n,value:v,group:r}),s=!0}else sort_on_filter=$(e).val(),s=!0;console.log("filter_tags_list after===="),console.log(filter_tags_list),console.log(facet_list),console.log("range_facet_list=="),console.log(range_facet_list);var b=constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc,"");if(console.log("listurl====",b),-1!==b.indexOf("?")?append_filter_str="&":append_filter_str="?",Object.keys(range_facet_list).length>0){console.log(r);for(ritem in range_facet_list){var y=range_facet_list[ritem].min,x=range_facet_list[ritem].max;console.log(".facet-category==="+$("input[data-facet-name='"+ritem+"'].facet-category")),console.log($("input[data-facet-name='"+ritem+"'].facet-category")),y==$("input[data-facet-name='"+ritem+"'].facet-category").data("minval")&&x==$("input[data-facet-name='"+ritem+"'].facet-category").data("maxval")?!0:b+=append_filter_str+"rf=price:"+y+"TO"+x}console.log(range_facet_list[r])}if(console.log("boolean_facet_list=="),console.log(boolean_facet_list),Object.keys(boolean_facet_list).length>0){var j=constructCategoryUrl(config_facet_names_arr,boolean_facet_list,facet_value_slug_assoc,b);console.log("boolean_url=="+j),b=j}1==o&&(-1!==b.indexOf("?")?append_filter_str="&":append_filter_str="?",b+=append_filter_str+"sort_on="+sort_on_filter),console.log("listurl====",b),ajax_data={search_object:{primary_filter:facet_list,range_filter:range_facet_list,boolean_filter:boolean_facet_list},listurl:b,page:page_val},""!=sort_on_filter&&(ajax_data.sort_on=sort_on_filter);var w=JSON.stringify(ajax_data);if(1==s){console.log("filter_tags_list==="),console.log(filter_tags_list);var C=document.getElementById("filter-tags-template").innerHTML,k=Handlebars.compile(C),I={};I.filter_tags_list=filter_tags_list,console.log("filter tags===="),console.log(I);var O=k(I);document.getElementById("filter-tags-template-content").innerHTML=O,$("#filter_head_count").text(filter_tags_list.length),1==t?$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:w,dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var t={},a={};$.each(e,function(e,l){if("filters"==e){$.map(l,function(e){return e}).sort(function(e,t){return e.order-t.order}),$.each(l,function(e,t){console.log(t);var a=t.template;if(console.log("template=="+o),null!=a){var l=document.getElementById("filter-"+a+"-template").innerHTML,o=Handlebars.compile(l);console.log("collapsable_load_values   1111 ======"),console.log(collapsable_load_values);var s=collapsable_load_values[t.header.facet_name],r=t.header.display_name,i=t.header.facet_name,n={};if("boolean_filter"!=t.filter_type){var c=t.is_singleton;n.singleton=c}else n.attribute_slug=t.attribute_slug;if(n.template=a,n.filter_count=filter_tags_list.length,n.filter_type=void 0!=t.filter_type?t.filter_type:"primary_filter",n.display_count=void 0!=t.display_count&&t.display_count,n.is_attribute_param=void 0!=t.is_attribute_param&&t.is_attribute_param,n.disabled_at_zero_count=void 0!=t.disabled_at_zero_count&&t.disabled_at_zero_count,n.collapsed=s,n.filter_display_name=r,n.filter_facet_name=i,"range_filter"==t.filter_type){var _=t.selected_range.start,d=t.selected_range.end,f=t.bucket_range.start,g=t.bucket_range.end;n.fromval=_,n.toval=d,n.minval=f,n.maxval=g}var p=$.map(t.items,function(e){return e});p.sort(function(e,a){return"asc"==t.sort_order?e[t.sort_on]-a[t.sort_on]:a[t.sort_on]-e[t.sort_on]});var u=-1;for(itemk in p)1==p[itemk].is_selected&&(u=itemk);var m=10>u;n.items=p,n.show_more=m,console.log(n);var v=o(n);console.log(document.getElementById("filter-"+a+"-template-content")),document.getElementById("filter-"+a+"-template-content").innerHTML=v,"range_filter"==t.filter_type&&(initializeSlider(_,d,f,g),priceRangeSlider=$("#price-range").data("ionRangeSlider"),initPriceBar=function(e,t){return console.log("initPriceBar=="+e+"==="+t),priceRangeSlider.update({type:"double",from:e,to:t,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> '})})}})}"breadcrumbs"==e&&(t.breadcrumbs=l),"headers"==e&&(t.headers=l),"sort_on"==e&&(t.sort_on=l),"page"==e&&(a.page=l),"items"==e&&(a.products=l,Object.keys(l).length<=0?($(".productlist__row").addClass("d-none"),$(".productlist__na").removeClass("d-none")):($(".productlist__row").removeClass("d-none"),$(".productlist__na").addClass("d-none")))});var l=document.getElementById("products-list-template").innerHTML,o=Handlebars.compile(l),s={};s.products=a.products,s.show_more=a.page.has_next,console.log(s);var r=o(s);document.getElementById("products-list-template-content").innerHTML=r,product_list_items=$.extend({},a.products),console.log("product_list_items===="),console.log(product_list_items);var l=document.getElementById("filter-header-template").innerHTML,o=Handlebars.compile(l),s={};s.breadcrumbs=t.breadcrumbs,s.headers=t.headers,s.sort_on=t.sort_on;var r=o(s);document.getElementById("filter-header-template-content").innerHTML=r,console.log(config_facet_names_arr),console.log(facet_list),window.history.pushState("categoryPage","Category",b)}):(collapsable_load_values[$("input[name='age']").data("facet-name")]=$("input[name='age']").data("collapsable"),collapsable_load_values[$("input[name='category']").data("facet-name")]=$("input[name='category']").data("collapsable"),collapsable_load_values[$("input[name='color']").data("facet-name")]=$("input[name='color']").data("collapsable"),collapsable_load_values[$("input[name='gender']").data("facet-name")]=$("input[name='gender']").data("collapsable"),collapsable_load_values[$("input[name='price']").data("facet-name")]=$("input[name='price']").data("collapsable"),collapsable_load_values[$("input[name='subtype']").data("facet-name")]=$("input[name='subtype']").data("collapsable"),console.log("collapsable_load_values==="),console.log(collapsable_load_values))}}function constructCategoryUrl(e,t,a,l){for(item in e){var o="",s=e[item],r=facet_display_data_arr[s];if(console.log(r),console.log(t),console.log("lem----"+Object.keys(t).length),console.log("itemval=="+s),console.log(a),s in t){var i="";if(console.log("search_object==="),i=-1!==l.indexOf("?")?"&":"?","primary_filter"==r.filter_type&&(i+="pf"),"range_filter"==r.filter_type&&(i+="rf"),"boolean_filter"==r.filter_type&&(i+="bf"),t[e[item]].length>1){console.log("facet_names_arr===");var n=[];if("primary_filter"==r.filter_type)for(fitem in t[e[item]])n.push(a[e[item]][t[e[item]][fitem]]);if("boolean_filter"==r.filter_type)for(fitem in t[e[item]])n.push(t[e[item]][fitem]);r.is_attribute_param&&"primary_filter"==r.filter_type?(o=n.join(","),l+=i+"="+r.template+":"+o):r.is_attribute_param&&"boolean_filter"==r.filter_type?(o=n.join(","),l+=i+"="+o+":"+r.attribute_param):(o=n.join("--"),l+="/"+o)}else{console.log("facet_names_arr else===");var c="";r.is_attribute_param?(o="primary_filter"==r.filter_type?a[e[item]][t[e[item]]]:t[e[item]],c=r.attribute_param):(o=t[e[item]][0],c=a[e[item]][o]),r.is_attribute_param?l+=i+"="+c+":"+o:l+="/"+c}}}return console.log("search_str=="+l),l}function removeFilterTag(e){var t=$("input[data-slug='"+e+"'].facet-category");console.log(t),console.log("single==="+e),"price"==e?(t.val(t.data("minval")+";"+t.data("maxval")),facetCategoryChange(t,!0,!0)):(t.removeAttr("checked"),t.trigger("change"))}function initializeSlider(e,t,a,l){$("#price-range").ionRangeSlider({type:"double",from:e,to:t,min:a,max:l,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',onChange:function(e){$("#price-min").val(e.from),$("#price-max").val(e.to)},onFinish:function(e){facetCategoryChange($("#price-range"),!0,!0)}})}function searchItemInArray(e,t){var a=-1;return $.each(e,function(e,l){if(l.attribute_param==t)return a=e,!1}),a}console.log("productlisting==="),console.log(config_facet_names_arr);var ajax_data={},page_val=1,collapsable_load_values={};Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("assign",function(e,t,a){a.data.root||(a.data.root={}),a.data.root[e]=t}),Handlebars.registerHelper("ifImagesExist",function(e,t){return Object.keys(e).length>0?t.fn(this):t.inverse(this)}),$(function(){$(".kss_sizes .radio-input").prop("checked",!1),$(".select-size input[type=radio]").change(function(e){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price):jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small><span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>");var t=$(this).closest(".select-size").find("button");t.removeClass("disabled"),t.prop("disabled",!1),t.addClass("cd-add-cart"),t.addClass("align-items-center"),t.addClass("d-flex"),t.addClass("justify-content-center"),t.html('<i class="kss_icon bag-icon-fill icon-sm"></i> Add To Bag')}),$(window).bind("popstate",function(){window.location.href=window.location.href})});var facet_list={},range_facet_list={},boolean_facet_list={},sort_on_filter="",filter_tags_list=[];console.log("facet_value_slug_assoc==="),console.log(facet_value_slug_assoc),console.log("facet array==="),console.log(config_facet_names_arr),$(document).ready(function(){var e=$.url().param("page");void 0!=e&&(page_val=e),$(".pl-loader").fadeOut("fast",function(){$("body").removeClass("overflow-h")}),$("body").on("shown.bs.collapse",".collapse",function(){collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")]=!1}),$("body").on("hidden.bs.collapse",".collapse",function(){collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")]=!0}),$(document).on("click",".more-color",function(){$(".color-wrapper .card-body").toggleClass("is-open"),$(this).text(function(e,t){return"+ more"===t?"- less":"+ more"})}),$("body").on("click","#showMoreProductsBtn",function(){$(this).find(".load-icon-cls").removeClass("d-none"),$(this).addClass("disabled");var e=$.url().param("page"),t=window.location.href;console.log("page==="+e),console.log(t.split("?"));var a=t.split("?"),l="";l=a.length>1?"&":"?";var o=1;void 0==e?(t=t+l+"page=2",o=2):(t=t.replace(/page=\d+/,"page="+(parseInt(e)+1)),o=parseInt(e)+1),console.log("ul==="+t);var s=new window.URLSearchParams(window.location.search);console.log("url_params==="),console.log(s.entries());var r=Object.keys(facet_display_data_arr),i=Object.values(facet_display_data_arr),n=!0,c=!1,_=void 0;try{for(var d,f=s.entries()[Symbol.iterator]();!(n=(d=f.next()).done);n=!0)if(pair=d.value,console.log(pair[0]+"===="+pair[1]),"bf"==pair[0]){var g=pair[1].split("|"),p=!0,u=!1,m=void 0;try{for(var v,h=g[Symbol.iterator]();!(p=(v=h.next()).done);p=!0){filters_item=v.value;var b=filters_item.split(":");console.log(b[0]+"===="+b[1]),console.log("boolean_facet_list pir==="+boolean_facet_list[b[0]]);var y=searchItemInArray(i,b[0]);void 0!=r[y]&&void 0==boolean_facet_list[r[y]]&&(ajax_data.search_object.boolean_filter[r[y]]=JSON.parse(b[1]))}}catch(e){u=!0,m=e}finally{try{!p&&h.return&&h.return()}finally{if(u)throw m}}}}catch(e){c=!0,_=e}finally{try{!n&&f.return&&f.return()}finally{if(c)throw _}}ajax_data.page=o,console.log("ajax_data====="),console.log(ajax_data),$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:JSON.stringify(ajax_data),dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var a={};$.each(e,function(e,t){"page"==e&&(a.page=t),"items"==e&&(a.products=t)});var l=document.getElementById("products-list-template").innerHTML,o=Handlebars.compile(l),s={},r=Object.keys(product_list_items).length;for(var i in a.products)product_list_items[r+i]=a.products[i];s.products=product_list_items,Object.keys(product_list_items).length<=0?($(".productlist__row").addClass("d-none"),$(".productlist__na").removeClass("d-none")):($(".productlist__row").removeClass("d-none"),$(".productlist__na").addClass("d-none")),s.show_more=a.page.has_next,console.log("product_list_items======"),console.log(product_list_items);var n=o(s);document.getElementById("products-list-template-content").innerHTML=n,window.history.pushState("categoryPageUrl","Category page",t)})})});