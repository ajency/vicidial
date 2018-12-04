 // ------------------ Start Close Cart Modal------------------//
 $('.modal #cart_close').click(function() {
     $("#cd-cart").removeAttr("style");
 });
 // ------------------ End Close Cart Modal------------------//
 $(function() {
     var $carousel = $('.prod-slides');
     $carousel.on('lazyLoad.flickity', function() {
         // Remove loader on Flickity init
         $(".loader").fadeOut(1000);
         // Hide navigation if length equals 1
         var flkty = new Flickity('.prod-slides');
         if (flkty.slides.length == 1) {
             $('.flickity-button').hide();
         }
     });
     $carousel.flickity({
         // options
         cellAlign: 'left',
         freeScroll: true,
         contain: true,
         lazyLoad: 2,
         pageDots: false
     });
     // initialize Flickity
     $carousel.flickity();
 })
 // ------------------ Start Image Load ------------------//
 const lazy = () => {
     document.addEventListener('lazyloaded', (e) => {
         e.target.parentNode.classList.add('image-loaded');
         e.target.parentNode.classList.remove('loading');
     });
 }
 lazy();
 // ------------------ End Image Load ------------------//
 // $('.stellarnav').stellarNav({
 //     position: "left",
 //     breakpoint: 992,
 //     menuLabel: " ",
 //     closingDelay: 150,
 //     mobileMode: true
 // });
 // ------------------ Start Image Loader ------------------//
 $(document).ready(function() {
     $(function() {
         // $(".loader").fadeOut(2000, function() {
         //     $(".prod-slides li img").fadeIn(1000);
         // });
         if ($('#aniimated-thumbnials').hasClass('slider-placeholder-img')) {
             $(".loader").fadeOut(2000);
         }
     });
     // ------------------ End Image Loader ------------------//
     // $('#aniimated-thumbnials').lightGallery({
     //         selector: '.custom-selector',
     //         preload: 0,
     //         download: false,
     //         fullScreen: false,
     //         autoplayControls: false,
     //         share: false
     //  });
     // ------------------ Start Filter For Mobile ------------------//
     jQuery("#filter").click(function() {
         jQuery(".kss_filter").addClass("kss_filter_mobile");
         // jQuery(".kss_filter_mobile--left .nav-item").removeClass("active");
         // jQuery(".kss_filter_mobile--left .nav-item:first-child").addClass("active");
         // jQuery('.kss_filter-list').addClass('d-none');
         // jQuery('.kss_filter-list[data-filter="category"]').removeClass('d-none');
     });
     jQuery(".clear-filter").click(function() {
         jQuery(".filter-selection").attr("style", "display: none !important");
     });
     jQuery(document).on('click', '#kss_hide-filter', function() {
         jQuery(".kss_filter").removeClass("kss_filter_mobile");
     });
     // ------------------ End Filter For Mobile ------------------//
     // ------------------ Start Disable Arrow on single product ------------------//
     jQuery(".prod-slides img").click(function() {
         jQuery(".swipe-arrow").removeClass("swipe-arrow-visible");
     });
     // ------------------ Mobile View ------------------//
     jQuery("#cart_close").click(function() {
         jQuery("#kss_cart").removeClass("fixed-bottom");
     });
     // ------------------ Mobile View ------------------//
     if ($(window).width() < 760) {
         $('.similar-link').appendTo('.m-similar');
         $('.search-icon').click(function() {
             $('.search-icon').addClass("d-block");
         });
         /* ==========================================
         scrollTop() >= 300
         Should be equal the the height of the header
         ========================================== */
         $(window).scroll(function() {
             if ($(window).scrollTop() >= 300) {
                 $('.top-navbar').addClass('sticky-menu');
             } else {
                 $('.top-navbar').removeClass('sticky-menu');
             }
         });
     } else {
         $('.kss_zoom a').removeClass('js-smartphoto');
     }
     // ------------------ Swipe Animation ------------------//
     jQuery(function() {
         jQuery('.slick-slider').on('afterChange', function(event, slick, currentSlide, nextSlide) {
             jQuery(".swipe-arrow").removeClass("swipe-arrow-visible");
         });
     })
     // ------------------ Shortlist Icon ------------------//
     $('.kss_heart').on('click', function() {
         $(this).toggleClass('animated-heart');
     });
     // ------------------ Shortlist Icon ------------------//
     // if ($(window).width() < 992) {
     //     $(".navbar-collapse").mmenu({
     //         wrappers: ["bootstrap4"],
     //         "extensions": ["fx-menu-zoom", "fx-panels-zoom", "pagedim-black", "theme-dark"]
     //     }, {
     //         clone: true
     //     });
     //     api = $('#mm-0').data('mmenu');
     //     api.bind('open:finish', function() {
     //         return $('.navbar-toggler').addClass('is-active');
     //     });
     //     api.bind('close:finish', function() {
     //         return $('.navbar-toggler').removeClass('is-active');
     //     });
     // }
     //if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
     var $L = 1200,
         $menu_navigation = $('#main-nav'),
         $cancel_trigger = $('.cancel-trigger'),
         $hamburger_icon = $('#cd-hamburger-menu'),
         $lateral_cart = $('#cd-cart'),
         $shadow_layer = $('#cd-shadow-layer');
     $cart_cancel = $('#cart_close');
     //open lateral menu on mobile
     $hamburger_icon.on('click', function(event) {
         event.preventDefault();
         //close cart panel (if it's open)
         $lateral_cart.removeClass('speed-in');
         toggle_panel_visibility($menu_navigation, $shadow_layer, $('body'));
     });
     $cancel_trigger.on('click', function(event) {
         event.preventDefault();
         //close lateral menu (if it's open)
         $menu_navigation.removeClass('speed-in');
         toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
         $("body").addClass("hide-scroll");
     });
     jQuery("#new-address").click(function() {
         event.preventDefault();
         //close lateral menu (if it's open)
         $(".kss_shipping").addClass("slide-show");
         $(".kss_shipping  .fixed-bottom").removeClass('d-none');
         $(".kss_shipping  .fixed-bottom").addClass('d-block');
         $menu_navigation.removeClass('speed-in');
         toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
         $("body").addClass("hide-scroll");
     });
     $cart_cancel.on('click', function() {
         $shadow_layer.removeClass('is-visible');
         // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
         if ($lateral_cart.hasClass('speed-in')) {
             $lateral_cart.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
                 $('body').removeClass('overflow-hidden');
             });
             $menu_navigation.removeClass('speed-in');
         } else {
             $menu_navigation.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
                 $('body').removeClass('overflow-hidden');
             });
             $lateral_cart.removeClass('speed-in');
         }
         $("body").removeClass("hide-scroll");
     });
     //move #main-navigation inside header on laptop
     //insert #main-navigation after header on mobile
     move_navigation($menu_navigation, $L);
     $(window).on('resize', function() {
         move_navigation($menu_navigation, $L);
         if ($(window).width() >= $L && $menu_navigation.hasClass('speed-in')) {
             $menu_navigation.removeClass('speed-in');
             $shadow_layer.removeClass('is-visible');
             $('body').removeClass('overflow-hidden');
         }
     });
     $('body').on('click', '.view-signup', function() {
         $('.sign-in-box').addClass('d-none');
         $('.sign-up-box').removeClass('d-none');
     })
     $('body').on('click', '.view-signin', function() {
         $('.sign-up-box , .reset-box').addClass('d-none');
         $('.sign-in-box').removeClass('d-none');
     })
     $('body').on('click', '.view-reset', function() {
         $('.sign-in-box').addClass('d-none');
         $('.reset-box').removeClass('d-none');
     })
     // $('body').on('click', '.btn', function() {
     //     var clickedbutton = $(this);
     //     clickedbutton.addClass('loading');
     //     // replace timeout with success event
     //     setTimeout(function() {
     //         clickedbutton.removeClass('loading');
     //         clickedbutton.addClass('loaded');
     //     }, 1000);
     // })
 })

 function toggle_panel_visibility($lateral_panel, $background_layer, $body) {
     if ($lateral_panel.hasClass('speed-in')) {
         // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
         $lateral_panel.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
             $body.removeClass('overflow-hidden');
         });
         $background_layer.removeClass('is-visible');
     } else {
         $lateral_panel.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
             $body.addClass('overflow-hidden');
         });
         $background_layer.addClass('is-visible');
     }
 }

 function move_navigation($navigation, $MQ) {
     if ($(window).width() >= $MQ) {
         $navigation.detach();
         $navigation.appendTo('header');
     } else {
         $navigation.detach();
         $navigation.insertAfter('header');
     }
 }
 // ------------------ Image Load ------------------//
 jQuery(window).on("load", function() {
     // jQuery.ready.then(function() {
     //     var imgDefer = document.getElementsByTagName('img');
     //     for (var i = 0; i < imgDefer.length; i++) {
     //         if (imgDefer[i].getAttribute('data-imgsrc')) {
     //             imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-imgsrc'));
     //             imgDefer[i].removeAttribute('data-imgsrc');
     //         }
     //     }
     // });
     const lazy = () => {
         document.addEventListener('lazyloaded', (e) => {
             e.target.parentNode.classList.add('image-loaded');
             e.target.parentNode.classList.remove('loading');
         });
     }
     lazy();
     jQuery(".swipe-arrow").addClass("swipe-arrow-visible");
     // $('.kss_shipping').appendTo('#cd-cart');
     // $('.kss_payment').appendTo('#cd-cart');
     $('#modal_pincode').appendTo('#cd-cart');
 })
 //getting click event to show modal
 $('#delivery-pincode').click(function() {
     $('#modal_pincode').modal();
     //appending modal background inside the bigform-content
     $('.modal-backdrop').appendTo('#cd-cart');
     //removing body classes to able click events
     $('body').removeClass();
     $('body').addClass('hide-scroll');
 });
 $(document).ready(function() {
     // Show or hide the sticky footer button
     $("a.scrollLink").click(function(event) {
         event.preventDefault();
         $("html, body").animate({
             scrollTop: $($(this).attr("href")).offset().top
         }, 500);
     });
     $(window).scroll(function() {
         if ($(this).scrollTop() > 300) {
             $('.go-top').fadeIn(200);
         } else {
             $('.go-top').fadeOut(200);
         }
     });
     // Animate the scroll to top
     $('.go-top').click(function(event) {
         event.preventDefault();
         $('html, body').animate({
             scrollTop: 0
         }, 300);
     })
     // Input to accept numbers only
     function validateNumber(event) {
         var key = window.event ? event.keyCode : event.which;
         if (event.keyCode === 8 || event.keyCode === 46) {
             return true;
         } else if (key < 48 || key > 57) {
             return false;
         } else {
             return true;
         }
     };
     $(document).on('keypress', function(e) {
         $('.validate-number').keypress(validateNumber);
     });
 });
 $('.close').click(function() {
     $("body").removeClass("hide-scroll");
     $('#checkout-flow').modal('hide');
     $('.modal-backdrop').remove();
     $("#cd-cart").css("overflow", "visible");
 })
 $('.kss_payment .back-to-cart').click(function() {
     $(".kss_payment").removeClass("slide-show");
     $(".kss_payment .fixed-bottom").removeClass('d-block'), 100;
     $(".kss_payment .fixed-bottom").addClass('d-none'), 100;
 })
 $('.kss_shipping .back-to-cart').click(function() {
     $(".kss_shipping").removeClass("slide-show");
     $("#cd-cart").removeAttr("style");
     $(".kss_shipping .fixed-bottom").removeClass('d-block'), 100;
     $(".kss_shipping .fixed-bottom").addClass('d-none'), 100;
 })
 $('.kss_shipping_summary .back-to-cart').click(function() {
     $(".kss_shipping_summary").removeClass("slide-show");
     $(" .kss_shipping_summary .fixed-bottom").removeClass('d-block'), 100;
     $(".kss_shipping_summary .fixed-bottom").addClass('d-none'), 100;
     $(" .kss_shipping .fixed-bottom").removeClass('d-none'), 100;
     $(".kss_shipping .fixed-bottom").addClass('d-block'), 100;
 })
 $('.shipping-details-save').click(function() {
     $('.shipping-content').hide();
     $('.shipping-content-info').show();
     $('.shipping-state-1').hide();
     $('.shipping-state-2').show();
     // $(".kss_shipping .fixed-bottom").removeClass('d-block'), 100;
     // $(".kss_shipping .fixed-bottom").addClass('d-none'), 100;
     // $('.kss_shipping').removeClass('slide_to_show'), 100;
     // $('body').removeClass();
     // $('body').addClass('hide-scroll');
     // $(".kss_shipping").addClass("d-none");
     // $(".kss_shipping").removeClass("d-block");
 });
 $('#add-address').click(function() {
     $('.shipping-content').show();
     $('.shipping-content-info').hide();
     $('.shipping-state-1').show();
     $('.shipping-state-2').hide();
 });
 $('#kss_coupon').click(function() {
     $('#cd-coupon').addClass('slide-show');
 });
 $('.cd-coupon-apply').click(function() {
     $('#cd-coupon').removeClass('slide-show');
 });
 $('#customRadio1, #customRadio2 ').click(function() {
     $(".kss_payment .fixed-bottom").removeClass('d-block'), 100;
     $(".kss_payment .fixed-bottom").addClass('d-none'), 100;
     $('#checkout-flow2').modal();
     $('.kss_payment').removeClass('slide_to_show'), 100;
     $('#checkout-flow2').appendTo('#cd-cart');
     $('.modal-backdrop').appendTo('#cd-cart');
     $('body').removeClass();
     $('body').addClass('hide-scroll');
     $(".kss_payment").addClass("d-none");
     $(".kss_payment").removeClass("d-block");
 });
 $('#shipping-details').click(function() {
     $('#signin').modal('hide');
     $("body").removeClass("hide-scroll");
     $(".kss_shipping").addClass("slide-show");
     $(".kss_shipping  .fixed-bottom").removeClass('d-none'), 100;
     $(".kss_shipping  .fixed-bottom").addClass('d-block'), 100;
     $('body').removeClass();
     $('body').addClass('hide-scroll');
     // $("#cd-cart").removeAttr("style");
 })
 $('#shipping-summary').click(function() {
     $("body").removeClass("hide-scroll");
     $('#checkout-flow').modal('hide');
     $('.modal-backdrop').remove();
     // $(".kss_shipping").removeClass("slide-show");
     $(".kss_shipping_summary").addClass("slide-show");
     $(".kss_shipping  .fixed-bottom").addClass('d-none'), 100;
     $(".kss_shipping  .fixed-bottom").removeClass('d-block'), 100;
     $(".kss_shipping_summary  .fixed-bottom").removeClass('d-none'), 100;
     $(".kss_shipping_summary  .fixed-bottom").addClass('d-block'), 100;
     $('body').removeClass();
     $('body').addClass('hide-scroll');
 })
 $('#payment-details').click(function() {
     $("body").removeClass("hide-scroll");
     $('#checkout-flow').modal('hide');
     $('.modal-backdrop').remove();
     $(".kss_payment").addClass("slide-show");
     $('body').removeClass();
     $('body').addClass('hide-scroll');
 })
 $(document).ready(function() {
     // Function which checks window size and hide/shows logo/menu
     function search_menu_hide(state) {
         if (window.matchMedia("(min-width: 992px) and (max-width: 1024px)").matches) {
             if (state == 'hide') {
                 $('.navbar-nav').hide();
             } else {
                 $('.navbar-nav').show();
             }
         } else if (window.matchMedia("(min-width: 768px) and (max-width: 991px)").matches) {
             if (state == 'hide') {
                 $('.kss-logo').hide();
             } else {
                 $('.kss-logo').show();
             }
         } else {
             return;
         }
     }
     $('.search-icon').click(function() {
         $('.search-input').show();
         $('.search-icon').hide();
         $('.recent-search').removeClass("d-none");
         $('.overlay-fix').removeClass("d-none");
         $('.recent-search').addClass("d-block");
         $('.overlay-fix').addClass("d-block");
         $('body').addClass('hide-scroll');
         search_menu_hide('hide');
     });
     $('.hide-search').click(function() {
         $('.search-input').hide();
         $('.search-icon').show();
         $('.recent-search').removeClass("d-block");
         $('.overlay-fix').removeClass("d-block");
         $('.recent-search').addClass("d-none");
         $('.overlay-fix').addClass("d-none");
         $('body').removeClass('hide-scroll');
         search_menu_hide('show');
     });
     $('.recent-link').click(function() {
         $('.search-input').hide();
         $('.search-icon').show();
         $('.recent-search').removeClass("d-block");
         $('.overlay-fix').removeClass("d-block");
         $('.recent-search').addClass("d-none");
         $('.overlay-fix').addClass("d-none");
         $('body').removeClass('hide-scroll');
     });
     $('.login-btn').click(function() {
         $('.sign-div').addClass("d-none");
         $('.verify-div').removeClass("d-none");
         $('.verify-div').addClass("d-block");
     });
     $('#loginModal .close').click(function() {
         $('.verify-div').addClass("d-none");
         $('.verify-div').removeClass("d-block");
         $('.sign-div').removeClass("d-none");
     });
     $('.overlay-fix').click(function() {
         $('.search-input').hide();
         $('.search-icon').show();
         $('.recent-search').removeClass("d-block");
         $('.overlay-fix').removeClass("d-block");
         $('.recent-search').addClass("d-none");
         $('.overlay-fix').addClass("d-none");
         $('body').removeClass('hide-scroll');
         search_menu_hide('show');
     });
     $('#search').on('focusin focusout', function() {
         $('.recent-search').removeClass("d-block");
         $('.recent-search').addClass("d-none");
     });
 });
 $('.btn-pay').click(function() {
     $("body").removeClass("hide-scroll");
     $('#checkout-flow2').modal('hide');
     $('.modal-backdrop').remove();
     $("#cd-cart").removeClass("speed-in");
     $("#cd-shadow-layer").removeClass("is-visible");
     $(".kss_shipping .fixed-bottom, .kss_shipping_summary .fixed-bottom").removeClass('d-block'), 100;
     $(".kss_shipping .fixed-bottom, .kss_shipping_summary .fixed-bottom").addClass('d-none'), 100;
     $(".kss_shipping, .kss_shipping_summary, .kss_payment").removeClass("slide-show");
     $("#cd-cart").removeAttr("style");
     $("#kss_cart").removeClass("fixed-bottom");
 })
 $(function() {
     var x = 0;
     $('.form-control').focusout(function() {
         var inputValue = $(this).val();
         if (inputValue == "") {
             $(this).removeClass("has-value");
         } else {
             $(this).addClass("has-value");
         }
     });
 });
 var products = ['Cotton Rich Jeans', 'Boy Clothings', 'Boy party wear', 'Jeans', 'Casual Shirts', 'Ethnic wear', 'Pajamas', 'Jackets', 'Beach Wear', 'School Collection', 'Diwali Collection', 'Kurta', 'Dhoti Seta', 'Infants', 'Embroidered Kurta', 'Sherwani', 'Character Tshirt', 'Romper', 'Early Walker', 'Musical Walkers', 'Jute Boots', 'Shocks', 'Hair Accessories', 'Handbags', 'Jewellery', 'Sleeveless Tshirt', 'Slips', 'Innerwear', 'Woolen Cap', 'Baby hug', 'Towel', 'Infants Clothing', 'Barbie Tshirt', 'Frozen Tshirt', 'Round Tshirt', 'Swimwear', 'Girls Clothing', 'Outwear', 'Jumpsuit', 'Frocks', 'Princess Wear', 'Skirts', 'Lehenga', 'Dupatta', 'Chaniya Choli', 'Footwear', 'Gown Duppata', 'Patiala Salwar', 'Looks', 'Dresses'];
 $('#search').autocomplete({
     source: [products]
 });
 // $('a[href^="#"]').on('click', function(event) {
 //     var target = $(this.getAttribute('href'));
 //     if( target.length ) {
 //         event.preventDefault();
 //         $('html, body').stop().animate({
 //             scrollTop: target.offset().top
 //         }, 1000);
 //     }
 // });
 function replaceURLParameter(paramName, paramValue) {
     var url = window.location.href;
     var hash = location.hash;
     url = url.replace(hash, '');
     if (url.indexOf(paramName + "=") >= 0) {
         var prefix = url.substring(0, url.indexOf(paramName));
         var suffix = url.substring(url.indexOf(paramName));
         suffix = suffix.substring(suffix.indexOf("=") + 1);
         suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
         url = prefix + paramName + "=" + paramValue + suffix;
     } else {
         if (url.indexOf("?") < 0) url += "?" + paramName + "=" + paramValue;
         else url += "&" + paramName + "=" + paramValue;
     }
     var url = url.substring(url.indexOf(window.location.pathname));
     window.history.replaceState({}, 'Kidsuperstore.in', url + hash);
 }
 $('.home-slider').slick({
     autoplay: true
 });
 if ($('#storeSlider').length) {
     $('#storeSlider').lightSlider({
         loop: true,
         item: 1,
         thumbItem: 4,
         slideMargin: 0,
         gallery: true,
         galleryMargin: 20,
         thumbMargin: 20,
         currentPagerPosition: 'left',
         onSliderLoad: function() {
             $('#storeSlider').removeClass('cs-hidden');
         }
     });
 }

// Mega menu
$(document).on('click', '.megamenu--left .nav-item', function(){
  var menuTab = $(this);
  menuTab.addClass('active').siblings().removeClass('active');
  var mobMenuName = menuTab.data('target');
  $('.megamenu-wrapper').addClass('d-none');
  $('.megamenu-wrapper[data-menu="'+mobMenuName+'"]').removeClass('d-none');
});
$(document).on('click', '.megamenu-open', function(){
	$('.megamenu').addClass('active');
	$('.megamenu--left .nav-item:first-child').addClass('active');
	$('.megamenu--right li .megamenu-wrapper').addClass('d-none');
	$('.megamenu--right li:first-child .megamenu-wrapper').removeClass('d-none');
	$('body').addClass('overflow-h');
});

if( $('#storeSlider').length ) {
    $('#storeSlider').lightSlider({
        loop:true,
        item:1,
        thumbItem:4,
        slideMargin:0,
        gallery:true,
        galleryMargin: 20,
        thumbMargin: 20,
        currentPagerPosition:'left',
        onSliderLoad: function() {
            $('#storeSlider').removeClass('cs-hidden');
        }
    });
}

// Footer mobile more section

$(document).on('click',".footer-more",function(){
    $('.footer-more__title').text(function(i, v){
       return v === 'Fresh Fashion for your kids' ? 'Less' : 'Fresh Fashion for your kids'
    })
});

$(document).on('click', '.megamenu-close', function(){
	$('.megamenu').removeClass('active');
	$('.megamenu--left .nav-item').removeClass('active');
	$('.megamenu-wrapper').addClass('d-none');
	$('body').removeClass('overflow-h');
});