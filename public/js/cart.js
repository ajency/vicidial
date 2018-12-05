function openCart(){loadAngularApp(),$("#main-nav").removeClass("speed-in"),$("#cd-cart").addClass("speed-in"),$("#cd-shadow-layer").addClass("is-visible"),$("body").addClass("hide-scroll")}function openMyAccountPage(){loadMyAccountApp(),$("#main-nav").removeClass("speed-in"),$("#cd-my-account").addClass("speed-in"),$("#cd-shadow-layer").addClass("is-visible"),$("body").addClass("hide-scroll")}function updateCartCountInUI(){var t=getCookie("cart_count");t&&"0"!=t?($(".cart-counter").removeClass("d-none"),$(".cart-counter").addClass("d-block"),$("#output").html(function(e,a){return t})):($(".cart-counter").addClass("d-none"),$(".cart-counter").removeClass("d-block"))}function loadAngularApp(){loaded||$.getScript("/views/cart/inline.bundle.js").done(function(t,e){$.getScript("/views/cart/vendor.bundle.js").done(function(t,e){$.getScript("/views/cart/polyfills.bundle.js").done(function(t,e){$.getScript("/views/cart/main.bundle.js").done(function(t,e){loaded=!0}).fail(function(t,e,a){})}).fail(function(t,e,a){})}).fail(function(t,e,a){})}).fail(function(t,e,a){})}function isLoggedInUser(){return!(!getCookie("token")||!getCookie("cart_id"))}function getCookie(t){for(var e=t+"=",a=decodeURIComponent(document.cookie),o=a.split(";"),n=0;n<o.length;n++){for(var i=o[n];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(e))return i.substring(e.length,i.length)}return""}function fbTrackuserRegistration(){}function fbTrackAddToCart(t){}function fbTrackInitiateCheckout(t){}function loadMyAccountApp(){$.getScript("/views/my-account/inline.bundle.js").done(function(t,e){$.getScript("/views/my-account/vendor.bundle.js").done(function(t,e){$.getScript("/views/my-account/polyfills.bundle.js").done(function(t,e){$.getScript("/views/my-account/main.bundle.js").done(function(t,e){}).fail(function(t,e,a){})}).fail(function(t,e,a){})}).fail(function(t,e,a){})}).fail(function(t,e,a){})}var add_to_cart_failed=!1,add_to_cart_failure_message="",add_to_cart_clicked=!1,add_to_cart_completed=!1;$(document).ready(function(){function t(){!$("#cd-my-account").hasClass("speed-in")&&(window.location.href.endsWith("#/account/my-orders")||window.location.href.endsWith("#/account")||window.location.href.endsWith("#/account/user-verification"))&&openMyAccountPage()}function e(){c=setTimeout(function(){$(".kss-alert").removeClass("is-open"),$(".kss-alert").removeClass("kss-alert--success"),$(".kss-alert").removeClass("kss-alert--failure"),$("#cd-cart").css("pointer-events","auto")},4500)}function a(){var t=$("input[type=radio][name=kss-sizes]:checked")[0].dataset.variant_id;fbTrackAddToCart(t);var a=isLoggedInUser()?"/api/rest/v1/user/cart/"+getCookie("cart_id")+"/insert":"/rest/v1/anonymous/cart/insert",s=$('meta[name="csrf-token"]').attr("content"),c={_token:s,variant_id:t,variant_quantity:1};$.ajax({url:a,type:"POST",headers:{Authorization:isLoggedInUser()?"Bearer "+getCookie("token"):""},data:c,dataType:"JSON",success:function(t){$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),document.cookie="cart_count="+t.cart_count+";path=/",add_to_cart_completed=!0,updateCartCountInUI(),$(".cd-add-to-cart").removeClass("cartLoader"),e()},error:function(t,e,a){401==t.status?n(t):isLoggedInUser()&&0!=t.status&&(400==t.status||403==t.status)?i(t):o(t)}})}function o(t){var a=t&&t.responseJSON&&""!=t.responseJSON.message?t.responseJSON.message:"Could not add to bag";add_to_cart_failed=!0,add_to_cart_completed=!0,add_to_cart_failure_message="Quantity not available"==a?"Could not add "+$(".section-heading--single").text()+" to bag as it is out of stock":"invalid cart"==a?"Hey, before you add your item to bag it looks like you were interrupted during your last checkout. You can place this existing order or edit bag to add more items.":"Due to the high traffic, there was an issue adding your item to bag. Please try adding the item again",$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),$(".cd-add-to-cart").removeClass("cartLoader"),e()}function n(t){document.cookie="cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",document.cookie="token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",o(t)}function i(t){$.ajax({url:"/api/rest/v1/user/cart/mine",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(e){document.cookie="cart_id="+e.cart_id+";path=/","cart"==e.cart_type?a():s(t)},error:function(t,e,a){o(t)}})}function s(t){$.ajax({url:"/api/rest/v1/user/cart/start-fresh",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(t){document.cookie="cart_id="+t.cart_id+";path=/",a()},error:function(t,e,a){o(t)}})}updateCartCountInUI(),(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&openCart(),window.onhashchange=function(){!$("#cd-cart").hasClass("speed-in")&&(window.location.href.endsWith("#bag")||window.location.href.endsWith("#bag/user-verification")||window.location.href.endsWith("#shipping-address")||window.location.href.endsWith("#shipping-summary"))&&openCart(),t()},t();var c;$(".cd-add-to-cart").on("click",function(){var t=this;$(t).hasClass("cartLoader")||($(".cd-add-to-cart .kss-btn__wrapper").addClass("d-none"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-flex"),$(".cd-add-to-cart .btn-icon").show(),$(t).addClass("cartLoader"),add_to_cart_clicked=!0,openCart(),0==$("input[type=radio][name=kss-sizes]:checked").length?(jQuery(".kss_sizes").addClass("shake"),setTimeout(function(){jQuery(".kss_sizes").removeClass("shake")},200)):a())}),$(".kss-alert .alert-close").on("click",function(){$(".kss-alert").removeClass("is-open"),$("#cd-cart").css("pointer-events","auto"),c&&clearTimeout(c)}),$('[data-toggle="tooltip"]').tooltip(),jQuery("#cd-cart-trigger").click(function(){openCart()}),jQuery("#cd-my-account-trigger").click(function(){openMyAccountPage()})}),$(".select-size button").click(function(){}),loaded=!1;