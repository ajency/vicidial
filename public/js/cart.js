var add_to_cart_failed=!1,add_to_cart_failure_message="",add_to_cart_clicked=!1,add_to_cart_completed=!1;function openCart(){loadAngularApp(),$("#main-nav").removeClass("speed-in"),$("#cd-cart").addClass("speed-in"),$("#cd-shadow-layer").addClass("is-visible"),$("body").addClass("hide-scroll")}function updateCartCountInUI(){var t=getCookie("cart_count");t&&"0"!=t?($(".cart-counter").removeClass("d-none"),$(".cart-counter").addClass("d-block"),$("#output").html(function(e,a){return t})):($(".cart-counter").addClass("d-none"),$(".cart-counter").removeClass("d-block"))}function loadAngularApp(){loaded||$.getScript("/views/cart/inline.bundle.js").done(function(t,e){$.getScript("/views/cart/vendor.bundle.js").done(function(t,e){$.getScript("/views/cart/polyfills.bundle.js").done(function(t,e){$.getScript("/views/cart/main.bundle.js").done(function(t,e){loaded=!0}).fail(function(t,e,a){})}).fail(function(t,e,a){})}).fail(function(t,e,a){})}).fail(function(t,e,a){})}function isLoggedInUser(){return!(!getCookie("token")||!getCookie("cart_id"))}function getCookie(t){for(var e=t+"=",a=decodeURIComponent(document.cookie).split(";"),o=0;o<a.length;o++){for(var n=a[o];" "==n.charAt(0);)n=n.substring(1);if(0==n.indexOf(e))return n.substring(e.length,n.length)}return""}function fbTrackuserRegistration(){}function fbTrackAddToCart(t){var e=variants[selected_color_id].variants.find(function(e){return e.id==t});fbq("track","AddToCart",{value:e.sale_price,currency:"INR",content_ids:parent_id+"-"+selected_color_id,content_type:"product"})}function fbTrackInitiateCheckout(t){fbq("track","InitiateCheckout",{value:t,currency:"INR"})}function fbTrackAddPaymentInfo(){fbq("track","AddPaymentInfo")}$(document).ready(function(){var t;function e(){t=setTimeout(function(){$(".kss-alert").removeClass("is-open"),$(".kss-alert").removeClass("kss-alert--success"),$(".kss-alert").removeClass("kss-alert--failure"),$("#cd-cart").css("pointer-events","auto")},4500)}function a(){var t=$("input[type=radio][name=kss-sizes]:checked")[0].dataset.variant_id;fbTrackAddToCart(t);var n=isLoggedInUser()?"/api/rest/v1/user/cart/"+getCookie("cart_id")+"/insert":"/rest/v1/anonymous/cart/insert",r={_token:$('meta[name="csrf-token"]').attr("content"),variant_id:t,variant_quantity:1};$.ajax({url:n,type:"POST",headers:{Authorization:isLoggedInUser()?"Bearer "+getCookie("token"):""},data:r,dataType:"JSON",success:function(t){$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),document.cookie="cart_count="+t.cart_count+";path=/",add_to_cart_completed=!0,updateCartCountInUI(),$(".cd-add-to-cart").removeClass("cartLoader"),e()},error:function(t,e,n){401==t.status?function(t){document.cookie="cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",document.cookie="token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;",o(t)}(t):0==t.status?o(t):isLoggedInUser()||403!=t.status?isLoggedInUser()&&400==t.status||403==t.status?$.ajax({url:"/api/rest/v1/user/cart/mine",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(t){document.cookie="cart_id="+t.cart_id+";path=/","cart"==t.cart_type?a():$.ajax({url:"/api/rest/v1/user/cart/start-fresh",type:"GET",headers:{Authorization:"Bearer "+getCookie("token")},data:{},dataType:"JSON",success:function(t){document.cookie="cart_id="+t.cart_id+";path=/",a()},error:function(t,e,a){o(t)}})},error:function(t,e,a){o(t)}}):o(t):a()}})}function o(t){var a=t&&t.responseJSON&&""!=t.responseJSON.message?t.responseJSON.message:"Could not add to bag";add_to_cart_failed=!0,add_to_cart_completed=!0,add_to_cart_failure_message="Quantity not available"==a?"Could not add "+$(".section-heading--single").text()+" to bag as it is out of stock":"invalid cart"==a?"Hey, before you add your item to bag it looks like you were interrupted during your last checkout. You can place this existing order or edit bag to add more items.":"Due to the high traffic, there was an issue adding your item to bag. Please try adding the item again",$(".cd-add-to-cart .btn-icon").hide(),$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-flex"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-none"),$(".cd-add-to-cart").removeClass("cartLoader"),e()}updateCartCountInUI(),(window.location.href.includes("#/bag")||window.location.href.includes("#/account"))&&openCart(),window.onhashchange=function(){console.log("hash changed"),$("#cd-cart").hasClass("speed-in")||!window.location.href.includes("#/bag")&&!window.location.href.includes("#/account")||openCart()},$(".cd-add-to-cart").on("click",function(){if(!$(this).hasClass("cartLoader")){$(".cd-add-to-cart .kss-btn__wrapper").addClass("d-none"),$(".cd-add-to-cart .kss-btn__wrapper").removeClass("d-flex"),$(".cd-add-to-cart .btn-icon").show(),$(this).addClass("cartLoader"),add_to_cart_clicked=!0;var t=window.location.href.split("#")[0]+"#/bag";window.location=t,0==$("input[type=radio][name=kss-sizes]:checked").length?(jQuery(".kss_sizes").addClass("shake"),setTimeout(function(){jQuery(".kss_sizes").removeClass("shake")},200)):a()}}),$(".kss-alert .alert-close").on("click",function(){$(".kss-alert").removeClass("is-open"),$("#cd-cart").css("pointer-events","auto"),t&&clearTimeout(t)}),$('[data-toggle="tooltip"]').length&&$('[data-toggle="tooltip"]').tooltip(),jQuery("#cd-my-account-trigger").click(function(){var t=window.location.href.split("#")[0]+"#/account";window.location=t}),jQuery("#cd-cart-trigger").click(function(){var t=window.location.href.split("#")[0]+"#/bag";window.location=t})}),$(".select-size button").click(function(){}),loaded=!1;
