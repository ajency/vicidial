
/*jQuery(document).ready(function() {
    jQuery('.breadcrumb-item').last().addClass('active');
});*/

$('input[type=radio][name=kss-sizes]').change(function() {
    //var selected_size_id = this.id;
    //var selected_var_id = window.variants['selected_item'];

    //console.log(_.find(window.variants['items'][selected_var_id]['items'], function (o) { return o.size.id = selected_size_id; }));
    console.log(this.dataset);

    jQuery('#kss-price').html('₹'+this.dataset['sale_price']+' <small class="kss-original-price text-muted">₹'+this.dataset['list_price']+'</small> <span class="kss-discount text-danger">'+this.dataset['discount_per']+'% OFF</span>');

    jQuery('#cd-add-to-cart').prop("disabled", false);

});