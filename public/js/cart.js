function openCart(){loadAngularApp(),$("#main-nav").removeClass("speed-in"),$("#cd-cart").addClass("speed-in"),$("#cd-shadow-layer").addClass("is-visible"),$("body").addClass("hide-scroll")}function updateCartCountInUI(){var e=getCookie("cart_count");e&&"0"!=e?($(".cart-counter").removeClass("d-none"),$(".cart-counter").addClass("d-block"),$("#output").html(function(t,a){return e})):($(".cart-counter").addClass("d-none"),$(".cart-counter").removeClass("d-block"))}function set_cart_data(e){var t=sessionStorage.getItem("cart_data");if(t)t=JSON.parse(t);else var t=new Array;t.push(e),sessionStorage.setItem("cart_data",JSON.stringify(t))}function loadAngularApp(){loaded||$.when($.getScript("/views/cart/inline.bundle.js"),$.getScript("/views/cart/polyfills.bundle.js"),$.getScript("/views/cart/styles.bundle.css"),$.getScript("/views/cart/vendor.bundle.js"),$.Deferred(function(e){$(e.resolve)})).done(function(){$.getScript("/views/cart/main.bundle.js"),loaded=!0})}function isLoggedInUser(){return!(!getCookie("token")||!getCookie("cart_id"))}function getCookie(e){for(var t=e+"=",a=decodeURIComponent(document.cookie),s=a.split(";"),o=0;o<s.length;o++){for(var n=s[o];" "==n.charAt(0);)n=n.substring(1);if(0==n.indexOf(t))return n.substring(t.length,n.length)}return""}$(document).ready(function(){function e(){n=setTimeout(function(){$(".kss-alert").removeClass("is-open"),$(".kss-alert").removeClass("kss-alert--success"),$(".kss-alert").removeClass("kss-alert--failure"),$("#cd-cart").css("pointer-events","auto")},4500)}function t(){var t=isLoggedInUser()?"/api/rest/v1/user/cart/"+getCookie("cart_id")+"/insert":"/rest/v1/anonymous/cart/insert",n=$('meta[name="csrf-token"]').attr("content"),r={_token:n,variant_id:$("input[type=radio][name=kss-sizes]:checked")[0].dataset.variant_id,variant_quantity:1};$.ajax({url:t,type:"POST",headers:{Authorization:isLoggedInUser()?"Bearer "+getCookie("token"):""},data:r,dataType:"JSON",success:function(t){$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .btn-label-initial").addClass("d-flex"),$(".cd-add-to-cart .btn-label-initial").removeClass("d-none"),document.cookie="cart_count="+t.cart_count+";path=/",sessionStorage.setItem("addded_to_cart","true"),updateCartCountInUI(),$(".cd-add-to-cart").removeClass("cartLoader"),e()},error:function(e,t,n){console.log("Check ==>",e),e.responseJSON&&401==e.responseJSON.status?s():isLoggedInUser()&&0!=e.status&&(400==e.responseJSON.status||403==e.responseJSON.status)?o():a(e)}})}function a(t){console.log("showErrorPopup function start");var a=t.responseJSON&&""!=t.responseJSON.message?t.responseJSON.message:"Could not add to bag";$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .btn-label-initial").addClass("d-flex"),$(".cd-add-to-cart .btn-label-initial").removeClass("d-none"),$(".kss-alert .message").html("<strong>Failed!!!</strong> "+a),$(".kss-alert").addClass("kss-alert--failure"),$(".kss-alert").addClass("is-open"),$("#cd-cart").css("pointer-events","none"),$(".cd-add-to-cart").removeClass("cartLoader"),e(),sessionStorage.setItem("addded_to_cart","false")}function s(){document.cookie="cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",document.cookie="token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",a()}function o(){$.ajax({url:"/api/rest/v1/user/cart/mine",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(e){e.cart_id==getCookie("cart_id")?a():(document.cookie="cart_id="+e.cart_id+";path=/",t())},error:function(e,t,s){a()}})}updateCartCountInUI(),console.log("window.location.href ==>",window.location.href),(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&openCart(),window.onhashchange=function(){console.log("hash changed"),!$("#cd-cart").hasClass("speed-in")&&(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&openCart()};var n;$(".cd-add-to-cart").on("click",function(){var e=this;$(e).hasClass("cartLoader")||($(".cd-add-to-cart .btn-label-initial").addClass("d-none"),$(".cd-add-to-cart .btn-label-initial").removeClass("d-flex"),$(".cd-add-to-cart .btn-icon").show(),$(e).addClass("cartLoader"),sessionStorage.setItem("add_to_cart_clicked","true"),openCart(),0==$("input[type=radio][name=kss-sizes]:checked").length?(jQuery(".kss_sizes").addClass("shake"),setTimeout(function(){jQuery(".kss_sizes").removeClass("shake")},200)):t())}),$(".kss-alert .alert-close").on("click",function(){$(".kss-alert").removeClass("is-open"),$("#cd-cart").css("pointer-events","auto"),n&&clearTimeout(n)}),$('[data-toggle="tooltip"]').tooltip(),jQuery("#cd-cart-trigger").click(function(){openCart()})}),$(".select-size button").click(function(){}),loaded=!1;