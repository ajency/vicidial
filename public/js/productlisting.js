function facetCategoryChange(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],a=arguments.length>2&&void 0!==arguments[2]&&arguments[2],l=arguments.length>3&&void 0!==arguments[3]&&arguments[3],o=arguments.length>4&&void 0!==arguments[4]&&arguments[4],s=arguments.length>5&&void 0!==arguments[5]&&arguments[5];console.log("change===");var r=!1,i=$(e).data("facet-name"),n=$(e).data("singleton"),c=$(e).data("slug"),_=$(e).data("display-name");console.log(i);var d=facet_list,f=$(e).val();if(0==s)if(0==o)if(1==l&&(d=boolean_facet_list,f="true"==$(e).val()),0==a){if($(e).prop("checked"))if(d.hasOwnProperty(i)){if(-1==d[i].indexOf($(e).val()))if(console.log("singleton=="+n),0==n){console.log("RAT1====="),1==l?d[i]=f:d[i].push(f);var g=filter_tags_list.findIndex(function(e){return e.slug==c});-1==g&&filter_tags_list.push({slug:c,value:_,group:i}),r=!0}else{console.log("RAT2====="),d[i]=1==l?f:[f];var g=filter_tags_list.findIndex(function(e){return e.slug==c}),p=filter_tags_list.findIndex(function(e){return e.group==i});-1==g&&(-1==p?filter_tags_list.push({slug:c,value:_,group:i}):(filter_tags_list.splice(p,1),filter_tags_list.push({slug:c,value:_,group:i}))),r=!0}}else{console.log("RAT4====="),d[i]=1==l?f:[f];var g=filter_tags_list.findIndex(function(e){return e.slug==c});if(1==n){var p=filter_tags_list.findIndex(function(e){return e.group==i});-1==g&&(-1==p?filter_tags_list.push({slug:c,value:_,group:i}):(filter_tags_list.splice(p,1),filter_tags_list.push({slug:c,value:_,group:i})))}else-1==g&&filter_tags_list.push({slug:c,value:_,group:i});console.log("filter_tags_list rat4===="),console.log(filter_tags_list),r=!0}else if(console.log("else=="),d.hasOwnProperty(i))if(console.log("RAT5====="),console.log(d[i]),1==l){if(d[i]==f){delete d[i],r=!0;var g=filter_tags_list.findIndex(function(e){return e.slug==c});filter_tags_list.splice(g,1)}}else if(d[i].indexOf(f)>-1){if(console.log("len=="+d[i].length),1==d[i].length)delete d[i],r=!0;else{var u=d[i].indexOf(f);-1!==u&&d[i].splice(u,1),r=!0}var g=filter_tags_list.findIndex(function(e){return e.slug==c});filter_tags_list.splice(g,1)}}else{var m=$(e).val(),h=m.split(";"),v=$(e).val().replace(";","-");console.log(h),console.log("facet_name==="+i),range_facet_list[i]={},range_facet_list[i].min=h[0],range_facet_list[i].max=h[1],console.log("filter_tags_list before===="),console.log(filter_tags_list),console.log("filter_tags_list after===="),console.log(filter_tags_list);var b=-1;for(fitem in filter_tags_list)"price"==filter_tags_list[fitem].slug&&(b=fitem);-1!=b&&filter_tags_list.splice(b,1),range_facet_list[i].min==$(e).data("minval")&&range_facet_list[i].max==$(e).data("maxval")?!1:filter_tags_list.push({slug:c,value:v,group:i}),r=!0}else sort_on_filter=$(e).val(),r=!0;else search_string_filter=$(e).val(),r=!0;console.log("filter_tags_list after===="),console.log(filter_tags_list),console.log(facet_list),console.log("range_facet_list=="),console.log(range_facet_list);var y=constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc,"");console.log("listurl====",y),-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?";var x=new window.URLSearchParams(window.location.search);if(void 0!=x.get("show_search")&&(y+=append_filter_str+"show_search="+x.get("show_search")),Object.keys(range_facet_list).length>0){console.log(i);for(ritem in range_facet_list){var w=range_facet_list[ritem].min,C=range_facet_list[ritem].max;console.log(".facet-category==="+$("input[data-facet-name='"+ritem+"'].facet-category")),console.log($("input[data-facet-name='"+ritem+"'].facet-category")),w==$("input[data-facet-name='"+ritem+"'].facet-category").data("minval")&&C==$("input[data-facet-name='"+ritem+"'].facet-category").data("maxval")?!0:y+=append_filter_str+"rf=price:"+w+"TO"+C}console.log(range_facet_list[i])}if(console.log("boolean_facet_list=="),console.log(boolean_facet_list),Object.keys(boolean_facet_list).length>0){var j=constructCategoryUrl(config_facet_names_arr,boolean_facet_list,facet_value_slug_assoc,y);console.log("boolean_url=="+j),y=j}1==o&&(-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",y+=append_filter_str+"sort_on="+sort_on_filter),1==s&&(-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",y+=append_filter_str+"search_string="+search_string_filter),console.log("listurl====",y),ajax_data={search_object:{primary_filter:facet_list,range_filter:range_facet_list,boolean_filter:boolean_facet_list},listurl:y,page:page_val},""!=sort_on_filter&&(ajax_data.sort_on=sort_on_filter),""!=search_string_filter&&(ajax_data.search_object.search_string=search_string_filter);var k=JSON.stringify(ajax_data);if(1==r){console.log("filter_tags_list==="),console.log(filter_tags_list);var S=document.getElementById("filter-tags-template").innerHTML,I=Handlebars.compile(S),O={};O.filter_tags_list=filter_tags_list,console.log("filter tags===="),console.log(O);var T=I(O);document.getElementById("filter-tags-template-content").innerHTML=T,$("#filter_head_count").text(filter_tags_list.length),1==t?$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:k,dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var t={},a={};$.each(e,function(e,l){if("filters"==e){$.map(l,function(e){return e}).sort(function(e,t){return e.order-t.order}),$.each(l,function(e,t){console.log(t);var a=t.template;if(console.log("template=="+o),null!=a){var l=document.getElementById("filter-"+a+"-template").innerHTML,o=Handlebars.compile(l);console.log("collapsable_load_values   1111 ======"),console.log(collapsable_load_values);var s=collapsable_load_values[t.header.facet_name],r=t.header.display_name,i=t.header.facet_name,n={};if("boolean_filter"!=t.filter_type){var c=t.is_singleton;n.singleton=c}else n.attribute_slug=t.attribute_slug;if(n.template=a,n.filter_count=filter_tags_list.length,n.filter_type=void 0!=t.filter_type?t.filter_type:"primary_filter",n.display_count=void 0!=t.display_count&&t.display_count,n.is_attribute_param=void 0!=t.is_attribute_param&&t.is_attribute_param,n.disabled_at_zero_count=void 0!=t.disabled_at_zero_count&&t.disabled_at_zero_count,n.collapsed=s,n.filter_display_name=r,n.filter_facet_name=i,"range_filter"==t.filter_type){var _=t.selected_range.start,d=t.selected_range.end,f=t.bucket_range.start,g=t.bucket_range.end;n.fromval=_,n.toval=d,n.minval=f,n.maxval=g}var p=$.map(t.items,function(e){return e});p.sort(function(e,a){return"asc"==t.sort_order?e[t.sort_on]-a[t.sort_on]:a[t.sort_on]-e[t.sort_on]});var u=-1;for(itemk in p)1==p[itemk].is_selected&&(u=itemk);var m=10>u;n.items=p,n.show_more=m,console.log(n);var h=o(n);console.log(document.getElementById("filter-"+a+"-template-content")),document.getElementById("filter-"+a+"-template-content").innerHTML=h,"range_filter"==t.filter_type&&(initializeSlider(_,d,f,g),priceRangeSlider=$("#price-range").data("ionRangeSlider"),initPriceBar=function(e,t){return console.log("initPriceBar=="+e+"==="+t),priceRangeSlider.update({type:"double",from:e,to:t,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> '})})}})}"breadcrumbs"==e&&(t.breadcrumbs=l),"headers"==e&&(t.headers=l),"sort_on"==e&&(t.sort_on=l),"search_string"==e&&(t.search_string=l),"page"==e&&(a.page=l),"items"==e&&(a.products=l,Object.keys(l).length<=0?($(".productlist__row").addClass("d-none"),$(".productlist__na").removeClass("d-none")):($(".productlist__row").removeClass("d-none"),$(".productlist__na").addClass("d-none")))});var l=document.getElementById("products-list-template").innerHTML,o=Handlebars.compile(l),s={};s.products=a.products,s.show_more=a.page.has_next,console.log(s);var r=o(s);document.getElementById("products-list-template-content").innerHTML=r,product_list_items=$.extend({},a.products),console.log("product_list_items===="),console.log(product_list_items);var l=document.getElementById("filter-header-template").innerHTML,o=Handlebars.compile(l),s={};s.breadcrumbs=t.breadcrumbs,s.headers=t.headers,s.sort_on=t.sort_on,s.search_string=t.search_string,s.show_search=void 0!=x.get("show_search")&&x.get("show_search");var r=o(s);document.getElementById("filter-header-template-content").innerHTML=r,searchFilter(!1),window.history.pushState("categoryPage","Category",y)}):(collapsable_load_values[$("input[name='age']").data("facet-name")]=$("input[name='age']").data("collapsable"),collapsable_load_values[$("input[name='category']").data("facet-name")]=$("input[name='category']").data("collapsable"),collapsable_load_values[$("input[name='color']").data("facet-name")]=$("input[name='color']").data("collapsable"),collapsable_load_values[$("input[name='gender']").data("facet-name")]=$("input[name='gender']").data("collapsable"),collapsable_load_values[$("input[name='price']").data("facet-name")]=$("input[name='price']").data("collapsable"),collapsable_load_values[$("input[name='subtype']").data("facet-name")]=$("input[name='subtype']").data("collapsable"),console.log("collapsable_load_values==="),console.log(collapsable_load_values))}}function constructCategoryUrl(e,t,a,l){for(item in e){var o="",s=e[item],r=facet_display_data_arr[s];if(console.log(r),console.log(t),console.log("lem----"+Object.keys(t).length),console.log("itemval=="+s),console.log(a),s in t){var i="";if(console.log("search_object==="),i=-1!==l.indexOf("?")?"&":"?","primary_filter"==r.filter_type&&(i+="pf"),"range_filter"==r.filter_type&&(i+="rf"),"boolean_filter"==r.filter_type&&(i+="bf"),t[e[item]].length>1){console.log("facet_names_arr===");var n=[];if("primary_filter"==r.filter_type)for(fitem in t[e[item]])n.push(a[e[item]][t[e[item]][fitem]]);if("boolean_filter"==r.filter_type)for(fitem in t[e[item]])n.push(t[e[item]][fitem]);r.is_attribute_param&&"primary_filter"==r.filter_type?(o=n.join(","),l+=i+"="+r.template+":"+o):r.is_attribute_param&&"boolean_filter"==r.filter_type?(o=n.join(","),l+=i+"="+o+":"+r.attribute_param):(o=n.join("--"),l+="/"+o)}else{console.log("facet_names_arr else===");var c="";r.is_attribute_param?(o="primary_filter"==r.filter_type?a[e[item]][t[e[item]]]:t[e[item]],c=r.attribute_param):(o=t[e[item]][0],c=a[e[item]][o]),r.is_attribute_param?l+=i+"="+c+":"+o:l+="/"+c}}}return console.log("search_str=="+l),l}function removeFilterTag(e){var t=$("input[data-slug='"+e+"'].facet-category");console.log(t),console.log("single==="+e),"price"==e?(t.val(t.data("minval")+";"+t.data("maxval")),facetCategoryChange(t,!0,!0)):(t.removeAttr("checked"),t.trigger("change"))}function initializeSlider(e,t,a,l){$("#price-range").ionRangeSlider({type:"double",from:e,to:t,min:a,max:l,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',onChange:function(e){$("#price-min").val(e.from),$("#price-max").val(e.to)},onFinish:function(e){facetCategoryChange($("#price-range"),!0,!0)}})}function searchItemInArray(e,t){var a=-1;return $.each(e,function(e,l){if(l.attribute_param==t)return a=e,!1}),a}function searchFilter(){var e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];""!=$(".custom-expand-search").val()?($(".expandSearch").addClass("showSearch"),$(".custom-expand-search").focus(),e&&facetCategoryChange($("#searchStringInp"),!0,!1,!1,!1,!0)):$(this).closest(".expandSearch").hasClass("showSearch")?$(".expandSearch").removeClass("showSearch"):($(".expandSearch").addClass("showSearch"),$(".custom-expand-search").focus())}console.log("productlisting==="),console.log(config_facet_names_arr);var ajax_data={},page_val=1,collapsable_load_values={};Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("assign",function(e,t,a){a.data.root||(a.data.root={}),a.data.root[e]=t}),Handlebars.registerHelper("ifImagesExist",function(e,t){return Object.keys(e).length>0?t.fn(this):t.inverse(this)}),$(function(){$(".kss_sizes .radio-input").prop("checked",!1),$(".select-size input[type=radio]").change(function(e){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price):jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small><span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>");var t=$(this).closest(".select-size").find("button");t.removeClass("disabled"),t.prop("disabled",!1),t.addClass("cd-add-cart"),t.addClass("align-items-center"),t.addClass("d-flex"),t.addClass("justify-content-center"),t.html('<i class="kss_icon bag-icon-fill icon-sm"></i> Add To Bag')}),$(window).bind("popstate",function(){window.location.href=window.location.href}),$(document).on("click",".search-trigger",function(){searchFilter()}),$(document).on("keypress","#searchStringInp",function(e){13==e.keyCode&&searchFilter()}),$(document).mouseup(function(e){var t;if(t=$(".expandSearch"),!t.is(e.target)&&0===t.has(e.target).length&&""==$(".custom-expand-search").val())return $(t).removeClass("showSearch")}),$(".custom-expand-search").length&&""!=$(".custom-expand-search").val()&&$(".expandSearch").addClass("showSearch")});var facet_list={},range_facet_list={},boolean_facet_list={},sort_on_filter="",search_string_filter="",filter_tags_list=[];console.log("facet_value_slug_assoc==="),console.log(facet_value_slug_assoc),console.log("facet array==="),console.log(config_facet_names_arr),$(document).ready(function(){var e=$.url().param("page");void 0!=e&&(page_val=e),$(".pl-loader").fadeOut("fast",function(){$("body").removeClass("overflow-h")}),$("body").on("shown.bs.collapse",".collapse",function(){collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")]=!1}),$("body").on("hidden.bs.collapse",".collapse",function(){collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")]=!0}),$(document).on("click",".more-color",function(){$(".color-wrapper .card-body").toggleClass("is-open"),$(this).text(function(e,t){return"+ more"===t?"- less":"+ more"})}),$("body").on("click","#showMoreProductsBtn",function(){$(this).find(".load-icon-cls").removeClass("d-none"),$(this).addClass("disabled");var e=$.url().param("page"),t=window.location.href;console.log("page==="+e),console.log(t.split("?"));var a=t.split("?"),l="";l=a.length>1?"&":"?";var o=1;void 0==e?(t=t+l+"page=2",o=2):(t=t.replace(/page=\d+/,"page="+(parseInt(e)+1)),o=parseInt(e)+1),console.log("ul==="+t);var s=new window.URLSearchParams(window.location.search);console.log("url_params==="),console.log(s.entries());var r=Object.keys(facet_display_data_arr),i=Object.values(facet_display_data_arr),n=!0,c=!1,_=void 0;try{for(var d,f=s.entries()[Symbol.iterator]();!(n=(d=f.next()).done);n=!0)if(pair=d.value,console.log(pair[0]+"===="+pair[1]),"bf"==pair[0]){var g=pair[1].split("|"),p=!0,u=!1,m=void 0;try{for(var h,v=g[Symbol.iterator]();!(p=(h=v.next()).done);p=!0){filters_item=h.value;var b=filters_item.split(":");console.log(b[0]+"===="+b[1]),console.log("boolean_facet_list pir==="+boolean_facet_list[b[0]]);var y=searchItemInArray(i,b[0]);void 0!=r[y]&&void 0==boolean_facet_list[r[y]]&&(ajax_data.search_object.boolean_filter[r[y]]=JSON.parse(b[1]))}}catch(e){u=!0,m=e}finally{try{!p&&v.return&&v.return()}finally{if(u)throw m}}}}catch(e){c=!0,_=e}finally{try{!n&&f.return&&f.return()}finally{if(c)throw _}}ajax_data.page=o,console.log("ajax_data====="),console.log(ajax_data),$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:JSON.stringify(ajax_data),dataType:"json",contentType:"application/json"}).done(function(e){console.log(e);var a={};$.each(e,function(e,t){"page"==e&&(a.page=t),"items"==e&&(a.products=t)});var l=document.getElementById("products-list-template").innerHTML,o=Handlebars.compile(l),s={},r=Object.keys(product_list_items).length;for(var i in a.products)product_list_items[r+i]=a.products[i];s.products=product_list_items,Object.keys(product_list_items).length<=0?($(".productlist__row").addClass("d-none"),$(".productlist__na").removeClass("d-none")):($(".productlist__row").removeClass("d-none"),$(".productlist__na").addClass("d-none")),s.show_more=a.page.has_next,console.log("product_list_items======"),console.log(product_list_items);var n=o(s);document.getElementById("products-list-template-content").innerHTML=n,window.history.pushState("categoryPageUrl","Category page",t)})})}),$(document).on("click",".kss_filter_mobile--left .nav-item",function(){var e=$(this);e.addClass("active").siblings().removeClass("active");var t=e.data("target");$(".kss_filter-list").addClass("d-none"),$('.kss_filter-list[data-filter="'+t+'"]').removeClass("d-none"),$('.kss_filter-list[data-filter="'+t+'"] .collapse').collapse("show")});