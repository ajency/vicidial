$('.modal #cart_close').click(function() {
    $("#cd-cart").removeAttr("style");
});
$(' .prod-slides').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 2.05,
    centerPadding: '0',
    adaptiveHeight: false,
    infinite: false,
    responsive: [{
        breakpoint: 768,
        settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 1,
        }
    }, {
        breakpoint: 480,
        settings: {
            arrows: false,
            centerMode: false,
            centerPadding: '10px',
            slidesToShow: 1.25,
            mobileFirst: true,
        }
    }]
});
const lazy = () => {
    document.addEventListener('lazyloaded', (e) => {
        e.target.parentNode.classList.add('image-loaded');
        e.target.parentNode.classList.remove('loading');
    });
}
lazy();
$(document).ready(function() {
    $(function() {
        $(".loader").fadeOut(2000, function() {
            $(".prod-slides li img").fadeIn(1000);
        });
    });
    $('#aniimated-thumbnials').lightGallery({
        selector: '.custom-selector',
        preload: 0
    });
    // ------------------ Filter For Mobile ------------------//
    jQuery("#filter").click(function() {
        jQuery(".kss_filter").addClass("kss_filter_mobile");
    });
     jQuery(".cd-add-to-cart").click(function() {
      jQuery( ".kss_sizes" ).toggleClass( "shake" );
    });
    
    jQuery(".clear-filter").click(function() {
        jQuery(".filter-selection").attr("style", "display: none !important");
    });
    jQuery("#kss_hide-filter").click(function() {
        jQuery(".kss_filter").removeClass("kss_filter_mobile");
    });
    // ------------------ Disable Arrow on single product ------------------//
    jQuery(".prod-slides img").click(function() {
        jQuery(".swipe-arrow").removeClass("swipe-arrow-visible");
    });
    // ------------------ Mobile View ------------------//
       jQuery("#cd-cart-trigger").click(function() {
            jQuery("#kss_cart").addClass("fixed-bottom");
        });
        jQuery("#cart_close").click(function() {
            jQuery("#kss_cart").removeClass("fixed-bottom");
        });
    if ($(window).width() < 760) {
        $('.similar-link').appendTo('.m-similar');
        $(window).scroll(function() {
            if ($(this).scrollTop() > 200) {
                $('.mobile-fixed').show();
                jQuery(".mobile-fixed").addClass("visible");
            } else {
                $('.mobile-fixed').hide();
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
    // ------------------ Every time the window is scrolled ------------------//
    // ------------------ Shortlist Icon ------------------//
    $('.kss_heart').on('click', function() {
        $(this).toggleClass('animated-heart');
    });
    // ------------------ Shortlist Icon ------------------//
    $(".navbar-collapse").mmenu({
        wrappers: ["bootstrap4"],
        "extensions": ["fx-menu-zoom", "fx-panels-zoom", "pagedim-black", "theme-dark"]
    }, {
        clone: true
    });
    api = $('#mm-0').data('mmenu');
    api.bind('open:finish', function() {
        return $('.navbar-toggler').addClass('is-active');
    });
    api.bind('close:finish', function() {
        return $('.navbar-toggler').removeClass('is-active');
    });
    //if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
    var $L = 1200,
        $menu_navigation = $('#main-nav'),
        $cart_trigger = $('#cd-cart-trigger'),
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
    //open cart
    $cart_trigger.on('click', function(event) {
        event.preventDefault();
        //close lateral menu (if it's open)
        $menu_navigation.removeClass('speed-in');
        toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
        $("body").addClass("hide-scroll");
    });
    // //close lateral cart or lateral menu
    // $shadow_layer.on('click', function(){
    //   $shadow_layer.removeClass('is-visible');
    //   // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
    //   if( $lateral_cart.hasClass('speed-in') ) {
    //     $lateral_cart.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
    //       $('body').removeClass('overflow-hidden');
    //     });
    //     $menu_navigation.removeClass('speed-in');
    //   } else {
    //     $menu_navigation.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
    //       $('body').removeClass('overflow-hidden');
    //     });
    //     $lateral_cart.removeClass('speed-in');
    //   }
    //     $( "body" ).removeClass( "hide-scroll" );
    // });
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
    $('.kss_shipping').appendTo('#cd-cart');
    $('.kss_payment').appendTo('#cd-cart');
    $('#modal_pincode').appendTo('#cd-cart');
})
//getting click event to show modal
$('#checkout').click(function() {
    $('#signin').modal();
    $("#cd-cart").css("overflow", "hidden");
    //appending modal background inside the bigform-content
    $('.modal-backdrop').appendTo('#cd-cart');
    //removing body classes to able click events
    $('body').removeClass();
    $('body').addClass('hide-scroll');
});
//getting click event to show modal
$('#delivery-pincode').click(function() {
    $('#modal_pincode').modal();
    //appending modal background inside the bigform-content
    $('.modal-backdrop').appendTo('#cd-cart');
    //removing body classes to able click events
    $('body').removeClass();
    $('body').addClass('hide-scroll');
});
$('.btn-signin').click(function() {
    $('#signin').modal();
    $('body').addClass('hide-scroll');
    //appending modal background inside the bigform-content
    $('.modal-backdrop').appendTo('#cd-cart');
    //removing body classes to able click events
    $(".state-1").removeClass('d-block'), 100;
    $(".state-1").addClass('d-none'), 100;
    $(".state-2").removeClass('d-none'), 100;
    $(".state-2").addClass('d-block'), 100;
});
$('.btn-back').click(function() {
    $(".state-2").removeClass('d-block'), 100;
    $(".state-2").addClass('d-none'), 100;
    $(".state-1").removeClass('d-none'), 100;
    $(".state-1").addClass('d-block'), 100;
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
});

$('.close').click(function() {
    $("body").removeClass("hide-scroll");
    $('#checkout-flow').modal('hide');
    $('.modal-backdrop').remove();
    $("#cd-cart").css("overflow", "visible");
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
    $("#cd-cart").removeAttr("style");
})
$('#payment-details').click(function() {
    $("body").removeClass("hide-scroll");
    $('#checkout-flow').modal('hide');
    $('.modal-backdrop').remove();
    $(".kss_payment").addClass("slide-show");
    $('body').removeClass();
    $('body').addClass('hide-scroll');
})
$('.btn-pay').click(function() {
    $("body").removeClass("hide-scroll");
    $('#checkout-flow2').modal('hide');
    $('.modal-backdrop').remove();
    $("#cd-cart").removeClass("speed-in");
    $("#cd-shadow-layer").removeClass("is-visible");
    $(".kss_shipping .fixed-bottom").removeClass('d-block'), 100;
    $(".kss_shipping .fixed-bottom").addClass('d-none'), 100;
    $(".kss_shipping").removeClass("slide-show");
    $("#cd-cart").removeAttr("style");
    $(".kss_payment").removeClass("slide-show");
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