
const isMobile = isMobileScreen();

function isMobileScreen(){
  if ($(window).width() < 767)
    return true
  else
    return false
}

$(document).ready(function(){
    //Set crt count on page load
    updateCartCountInUI();
    if((window.location.href.includes('#/bag') || window.location.href.includes('#/account')) && (window.location.pathname == '/shop/boys' || window.location.pathname == '/shop/girls' || window.location.pathname == '/shop/infants' || window.location.pathname == '/draft/boys' || window.location.pathname == '/draft/girls' || window.location.pathname == '/draft/infants' || window.location.pathname.includes('/ideas') || window.location.pathname.includes('/my/order/details') || window.location.pathname.includes('/activities') ) )
        openCart();

    window.onhashchange = function() { 
     console.log("hash changed", window.location.pathname);
     if(!$('#cd-cart').hasClass("speed-in") && (window.location.href.includes('#/bag') || window.location.href.includes('#/account')) && (window.location.pathname == '/shop/boys' || window.location.pathname == '/shop/girls' || window.location.pathname == 'shop/infants' || window.location.pathname == 'draft/boys' || window.location.pathname == 'draft/girls' || window.location.pathname == '/draft/infants' || window.location.pathname.includes('/ideas') || window.location.pathname.includes('/my/order/details') || window.location.pathname.includes('/activities') ) ){
        openCart();
     }
    }    

    var kss_alert_timeout;

    function setTimeoutVariable() {
        kss_alert_timeout = setTimeout(function()
        {
            $('.kss-alert').removeClass('is-open');
            $('.kss-alert').removeClass('kss-alert--success');
            $('.kss-alert').removeClass('kss-alert--failure');
            $('#cd-cart').css('pointer-events','auto');
        }, 4500);

        kss_alert_timeout;
    }
    
    var XSsizemsg = '<div class="kss-btn__wrapper d-flex align-items-center justify-content-center d-md-none">SELECT SIZE</div>';


    $('.kss-alert .alert-close').on('click',function(){
        $('.kss-alert').removeClass('is-open');
        $('#cd-cart').css('pointer-events','auto');
        if(kss_alert_timeout){
            clearTimeout(kss_alert_timeout);
        }
    });

    // Tooltip init
    if ($('[data-toggle="tooltip"]').length) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    jQuery("#cd-my-account-trigger").click(function() {      
        let url = window.location.href.split("#")[0] + '#/account';
        window.location = url;
    });

    jQuery("#cd-cart-trigger").click(function() {      
        let url = window.location.href.split("#")[0] + '#/bag';
        window.location = url;
    });
    

    function userLogout(request){
        document.cookie = "cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        showErrorPopup(request);
    }

    function getNewCartId(request){
        var url = "/api/rest/v1/user/cart/mine";
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                        'Authorization': 'Bearer '+getCookie('token')
                    },
            data: {},
            dataType: 'JSON',
            success: function (data) {               
                document.cookie = "cart_id=" + data.cart_id + ";path=/";
                if(data.cart_type == 'cart')
                    addToCart(); 
                else
                    startFresh(request)                    
            },
            error: function (request, status, error) {
                showErrorPopup(request)
            }
        });
    }

    function startFresh(request){
        var url = '/api/rest/v1/user/cart/start-fresh';
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                        'Authorization': 'Bearer '+getCookie('token')
                    },
            data: {},
            dataType: 'JSON',
            success: function (data) {
                document.cookie = "cart_id=" + data.cart_id + ";path=/";
                addToCart();            
            },
            error: function (request, status, error) {
                showErrorPopup(request)
            }
        });
    }
});


function openCart(){
    console.log("openCart function");
    loadAngularApp();
    $('#main-nav').removeClass('speed-in');
    $('#cd-cart').addClass("speed-in");
    $('#cd-shadow-layer').addClass('is-visible');
    $("body").addClass("hide-scroll");
}

function updateCartCountInUI() {
    //Check cart count in cookie
    var cart_count = getCookie( "cart_count" );
    if(cart_count && cart_count != "0")
    {
        //Scroll to top if cart icon is hidden on top
        $(".cart-counter").removeClass('d-none'), 100;
        $(".cart-counter").addClass('d-block'), 100;
        $('#output').html(function(i, val) { return cart_count });
    }
    else{
        $(".cart-counter").addClass('d-none'), 100;
        $(".cart-counter").removeClass('d-block'), 100;
    }
}

loaded = false;

function loadAngularApp(){
    console.log("Check ==>", cdn_url, file_hashes)
    if(!loaded){
        $("<link/>", {
           rel: "stylesheet",
           type: "text/css",
           href: cdn_url+"js/kss-pwa/styles." + file_hashes.styles +".css"
        }).appendTo("head");

        $.getScript(cdn_url+"js/kss-pwa/runtime." + file_hashes.runtime +".js")        
            .done(function(script, textStatus){
                // console.log(textStatus);
                $.getScript(cdn_url+"js/kss-pwa/polyfills." + file_hashes.polyfills +".js")
                    .done(function(script2, textStatus2){
                        // console.log(textStatus2);
                        // $.getScript(cdn_url+"js/kss-pwa/scripts.js")
                            // .done(function(script3, textStatus3){
                                // console.log(textStatus3);
                                $.getScript(cdn_url+"js/kss-pwa/main." + file_hashes.main +".js")
                                    .done(function(script4,textStatus4){
                                        // console.log(textStatus4);
                                        loaded = true;
                                    })
                                    .fail(function(jqxhr, settings, exception){
                                        // console.log("angular load failed")
                                        // loadAngularApp();
                                    })
                            // })
                            // .fail(function(jqxhr, settings, exception){
                                // console.log("angular load failed")
                                // loadAngularApp();
                            // })
                    })
                    .fail(function(jqxhr, settings, exception){
                        // console.log("angular load failed")
                        // loadAngularApp();
                    })
            })
            .fail(function(jqxhr, settings, exception){
                // console.log("angular load failed")
                // loadAngularApp();
            })
    }
}

function isLoggedInUser(){
    if(getCookie('token') && getCookie('cart_id'))
        return true;
    return false;
}


function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function fbTrackuserRegistration(){
    // fbq('track', 'CompleteRegistration');
}

function fbTrackInitiateCheckout(order_total){    
    fbq('track', 'InitiateCheckout', {
        value: order_total,
        currency: 'INR',
    });
}

function fbTrackAddPaymentInfo(){
    fbq('track', 'AddPaymentInfo');
}

// Google pixel tracking
function google_pixel_tracking(pixel_id,price_final,pagetype){
      gtag('event', 'page_view', {
        'send_to': google_pixel_id,
        'ecomm_pagetype': pagetype,
        'ecomm_prodid': pixel_id,
        'ecomm_totalvalue': price_final,
        'user_id': getCookie('user_id')
      });
}
