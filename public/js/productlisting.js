function facetCategoryChange(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],a=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=arguments.length>3&&void 0!==arguments[3]&&arguments[3],i=arguments.length>4&&void 0!==arguments[4]&&arguments[4],s=arguments.length>5&&void 0!==arguments[5]&&arguments[5],l=!1,n=$(e).data("facet-name"),o=$(e).data("singleton"),c=$(e).data("slug"),_=$(e).data("display-name"),d=facet_list,f=$(e).val();if(0==s)if(0==i)if(1==r&&(d=boolean_facet_list),0==a){if($(e).prop("checked"))if(d.hasOwnProperty(n)){if(-1==d[n].indexOf($(e).val()))if(0==o){1==r?d[n]=f:d[n].push(f);var p=filter_tags_list.findIndex(function(e){return e.slug==c});-1==p&&filter_tags_list.push({slug:c,value:_,group:n}),l=!0}else{d[n]=1==r?f:[f];var p=filter_tags_list.findIndex(function(e){return e.slug==c}),u=filter_tags_list.findIndex(function(e){return e.group==n});-1==p&&(-1==u?filter_tags_list.push({slug:c,value:_,group:n}):(filter_tags_list.splice(u,1),filter_tags_list.push({slug:c,value:_,group:n}))),l=!0}}else{d[n]=1==r?f:[f];var p=filter_tags_list.findIndex(function(e){return e.slug==c});if(1==o){var u=filter_tags_list.findIndex(function(e){return e.group==n});-1==p&&(-1==u?filter_tags_list.push({slug:c,value:_,group:n}):(filter_tags_list.splice(u,1),filter_tags_list.push({slug:c,value:_,group:n})))}else-1==p&&filter_tags_list.push({slug:c,value:_,group:n});l=!0}else if(d.hasOwnProperty(n))if(1==r){if(d[n]==f){delete d[n],l=!0;var p=filter_tags_list.findIndex(function(e){return e.slug==c});filter_tags_list.splice(p,1)}}else if(d[n].indexOf(f)>-1){if(1==d[n].length)delete d[n],l=!0;else{var m=d[n].indexOf(f);-1!==m&&d[n].splice(m,1),l=!0}var p=filter_tags_list.findIndex(function(e){return e.slug==c});filter_tags_list.splice(p,1)}}else{var g=$(e).val(),h=g.split(";"),v=$(e).val().replace(";","-");range_facet_list[n]={},range_facet_list[n].min=h[0],range_facet_list[n].max=h[1];var b=-1;for(fitem in filter_tags_list)"price"==filter_tags_list[fitem].slug&&(b=fitem);-1!=b&&filter_tags_list.splice(b,1),range_facet_list[n].min==$(e).data("minval")&&range_facet_list[n].max==$(e).data("maxval")?!1:filter_tags_list.push({slug:c,value:v,group:n}),l=!0}else sort_on_filter=$(e).val(),l=!0;else search_string_filter=$(e).val(),l=!0;var y=constructCategoryUrl(config_facet_names_arr,facet_list,facet_value_slug_assoc,"");-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?";var x=new window.URLSearchParams(window.location.search);if(void 0!=x.get("show_search")&&(y+=append_filter_str+"show_search="+x.get("show_search")),-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",void 0!=x.get("search_string")&&0==s&&""!=x.get("search_string").trim()?y+=append_filter_str+"search_string="+x.get("search_string"):y=removeParam("search_string",y),-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",void 0!=x.get("sort_on")&&0==i&&""!=x.get("sort_on").trim()&&(y+=append_filter_str+"sort_on="+x.get("sort_on")),-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",void 0!=x.get("bf")&&""!=x.get("bf").trim()&&(y+=append_filter_str+"bf="+x.get("bf")),-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",void 0!=x.get("rf")&&""!=x.get("rf").trim()&&(y+=append_filter_str+"rf="+x.get("bf")),-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",void 0!=x.get("pf")&&""!=x.get("pf").trim()&&(y+=append_filter_str+"pf="+x.get("pf")),Object.keys(range_facet_list).length>0)for(ritem in range_facet_list){var w=range_facet_list[ritem].min,j=range_facet_list[ritem].max;w==$("input[data-facet-name='"+ritem+"'].facet-category").data("minval")&&j==$("input[data-facet-name='"+ritem+"'].facet-category").data("maxval")?!0:y+=append_filter_str+"rf=price:"+w+"TO"+j}if(Object.keys(boolean_facet_list).length>0){var C=constructCategoryUrl(config_facet_names_arr,boolean_facet_list,facet_value_slug_assoc,y);y=C}1==i&&(-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",y+=append_filter_str+"sort_on="+sort_on_filter),1==s&&(-1!==y.indexOf("?")?append_filter_str="&":append_filter_str="?",""!=search_string_filter.trim()&&(y+=append_filter_str+"search_string="+search_string_filter)),console.log("listurl====",y);var k=Object.assign({},boolean_facet_list);if(1==t){for(citem in facet_display_data_arr)console.log(facet_display_data_arr[citem]),console.log(facet_display_data_arr[citem].false_facet_value+"==="+(null!=facet_display_data_arr[citem].false_facet_value)),null!=facet_display_data_arr[citem].false_facet_value&&void 0==boolean_facet_list[citem]&&null!=facet_display_data_arr[citem].template&&(k[citem]=facet_display_data_arr[citem].false_facet_value);console.log("boolean_facet_list_params===="),console.log(k)}ajax_data={search_object:{primary_filter:facet_list,range_filter:range_facet_list,boolean_filter:k},listurl:y,page:page_val},""!=sort_on_filter&&(ajax_data.sort_on=sort_on_filter),""!=search_string_filter&&(ajax_data.search_object.search_string=search_string_filter),isMobile&&(ajax_data.exclude_in_response=["items"]);var I=JSON.stringify(ajax_data);if(1==l){var O=document.getElementById("filter-tags-template").innerHTML,S=Handlebars.compile(O),H={};H.filter_tags_list=filter_tags_list;var T=S(H);document.getElementById("filter-tags-template-content").innerHTML=T,$("#filter_head_count").text(filter_tags_list.length),1==t?$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:I,dataType:"json",contentType:"application/json"}).done(function(a){var r={},i={};if($.each(a,function(e,t){if("filters"==e){$.map(t,function(e){return e}).sort(function(e,t){return e.order-t.order}),$.each(t,function(e,t){var a=t.template;if(null!=a){var r=document.getElementById("filter-"+a+"-template").innerHTML,i=Handlebars.compile(r),s=collapsable_load_values[t.header.facet_name],l=t.header.display_name,n=t.header.facet_name,o={};if("boolean_filter"!=t.filter_type){var c=t.is_singleton;o.singleton=c}else o.attribute_slug=t.attribute_slug;if(o.template=a,o.filter_count=filter_tags_list.length,o.filter_type=void 0!=t.filter_type?t.filter_type:"primary_filter",o.display_count=void 0!=t.display_count&&t.display_count,o.is_attribute_param=void 0!=t.is_attribute_param&&t.is_attribute_param,o.disabled_at_zero_count=void 0!=t.disabled_at_zero_count&&t.disabled_at_zero_count,o.collapsed=s,o.filter_display_name=l,o.filter_facet_name=n,"range_filter"==t.filter_type){var _=t.selected_range.start,d=t.selected_range.end,f=t.bucket_range.start,p=t.bucket_range.end;o.fromval=_,o.toval=d,o.minval=f,o.maxval=p}var u=t.items,m=-1;for(itemk in u)1==u[itemk].is_selected&&(m=itemk);var g=10>m;o.items=u,o.show_more=g;var h=i(o);document.getElementById("filter-"+a+"-template-content").innerHTML=h,"range_filter"==t.filter_type&&(initializeSlider(_,d,f,p),priceRangeSlider=$("#price-range").data("ionRangeSlider"),initPriceBar=function(e,t){return priceRangeSlider.update({type:"double",from:e,to:t,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> '})})}})}"breadcrumbs"==e&&(r.breadcrumbs=t),"headers"==e&&(r.headers=t),"sort_on"==e&&(r.sort_on=t),"search_string"==e&&(r.search_string=t),"page"==e&&(i.page=t),"items"==e&&(i.products=t,Object.keys(t).length<=0?($(".productlist__row").addClass("d-none"),$(".productlist__na").removeClass("d-none")):($(".productlist__row").removeClass("d-none"),$(".productlist__na").addClass("d-none")))}),Object.keys(i).length>0){var s=document.getElementById("products-list-template").innerHTML,l=Handlebars.compile(s),n={};n.products=i.products,n.show_more=i.page.has_next;var o=l(n);document.getElementById("products-list-template-content").innerHTML=o,product_list_items=$.extend({},i.products)}else product_list_items={};var s=document.getElementById("filter-header-template").innerHTML,l=Handlebars.compile(s),n={};n.breadcrumbs=r.breadcrumbs,n.headers=r.headers,n.sort_on=r.sort_on,n.search_string=r.search_string,n.show_search=void 0!=x.get("show_search")?x.get("show_search"):show_search_box;var o=l(n);if(document.getElementById("filter-header-template-content").innerHTML=o,searchFilter(!1),0==isMobile&&(window.location.href.match("/shop")&&""==y?window.history.pushState("categoryPage","Category","/shop"+y):window.history.pushState("categoryPage","Category",y)),1==t&&1==isMobile){$(".kss_filter-list").addClass("d-none");var c=$(e).closest(".kss_filter-list").data("filter");if($('.kss_filter-list[data-filter="'+c+'"]').removeClass("d-none"),$(".nav-item.active").find(".filter-count").hasClass("d-none"))var _=0;else var _=parseInt($(".nav-item.active").find(".filter-count").text());$(e).prop("checked")?_+=1:_-=1,_<0&&(_=0),$(".nav-item.active").find(".filter-count").text(_),0==_?$(".nav-item.active").find(".filter-count").addClass("d-none"):$(".nav-item.active").find(".filter-count").removeClass("d-none")}}):(collapsable_load_values[$("input[name='age']").data("facet-name")]=$("input[name='age']").data("collapsable"),collapsable_load_values[$("input[name='category']").data("facet-name")]=$("input[name='category']").data("collapsable"),collapsable_load_values[$("input[name='color']").data("facet-name")]=$("input[name='color']").data("collapsable"),collapsable_load_values[$("input[name='gender']").data("facet-name")]=$("input[name='gender']").data("collapsable"),collapsable_load_values[$("input[name='price']").data("facet-name")]=$("input[name='price']").data("collapsable"),collapsable_load_values[$("input[name='subtype']").data("facet-name")]=$("input[name='subtype']").data("collapsable"))}}function constructCategoryUrl(e,t,a,r){for(item in e){var i="",s=e[item],l=facet_display_data_arr[s];if(s in t){var n="";if(n=-1!==r.indexOf("?")?"&":"?","primary_filter"==l.filter_type&&(n+="pf"),"range_filter"==l.filter_type&&(n+="rf"),"boolean_filter"==l.filter_type&&(n+="bf"),t[e[item]].constructor===Array&&t[e[item]].length>1){var o=[];if("primary_filter"==l.filter_type)for(fitem in t[e[item]])o.push(a[e[item]][t[e[item]][fitem]]);if("boolean_filter"==l.filter_type)for(fitem in t[e[item]])o.push(t[e[item]][fitem]);l.is_attribute_param&&"primary_filter"==l.filter_type?(i=o.join(","),r+=n+"="+l.template+":"+i):l.is_attribute_param&&"boolean_filter"==l.filter_type?(i=o.join(","),r+=n+"="+i+":"+l.attribute_param):(i=o.join("--"),r+="/"+i)}else{var c="";l.is_attribute_param?("primary_filter"==l.filter_type?i=a[e[item]][t[e[item]]]:(console.log("bool==="+t[e[item]]),i=t[e[item]]),c=l.attribute_param):(i=t[e[item]][0],c=a[e[item]][i]),l.is_attribute_param?r+=n+"="+c+":"+i:r+="/"+c}}}return r}function removeFilterTag(e){var t=$("input[data-slug='"+e+"'].facet-category");"price"==e?(t.val(t.data("minval")+";"+t.data("maxval")),facetCategoryChange(t,!0,!0)):(t.removeAttr("checked"),t.trigger("change"))}function initializeSlider(e,t,a,r){$("#price-range").ionRangeSlider({type:"double",from:e,to:t,min:a,max:r,prefix:'<i class="fas fa-rupee-sign" aria-hidden="true"></i> ',onChange:function(e){$("#price-min").val(e.from),$("#price-max").val(e.to)},onFinish:function(e){facetCategoryChange($("#price-range"),!0,!0)}})}function searchItemInArray(e,t){var a=-1;return $.each(e,function(e,r){if(r.attribute_param==t)return a=e,!1}),a}function searchFilter(){var e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];""!=$(".custom-expand-search").val()?($(".custom-expand-search").focus(),$(".clear-search").removeClass("d-none")):($(".custom-expand-search").focus(),0==$(".clear-search").hasClass("d-none")&&$(".clear-search").addClass("d-none")),e&&facetCategoryChange($("#searchStringInp"),!0,!1,!1,!1,!0)}function loadProductListing(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:-1,t=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(-1==e)var a=$.url().param("page");else var a=e;var r=window.location.href,i=r.split("?"),s="";s=i.length>1?"&":"?";var l=1;void 0==a?(r=r+s+"page=2",l=2):(r=r.replace(/page=\d+/,"page="+(parseInt(a)+1)),l=parseInt(a)+1);var n=new window.URLSearchParams(window.location.search),o=Object.keys(facet_display_data_arr),c=Object.values(facet_display_data_arr),_=!0,d=!1,f=void 0;try{for(var p,u=n.entries()[Symbol.iterator]();!(_=(p=u.next()).done);_=!0)if(pair=p.value,"bf"==pair[0]){var m=pair[1].split("|"),g=!0,h=!1,v=void 0;try{for(var b,y=m[Symbol.iterator]();!(g=(b=y.next()).done);g=!0){filters_item=b.value;var x=filters_item.split(":"),w=searchItemInArray(c,x[0]);void 0!=o[w]&&void 0==boolean_facet_list[o[w]]&&void 0!=ajax_data.search_object.boolean_filter&&(ajax_data.search_object.boolean_filter[o[w]]="true"==x[1]||"false"==x[1]?JSON.parse(x[1]):x[1])}}catch(e){h=!0,v=e}finally{try{!g&&y.return&&y.return()}finally{if(h)throw v}}}else if("pf"==pair[0]){var j=pair[1].split(":");getPrimaryFiltersInfo(j[1],",")}else if("rf"==pair[0]){var j=pair[1].split(":"),C=j[1].split("TO"),w=searchItemInArray(c,x[0]);void 0==range_facet_list[o[w]]&&(ajax_data.search_object.range_filter[o[w]]={},ajax_data.search_object.range_filter[o[w]].min=C[0],ajax_data.search_object.range_filter[o[w]].max=C[1])}}catch(e){d=!0,f=e}finally{try{!_&&u.return&&u.return()}finally{if(d)throw f}}var k=window.location.pathname.split("/"),I=!0,O=!1,S=void 0;try{for(var H,T=k[Symbol.iterator]();!(I=(H=T.next()).done);I=!0)url_pfilter=H.value,"shop"!=url_pfilter&&getPrimaryFiltersInfo(url_pfilter)}catch(e){O=!0,S=e}finally{try{!I&&T.return&&T.return()}finally{if(O)throw S}}ajax_data.page=l,isMobile&&delete ajax_data.exclude_in_response,$.ajax({method:"POST",url:"/api/rest/v1/product-list",data:JSON.stringify(ajax_data),dataType:"json",contentType:"application/json"}).done(function(e){var a={},i={};$.each(e,function(e,t){"page"==e&&(a.page=t),"items"==e&&(a.products=t),"breadcrumbs"==e&&(i.breadcrumbs=t),"headers"==e&&(i.headers=t),"sort_on"==e&&(i.sort_on=t),"search_string"==e&&(i.search_string=t)});var s=document.getElementById("products-list-template").innerHTML,l=Handlebars.compile(s),o={},c=Object.keys(product_list_items).length;for(var _ in a.products)product_list_items[c+_]=a.products[_];console.log(product_list_items),o.products=product_list_items,Object.keys(product_list_items).length<=0?($(".productlist__row").addClass("d-none"),$(".productlist__na").removeClass("d-none")):($(".productlist__row").removeClass("d-none"),$(".productlist__na").addClass("d-none")),o.show_more=a.page.has_next;var d=l(o);if(document.getElementById("products-list-template-content").innerHTML=d,t){var s=document.getElementById("filter-header-template").innerHTML,l=Handlebars.compile(s),o={};o.breadcrumbs=i.breadcrumbs,o.headers=i.headers,o.sort_on=i.sort_on,o.search_string=i.search_string,o.show_search=void 0!=n.get("show_search")?n.get("show_search"):show_search_box;var d=l(o);document.getElementById("filter-header-template-content").innerHTML=d}window.history.pushState("categoryPageUrl","Category page",r)})}function getPrimaryFiltersInfo(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"--";if(""!=e){var a=e.split(t),r=!0,i=!1,s=void 0;try{for(var l,n=a[Symbol.iterator]();!(r=(l=n.next()).done);r=!0){single_pair=l.value;var o=slug_value_search_result[single_pair];void 0!=facet_list[o.facet_name]?(console.log("val=="+o.facet_value),console.log(facet_list[o.facet_name]),console.log("inarray=="+facet_list[o.facet_name].includes(o.facet_value)),$.isArray(facet_list[o.facet_name])&&0==facet_list[o.facet_name].includes(o.facet_value)&&ajax_data.search_object.primary_filter[o.facet_name].push(o.facet_value)):ajax_data.search_object.primary_filter[o.facet_name]=[o.facet_value]}}catch(e){i=!0,s=e}finally{try{!r&&n.return&&n.return()}finally{if(i)throw s}}}}function resetFilter(){facet_list={},range_facet_list={},boolean_facet_list={},ajax_data={search_object:[],listurl:"/"},product_list_items={},$(".nav-item").find(".filter-count").text(0),$(".nav-item").find(".filter-count").addClass("d-none"),$(".facet-category").prop("checked",!1),$("#price-range").val($("#price-range").data("minval")+";"+$("#price-range").data("maxval")),initPriceBar($("#price-range").data("minval"),$("#price-range").data("maxval"))}function isMobileScreen(){return $(window).width()<767}function clearSearch(){$("#searchStringInp").val(""),searchFilter()}function removeParam(e,t){var a=t.split("?")[0],r=[],i=-1!==t.indexOf("?")?t.split("?")[1]:"";if(""!==i){r=i.split("&");for(var s=r.length-1;s>=0;s-=1)r[s].split("=")[0]===e&&r.splice(s,1);a=a+"?"+r.join("&")}return a}var ajax_data={},page_val=1,collapsable_load_values={},isMobile=isMobileScreen();Handlebars.registerHelper("ifEquals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("assign",function(e,t,a){a.data.root||(a.data.root={}),a.data.root[e]=t}),Handlebars.registerHelper("ifImagesExist",function(e,t){return Object.keys(e).length>0?t.fn(this):t.inverse(this)}),$(function(){$(".kss_sizes .radio-input").prop("checked",!1),$(".select-size input[type=radio]").change(function(e){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price):jQuery("#kss-price-"+this.dataset.product_id+"-"+this.dataset.color_id).html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small><span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>");var t=$(this).closest(".select-size").find("button");t.removeClass("disabled"),t.prop("disabled",!1),t.addClass("cd-add-cart"),t.addClass("align-items-center"),t.addClass("d-flex"),t.addClass("justify-content-center"),t.html('<i class="kss_icon bag-icon-fill icon-sm"></i> Add To Bag')}),$(window).bind("popstate",function(){window.location.href=window.location.href}),$(document).on("click",".search-trigger",function(){searchFilter(""!=$(".custom-expand-search").val())}),$(document).on("keypress","#searchStringInp",function(e){13==e.keyCode?searchFilter():0==$(".clear-search").hasClass("d-none")&&$(".clear-search").addClass("d-none")}),$(document).mouseup(function(e){var t;t=$(".expandSearch"),t.is(e.target)||0!==t.has(e.target).length||""==$(".custom-expand-search").val()&&0==$(".clear-search").hasClass("d-none")&&($("#searchStringInp").val(""),searchFilter())})});var facet_list={},range_facet_list={},boolean_facet_list={},sort_on_filter="",search_string_filter="",filter_tags_list=[];$(document).ready(function(){var e=$.url().param("page");void 0!=e&&(page_val=e),$(".pl-loader").fadeOut("fast",function(){$("body").removeClass("overflow-h")}),$("body").on("shown.bs.collapse",".collapse",function(){collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")]=!1}),$("body").on("hidden.bs.collapse",".collapse",function(){collapsable_load_values[$("input[name='"+$(this).data("field")+"']").data("facet-name")]=!0}),$(document).on("click",".more-color",function(){$(".color-wrapper .card-body").toggleClass("is-open"),$(this).text(function(e,t){return"+ more"===t?"- less":"+ more"})}),$("body").on("click","#showMoreProductsBtn",function(){$(this).find(".load-icon-cls").removeClass("d-none"),$(this).addClass("disabled"),loadProductListing()})}),$(".kss_filter_mobile--left .nav-item").click(function(){var e=$(this);e.addClass("active").siblings().removeClass("active");var t=e.data("target");$(".kss_filter-list").addClass("d-none"),$('.kss_filter-list[data-filter="'+t+'"]').removeClass("d-none"),$('.kss_filter-list[data-filter="'+t+'"] .color-wrapper .card-body').addClass("is-open"),$('.kss_filter-list[data-filter="'+t+'"] .collapse').collapse("show"),$('.kss_filter-list[data-filter="'+t+'"] .color-wrapper .more-color').remove()});