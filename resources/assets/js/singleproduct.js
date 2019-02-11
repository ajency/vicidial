
/*jQuery(document).ready(function() {
    jQuery('.breadcrumb-item').last().addClass('active');
});*/

$(function(){
    // Block scope
    const isMobile = isMobileScreen();

    // To check for mobile width
    function isMobileScreen(){
      if ($(window).width() < 767)
        return true
      else
        return false
    }

    var customHtml = '<div class="kss-btn__wrapper d-flex align-items-center justify-content-center"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</div><div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Bag</div><div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>';

    var sizemsg = '<div class="kss-btn__wrapper d-flex align-items-center justify-content-center d-md-none">SELECT SIZE</div>'

    var buttn = $('.add-bag-btn .cd-add-to-cart');

    function injectHtml(){
        buttn.html(customHtml);
    }

    // If radio already checked
    if(isMobile){
        if($('input[type=radio][name=kss-sizes]:checked').length > 0){
            injectHtml();
        }
    }

    if($('#size-modal')){
        $('#size-modal').on('hide.bs.modal', function (e) {
            $('.kss_sizes .radio-input').prop('checked', false);
            // buttn.html(sizemsg); 
            $('.size-modal .modal-title').removeClass('text-danger');
        })    
        $('#size-modal').on('shown.bs.modal', function (e) {
            if(isMobile){
                $('.size-modal .cd-add-to-cart').on('click',function(){
                    if($('input[type=radio][name=kss-sizes-display]:checked').length == 0){
                        $(".size-modal .kss_sizes").addClass("shake");
                        $('.size-modal .modal-title').addClass('text-danger');
                        setTimeout(function(){$(".size-modal .kss_sizes").removeClass( "shake" );},200);
                    }
                });
            } 
        })
    }



    $('input[type=radio][name=kss-sizes]').change(function() {
        var getID = $(this).attr('id');
        if($('input[type=radio][name=kss-sizes-display]#' + getID)){
        $('input[type=radio][name=kss-sizes-display]#' + getID).prop('checked', true);
        }        
        //var selected_size_id = this.id;
        //var selected_var_id = window.variants['selected_item'];

        //console.log(_.find(window.variants['items'][selected_var_id]['items'], function (o) { return o.size.id = selected_size_id; }));
        $('.size-select-error').addClass('d-none');

        if(this.dataset['list_price'] == this.dataset['sale_price']) {
            jQuery('#kss-price').html('₹'+this.dataset['sale_price']);
        } else {
            jQuery('#kss-price').html('₹'+this.dataset['sale_price']+' <small class="kss-original-price text-muted">₹'+this.dataset['list_price']+'</small> <span class="kss-discount text-danger">'+this.dataset['discount_per']+'% OFF</span>');
        }

        replaceURLParameter('size', this.dataset['title']);
        // jQuery('#cd-add-to-cart').prop("disabled", false);
        // if(isMobile){
        //     injectHtml();
        // }

    });   
    
    // Getting sale price and setting to mobile size modal
    $('.size-modal .radio-wrap .radio-label').each(function(index,element){
        var forID = $(element).attr('for');
        var input = $('input[type=radio][name=kss-sizes-display]#' + forID);
        var price = input.data('sale_price');
        $(element).append('<span class="sale-price">₹'+ price +'</span>');
    })
    
    // $('.kss_sizes.wo-image .radio-label').tooltip('disable');


    if ($(window).width() < 767) {
        // Detaching color option in mobile
        var coloroption = $('.colorOptions').detach();
        $('.product-collapse').after(coloroption);
        $('.colorOptions').removeClass('d-none');

        // Disable tooltip in mobile
        $('.variant-wrapper,.product-color--single').tooltip('disable');

        // $('.kss_sizes.wo-image .radio-label').tooltip('enable');
        $('.colorOptions__trigger').click();

    }

    // FB pixel tracking for view content event
    fbq('track', 'ViewContent', {
        value: default_price,
        currency: 'INR',
        content_ids: parent_id+'-'+selected_color_id,
        content_type: 'product_group',
        product_catalog_id : product_catalog_id
    });

    // Google analytic pixel tracking

    gtag('event', 'page_view', {
        'send_to': google_pixel_id,
        'ecomm_pagetype': 'list',
        'ecomm_prodid': parent_id+'-'+selected_color_id,
        'ecomm_totalvalue': default_price,
        'user_id': getCookie('user_id')
      });

})

