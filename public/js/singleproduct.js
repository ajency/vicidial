
/*jQuery(document).ready(function() {
    jQuery('.breadcrumb-item').last().addClass('active');
});*/

$(function(){
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

    });   
    
    // Detaching color option in mobile
    if ($(window).width() < 767) {
        var coloroption = $('.colorOptions').detach();
        $('.kss_sizes').after(coloroption);
        $('.colorOptions').removeClass('d-none');
    }

})

