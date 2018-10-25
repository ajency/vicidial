$(document).ready(function(){
    //Set crt count on page load
    updateCartCountInUI();

    var kss_alert_timeout;

    function setTimeoutVariable() {
        kss_alert_timeout = setTimeout(function()
        {
            $('.kss-alert').removeClass('is-open');
            $('.kss-alert').removeClass('kss-alert--success');
            $('.kss-alert').removeClass('kss-alert--failure');
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
        $('.cd-add-to-cart .btn-label-initial').addClass('d-none');
        $('.cd-add-to-cart .btn-label-initial').removeClass('d-flex');
        $('.cd-add-to-cart .btn-icon').show();
        $(add_to_cart_element).addClass('cartLoader');
        
        // for angular app 
        sessionStorage.setItem( "add_to_cart_clicked", "true");
        openCart();

        if($('input[type=radio][name=kss-sizes]:checked').length == 0){
            //Size not selected error css
            jQuery( ".kss_sizes" ).addClass( "shake" );
            setTimeout(function(){jQuery( ".kss_sizes" ).removeClass( "shake" );},200);
        }
        else{
            var url = isLoggedInUser() ? ("/api/rest/v1/user/cart/"+getCookie('cart_id')+"/insert") : ("/rest/anonymous/cart/insert")
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var data = {_token: CSRF_TOKEN,"variant_id": $('input[type=radio][name=kss-sizes]:checked')[0].dataset['variant_id'],"variant_quantity": 1};
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
                    $('.cd-add-to-cart .btn-label-initial').addClass('d-flex');
                    $('.cd-add-to-cart .btn-label-initial').removeClass('d-none');
                    //var itemImg = $(add_to_cart_element).closest('.container').find('img').eq(1);
                    //flyToElement($(itemImg), $('.shopping-cart'));
                    document.cookie = "cart_count=" + data.cart_count;
                    sessionStorage.setItem( "addded_to_cart", "true");
                    // set_cart_data(data.item);
                    updateCartCountInUI();
                    $('.kss-alert .message').html('<strong>Success!!!</strong> Added to bag');
                    $('.kss-alert').addClass('kss-alert--success');
                    $('.kss-alert').addClass('is-open');
                    $(add_to_cart_element).removeClass('cartLoader');
                    //$(add_to_cart_element).addClass('go-to-cart');
                    setTimeoutVariable();
                            
                },
                error: function (request, status, error) {
                    $('.cd-add-to-cart .btn-icon').hide();
                    $('.cd-add-to-cart .btn-label-initial').addClass('d-flex');
                    $('.cd-add-to-cart .btn-label-initial').removeClass('d-none');
                    $('.kss-alert .message').html('<strong>Failed!!!</strong> Could not add to bag');
                    $('.kss-alert').addClass('kss-alert--failure');
                    $('.kss-alert').addClass('is-open');
                    $(add_to_cart_element).removeClass('cartLoader');
                    setTimeoutVariable();
                    sessionStorage.setItem( "addded_to_cart", "false");
                }
            });
        }
    });

    $('.kss-alert .close').on('click',function(){
        $('.kss-alert').removeClass('is-open');
        if(kss_alert_timeout){
            clearTimeout(kss_alert_timeout);
        }
    });

    // Tooltip init
    $('[data-toggle="tooltip"]').tooltip();

    jQuery("#cd-cart-trigger").click(function() {
      openCart();             
    });
});


//Add to cart Listing Page
$('.select-size button').click(function() {
    //Add to cart
});


function openCart(){
  loadAngularApp();
  event.preventDefault();
  $('#main-nav').removeClass('speed-in');
  toggle_panel_visibility($('#cd-cart'), $('#cd-shadow-layer'), $('body'));
  $("body").addClass("hide-scroll");
}

function updateCartCountInUI() {
    //Check if cart count in Session storage
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


function set_cart_data(json) {
    //Check if cart json in Session storage
    var cart_data = sessionStorage.getItem( "cart_data" );
    var found = 0;
    if(cart_data) {
        cart_data = JSON.parse(cart_data);
        // cart_data.forEach(function(item) {
        //   if(item.id == json.id) {
        //     found = 1;
        //     break;
        //   };
        // });
    }
    else {
        var cart_data = new Array();
    }

    if(found == 0) {
        cart_data.push(json);
        sessionStorage.setItem( "cart_data", JSON.stringify(cart_data) );
    }
}

  loaded = false;

function loadAngularApp(){
    if(!loaded){
      $.when(
          $.getScript("/views/cart/inline.bundle.js"),
          $.getScript("/views/cart/polyfills.bundle.js"), 
          $.getScript("/views/cart/styles.bundle.css"),  
          $.getScript("/views/cart/vendor.bundle.js"), 
          $.Deferred(function( deferred ){
              $( deferred.resolve );
          })
      ).done(function(){
          $.getScript("/views/cart/main.bundle.js");
          loaded = true;
      });
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
