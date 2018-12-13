var add_to_cart_failed = false;
var add_to_cart_failure_message = '';
var add_to_cart_clicked = false;
var add_to_cart_completed = false;

$(document).ready(function(){
    //Set crt count on page load
    updateCartCountInUI();
    // console.log("window.location.href ==>",window.location.href)
    if(window.location.href.endsWith('#bag') || window.location.href.endsWith('#bag/user-verification') || window.location.href.endsWith('#shipping-address') || window.location.href.endsWith('#shipping-summary'))
        openCart();

    window.onhashchange = function() { 
     // console.log("hash changed");
     if(!$('#cd-cart').hasClass("speed-in") && (window.location.href.endsWith('#bag') || window.location.href.endsWith('#bag/user-verification') || window.location.href.endsWith('#shipping-address') || window.location.href.endsWith('#shipping-summary')) ){
        // console.log("opening cart from vanilla js");
        openCart();
     }
     openAccountAppOnUrlChange();
    }

    openAccountAppOnUrlChange();
    

    function openAccountAppOnUrlChange(){
        if(!$('#cd-my-account').hasClass("speed-in") && (window.location.href.endsWith('#/account/my-orders') || window.location.href.endsWith('#/account') || window.location.href.endsWith('#/account/user-verification') ))
            openMyAccountPage();
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
    
    //on click add to cart
    $('.cd-add-to-cart').on('click',function(){
        var add_to_cart_element = this;
        //$(add_to_cart_element).removeClass('cd-add-to-cart');
        if($(add_to_cart_element).hasClass('cartLoader')) return;

        //if($(add_to_cart_element).hasClass('go-to-cart')) {/*Call Angular function*/ return;}

        //Show loader
        $('.cd-add-to-cart .kss-btn__wrapper').addClass('d-none');
        $('.cd-add-to-cart .kss-btn__wrapper').removeClass('d-flex');
        $('.cd-add-to-cart .btn-icon').show();
        $(add_to_cart_element).addClass('cartLoader');
        
        // for angular app 
        add_to_cart_clicked = true;
        openCart();

        if($('input[type=radio][name=kss-sizes]:checked').length == 0){
            //Size not selected error css
            jQuery( ".kss_sizes" ).addClass( "shake" );
            setTimeout(function(){jQuery( ".kss_sizes" ).removeClass( "shake" );},200);
        }
        else{
            addToCart();
        }
    });

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

    jQuery("#cd-cart-trigger").click(function() {
      openCart();             
    });
    
    jQuery("#cd-my-account-trigger").click(function() {
      openMyAccountPage();             
    });

    function addToCart(){
        var var_id = $('input[type=radio][name=kss-sizes]:checked')[0].dataset['variant_id'];
        fbTrackAddToCart(var_id);
        var url = isLoggedInUser() ? ("/api/rest/v1/user/cart/"+getCookie('cart_id')+"/insert") : ("/rest/v1/anonymous/cart/insert")
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var data = {_token: CSRF_TOKEN,"variant_id": var_id,"variant_quantity": 1};
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                        'Authorization': isLoggedInUser() ? 'Bearer '+getCookie('token') : ''
                    },
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('.cd-add-to-cart .btn-icon').hide();
                //$('.cd-add-to-cart .btn-label-success').show();
                $('.cd-add-to-cart .kss-btn__wrapper').addClass('d-flex');
                $('.cd-add-to-cart .kss-btn__wrapper').removeClass('d-none');
                //var itemImg = $(add_to_cart_element).closest('.container').find('img').eq(1);
                //flyToElement($(itemImg), $('.shopping-cart'));
                document.cookie = "cart_count=" + data.cart_count + ";path=/";
                add_to_cart_completed = true;
                // set_cart_data(data.item);
                updateCartCountInUI();
                // $('.kss-alert .message').html('<strong>Success!!!</strong> Added to bag');
                // $('.kss-alert').addClass('kss-alert--success');
                // $('.kss-alert').addClass('is-open');
                $('.cd-add-to-cart').removeClass('cartLoader');
                //$(add_to_cart_element).addClass('go-to-cart');
                setTimeoutVariable();
                        
            },
            error: function (request, status, error) {
                // console.log("Check ==>",request);
                if(request.status == 401)
                    userLogout(request);
                else if(request.status == 0)
                    showErrorPopup(request);
                else if(!isLoggedInUser() && request.status == 403){
                    addToCart();
                }
                else{
                    if(isLoggedInUser() && request.status == 400 || request.status == 403)
                        getNewCartId(request);
                    else
                        showErrorPopup(request);
                }
            }
        });
    }

    function showErrorPopup(request){
        var error_msg = (request && request.responseJSON && request.responseJSON.message!='') ? request.responseJSON.message : 'Could not add to bag';
        //if(request.responseJSON.message!='') error_msg = request.responseJSON.message
        add_to_cart_failed = true;
        add_to_cart_completed = true;
        // console.log("error_msg",error_msg);
        add_to_cart_failure_message = error_msg=='Quantity not available' ? 'Could not add '+ $('.section-heading--single').text() +' to bag as it is out of stock' : (error_msg == "invalid cart" ? 'Hey, before you add your item to bag it looks like you were interrupted during your last checkout. You can place this existing order or edit bag to add more items.' : 'Due to the high traffic, there was an issue adding your item to bag. Please try adding the item again' );

        $('.cd-add-to-cart .btn-icon').hide();
        $('.cd-add-to-cart .kss-btn__wrapper').addClass('d-flex');
        $('.cd-add-to-cart .kss-btn__wrapper').removeClass('d-none');
        // $('.kss-alert .message').html('<strong>Failed!!!</strong> '+error_msg);
        // $('.kss-alert').addClass('kss-alert--failure');
        // $('.kss-alert').addClass('is-open');
        // $('#cd-cart').css('pointer-events','none');
        $('.cd-add-to-cart').removeClass('cartLoader');
        setTimeoutVariable();
    }
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
                // if(data.cart_id == getCookie('cart_id'))
                //     showErrorPopup(request)
                // else{
                //     document.cookie = "cart_id=" + data.cart_id + ";path=/";
                //     addToCart();
                // }
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


//Add to cart Listing Page
$('.select-size button').click(function() {
    //Add to cart
});


function openCart(){
    loadAngularApp();
    $('#main-nav').removeClass('speed-in');
    $('#cd-cart').addClass("speed-in");
    $('#cd-shadow-layer').addClass('is-visible');
    $("body").addClass("hide-scroll");
}

function openMyAccountPage(){
    loadMyAccountApp();
    $('#main-nav').removeClass('speed-in');
    $('#cd-my-account').addClass("speed-in");
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
    if(!loaded){
        $.getScript("/views/cart/inline.bundle.js")
            .done(function(script, textStatus){
                // console.log(textStatus);
                $.getScript("/views/cart/vendor.bundle.js")
                    .done(function(script2, textStatus2){
                        // console.log(textStatus2);
                        $.getScript("/views/cart/polyfills.bundle.js")
                            .done(function(script3, textStatus3){
                                // console.log(textStatus3);
                                $.getScript("/views/cart/main.bundle.js")
                                    .done(function(script4,textStatus4){
                                        // console.log(textStatus4);
                                        loaded = true;
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

function fbTrackAddToCart(var_id){    
    var variant = variants[selected_color_id].variants.find((variant)=> {return variant.id == var_id});
    fbq('track', 'AddToCart', {
        value: variant.sale_price,
        currency: 'INR',
        content_ids: parent_id+'-'+selected_color_id,
        content_type: 'product',
    });
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

function loadMyAccountApp(){
    $.getScript("/views/my-account/inline.bundle.js")
        .done(function(script, textStatus){
            // console.log(textStatus);
            $.getScript("/views/my-account/vendor.bundle.js")
                .done(function(script2, textStatus2){
                    // console.log(textStatus2);
                    $.getScript("/views/my-account/polyfills.bundle.js")
                        .done(function(script3, textStatus3){
                            // console.log(textStatus3);
                            $.getScript("/views/my-account/main.bundle.js")
                                .done(function(script4,textStatus4){
                                    // console.log(textStatus4);
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
