function openCart(){loadAngularApp(),$("#main-nav").removeClass("speed-in"),$("#cd-cart").addClass("speed-in"),$("#cd-shadow-layer").addClass("is-visible"),$("body").addClass("hide-scroll")}function updateCartCountInUI(){var e=getCookie("cart_count");e&&"0"!=e?($(".cart-counter").removeClass("d-none"),$(".cart-counter").addClass("d-block"),$("#output").html(function(t,a){return e})):($(".cart-counter").addClass("d-none"),$(".cart-counter").removeClass("d-block"))}function loadAngularApp(){loaded||$.getScript("/views/cart/inline.bundle.js").done(function(e,t){console.log(t),$.getScript("/views/cart/vendor.bundle.js").done(function(e,t){console.log(t),$.getScript("/views/cart/polyfills.bundle.js").done(function(e,t){console.log(t),$.getScript("/views/cart/main.bundle.js").done(function(e,t){console.log(t),loaded=!0}).fail(function(e,t,a){console.log("angular load failed")})}).fail(function(e,t,a){console.log("angular load failed")})}).fail(function(e,t,a){console.log("angular load failed")})}).fail(function(e,t,a){console.log("angular load failed")})}function isLoggedInUser(){return!(!getCookie("token")||!getCookie("cart_id"))}function getCookie(e){for(var t=e+"=",a=decodeURIComponent(document.cookie),o=a.split(";"),n=0;n<o.length;n++){for(var r=o[n];" "==r.charAt(0);)r=r.substring(1);if(0==r.indexOf(t))return r.substring(t.length,r.length)}return""}function fbTrackuserRegistration(){console.log("fb pixel userRegistrationSuccess"),fbq("track","CompleteRegistration")}function fbTrackAddToCart(e){console.log(e,variants,selected_color_id);var t=variants[selected_color_id].variants.find(function(t){return t.id==e});console.log(t),fbq("track","AddToCart",{value:t.sale_price,currency:"INR",content_ids:e,content_type:"product"})}function fbTrackInitiateCheckout(e){console.log(e),fbq("track","InitiateCheckout",{value:e,currency:"INR"})}var add_to_cart_failed=!1,add_to_cart_failure_message="",add_to_cart_clicked=!1,add_to_cart_completed=!1;$(document).ready(function(){function e(){s=setTimeout(function(){$(".kss-alert").removeClass("is-open"),$(".kss-alert").removeClass("kss-alert--success"),$(".kss-alert").removeClass("kss-alert--failure"),$("#cd-cart").css("pointer-events","auto")},4500)}function t(){var t=$("input[type=radio][name=kss-sizes]:checked")[0].dataset.variant_id;fbTrackAddToCart(t),console.log("add_to_cart_failed ==>",add_to_cart_failed),console.log("add_to_cart_failure_message ==>",add_to_cart_failure_message);var r=isLoggedInUser()?"/api/rest/v1/user/cart/"+getCookie("cart_id")+"/insert":"/rest/v1/anonymous/cart/insert",s=$('meta[name="csrf-token"]').attr("content"),i={_token:s,variant_id:t,variant_quantity:1};$.ajax({url:r,type:"POST",headers:{Authorization:isLoggedInUser()?"Bearer "+getCookie("token"):""},data:i,dataType:"JSON",success:function(t){$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),document.cookie="cart_count="+t.cart_count+";path=/",add_to_cart_completed=!0,updateCartCountInUI(),$(".cd-add-to-cart").removeClass("cartLoader"),e()},error:function(e,t,r){console.log("Check ==>",e),401==e.status?o(e):isLoggedInUser()&&0!=e.status&&(400==e.status||403==e.status)?n(e):a(e)}})}function a(t){var a=t&&t.responseJSON&&""!=t.responseJSON.message?t.responseJSON.message:"Could not add to bag";add_to_cart_failed=!0,add_to_cart_completed=!0,console.log("error_msg",a),add_to_cart_failure_message="Quantity not available"==a?"Could not add "+$(".section-heading--single").text()+" to bag as it is out of stock":"invalid cart"==a?"Hey, before you add your item to bag it looks like you were interrupted during your last checkout. You can place this existing order or edit bag to add more items.":"Due to the high traffic, there was an issue adding your item to bag. Please try adding the item again",$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),$(".cd-add-to-cart").removeClass("cartLoader"),e()}function o(e){document.cookie="cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",document.cookie="token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",a(e)}function n(e){$.ajax({url:"/api/rest/v1/user/cart/mine",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(a){document.cookie="cart_id="+a.cart_id+";path=/","cart"==a.cart_type?t():r(e)},error:function(e,t,o){a(e)}})}function r(e){$.ajax({url:"/api/rest/v1/user/cart/start-fresh",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(e){document.cookie="cart_id="+e.cart_id+";path=/",t()},error:function(e,t,o){a(e)}})}updateCartCountInUI(),console.log("window.location.href ==>",window.location.href),(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&openCart(),window.onhashchange=function(){console.log("hash changed"),!$("#cd-cart").hasClass("speed-in")&&(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&(console.log("opening cart from vanilla js"),openCart())};var s;$(".cd-add-to-cart").on("click",function(){var e=this;$(e).hasClass("cartLoader")||($(".cd-add-to-cart .kss-btn__wrapper").addClass("d-none"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-flex"),$(".cd-add-to-cart .btn-icon").show(),$(e).addClass("cartLoader"),add_to_cart_clicked=!0,openCart(),0==$("input[type=radio][name=kss-sizes]:checked").length?(jQuery(".kss_sizes").addClass("shake"),setTimeout(function(){jQuery(".kss_sizes").removeClass("shake")},200)):t())}),$(".kss-alert .alert-close").on("click",function(){$(".kss-alert").removeClass("is-open"),$("#cd-cart").css("pointer-events","auto"),s&&clearTimeout(s)}),$('[data-toggle="tooltip"]').tooltip(),jQuery("#cd-cart-trigger").click(function(){openCart()})}),$(".select-size button").click(function(){}),loaded=!1;