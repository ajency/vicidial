function openCart(){loadAngularApp(),$("#main-nav").removeClass("speed-in"),$("#cd-cart").addClass("speed-in"),$("#cd-shadow-layer").addClass("is-visible"),$("body").addClass("hide-scroll")}function updateCartCountInUI(){var e=getCookie("cart_count");e&&"0"!=e?($(".cart-counter").removeClass("d-none"),$(".cart-counter").addClass("d-block"),$("#output").html(function(t,a){return e})):($(".cart-counter").addClass("d-none"),$(".cart-counter").removeClass("d-block"))}function set_cart_data(e){var t=sessionStorage.getItem("cart_data");if(t)t=JSON.parse(t);else var t=new Array;t.push(e),sessionStorage.setItem("cart_data",JSON.stringify(t))}function loadAngularApp(){loaded||$.getScript("/views/cart/inline.bundle.js").done(function(e,t){console.log(t),$.getScript("/views/cart/vendor.bundle.js").done(function(e,t){console.log(t),$.getScript("/views/cart/polyfills.bundle.js").done(function(e,t){console.log(t),$.getScript("/views/cart/main.bundle.js").done(function(e,t){console.log(t),loaded=!0}).fail(function(e,t,a){console.log("angular load failed")})}).fail(function(e,t,a){console.log("angular load failed")})}).fail(function(e,t,a){console.log("angular load failed")})}).fail(function(e,t,a){console.log("angular load failed")})}function isLoggedInUser(){return!(!getCookie("token")||!getCookie("cart_id"))}function getCookie(e){for(var t=e+"=",a=decodeURIComponent(document.cookie),o=a.split(";"),n=0;n<o.length;n++){for(var s=o[n];" "==s.charAt(0);)s=s.substring(1);if(0==s.indexOf(t))return s.substring(t.length,s.length)}return""}var add_to_cart_failed=!1,add_to_cart_failure_message="";$(document).ready(function(){function e(){s=setTimeout(function(){$(".kss-alert").removeClass("is-open"),$(".kss-alert").removeClass("kss-alert--success"),$(".kss-alert").removeClass("kss-alert--failure"),$("#cd-cart").css("pointer-events","auto")},4500)}function t(){console.log("add_to_cart_failed ==>",add_to_cart_failed),console.log("add_to_cart_failure_message ==>",add_to_cart_failure_message);var t=isLoggedInUser()?"/api/rest/v1/user/cart/"+getCookie("cart_id")+"/insert":"/rest/v1/anonymous/cart/insert",s=$('meta[name="csrf-token"]').attr("content"),r={_token:s,variant_id:$("input[type=radio][name=kss-sizes]:checked")[0].dataset.variant_id,variant_quantity:1};$.ajax({url:t,type:"POST",headers:{Authorization:isLoggedInUser()?"Bearer "+getCookie("token"):""},data:r,dataType:"JSON",success:function(t){$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),document.cookie="cart_count="+t.cart_count+";path=/",sessionStorage.setItem("addded_to_cart","true"),updateCartCountInUI(),$(".cd-add-to-cart").removeClass("cartLoader"),e()},error:function(e,t,s){console.log("Check ==>",e),401==e.status?o(e):isLoggedInUser()&&0!=e.status&&(400==e.status||403==e.status)?n():a(e)}})}function a(t){var a=t&&t.responseJSON&&""!=t.responseJSON.message?t.responseJSON.message:"Could not add to bag";add_to_cart_failed=!0,add_to_cart_failure_message="Quantity not available"==a?"Could not add "+$(".section-heading--single").text()+" to bag as it is out of stock":"Due to the high traffic, there was an issue adding your item to cart. Please try adding the item again",$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),$("#cd-cart").css("pointer-events","none"),$(".cd-add-to-cart").removeClass("cartLoader"),e(),sessionStorage.setItem("addded_to_cart","false")}function o(e){document.cookie="cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",document.cookie="token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",a(e)}function n(){$.ajax({url:"/api/rest/v1/user/cart/mine",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(e){e.cart_id==getCookie("cart_id")?a():(document.cookie="cart_id="+e.cart_id+";path=/",t())},error:function(e,t,o){a()}})}updateCartCountInUI(),console.log("window.location.href ==>",window.location.href),(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&openCart(),window.onhashchange=function(){console.log("hash changed"),!$("#cd-cart").hasClass("speed-in")&&(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&(console.log("opening cart from vanilla js"),openCart())};var s;$(".cd-add-to-cart").on("click",function(){var e=this;$(e).hasClass("cartLoader")||($(".cd-add-to-cart .kss-btn__wrapper").addClass("d-none"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-flex"),$(".cd-add-to-cart .btn-icon").show(),$(e).addClass("cartLoader"),sessionStorage.setItem("add_to_cart_clicked","true"),openCart(),0==$("input[type=radio][name=kss-sizes]:checked").length?(jQuery(".kss_sizes").addClass("shake"),setTimeout(function(){jQuery(".kss_sizes").removeClass("shake")},200)):t())}),$(".kss-alert .alert-close").on("click",function(){$(".kss-alert").removeClass("is-open"),$("#cd-cart").css("pointer-events","auto"),s&&clearTimeout(s)}),$('[data-toggle="tooltip"]').tooltip(),jQuery("#cd-cart-trigger").click(function(){openCart()})}),$(".select-size button").click(function(){}),loaded=!1;