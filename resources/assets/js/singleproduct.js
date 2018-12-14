
/*jQuery(document).ready(function() {
    jQuery('.breadcrumb-item').last().addClass('active');
});*/

$(function(){

    var customHtml = '<div class="kss-btn__wrapper d-flex align-items-center justify-content-center"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</div><div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Bag</div><div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>';

    var buttn = $('.add-bag-btn .cd-add-to-cart');

    // If radio already checked
    if($('input[type=radio][name=kss-sizes]:checked').length > 0){
        jQuery('#cd-add-to-cart').prop("disabled", false);
        buttn.html(customHtml);
    }

    $('input[type=radio][name=kss-sizes]').change(function() {
        //var selected_size_id = this.id;
        //var selected_var_id = window.variants['selected_item'];

        //console.log(_.find(window.variants['items'][selected_var_id]['items'], function (o) { return o.size.id = selected_size_id; }));

        if(this.dataset['list_price'] == this.dataset['sale_price']) {
            jQuery('#kss-price').html('₹'+this.dataset['sale_price']);
        } else {
            jQuery('#kss-price').html('₹'+this.dataset['sale_price']+' <small class="kss-original-price text-muted">₹'+this.dataset['list_price']+'</small> <span class="kss-discount text-danger">'+this.dataset['discount_per']+'% OFF</span>');
        }

        replaceURLParameter('size', this.dataset['title']);
        jQuery('#cd-add-to-cart').prop("disabled", false);
        buttn.html(customHtml);

    });   
    
    
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
    });

})

