$(document).ready(function(){
    //Set crt count on page load
    set_cart_count();
    
    //on click add to cart
    $('.cd-add-to-cart').on('click',function(){
        var add_to_cart_element = this;
        if($('input[type=radio][name=kss-sizes]:checked').length == 0){
            //Size not selected error css
            jQuery( ".kss_sizes" ).addClass( "shake" );
            setTimeout(function(){jQuery( ".kss_sizes" ).removeClass( "shake" );},200);
        }
        else{
            var data = {"variant_id": $('input[type=radio][name=kss-sizes]:checked')[0].dataset['variant_id'],"variant_quantity": 1};
            $.ajax({
                url: '/rest/anonymous/cart/insert',
                type: 'GET',
                data: data,
                success: function (data) {
                    var itemImg = $(add_to_cart_element).closest('.container').find('img').eq(1);
                    flyToElement($(itemImg), $('.shopping-cart'));
                    sessionStorage.setItem( "cart_count", data.cart_count );
                    set_cart_count();
                            
                },
                error: function (request, status, error) {
                    console.log(request);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    });
});


function set_cart_count() {
    //Check if cart count in Session storage
    var cart_count = sessionStorage.getItem( "cart_count" );
    if(cart_count)
    {
        //Scroll to top if cart icon is hidden on top
        $(".cart-counter").removeClass('d-none'), 100;
        $(".cart-counter").addClass('d-block'), 100;
        $('#output').html(function(i, val) { return cart_count });
    }
}