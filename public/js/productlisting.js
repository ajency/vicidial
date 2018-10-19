
$(".select-size input[type=radio]").change(function(evt){
    if(this.dataset['list_price'] == this.dataset['sale_price']) {
        jQuery('#kss-price-'+this.dataset['product_id']+'-'+this.dataset['color_id']).html('₹'+this.dataset['sale_price']);
    } else {
        jQuery('#kss-price-'+this.dataset['product_id']+'-'+this.dataset['color_id']).html('₹'+this.dataset['sale_price']+' <small class="kss-original-price text-muted">₹'+this.dataset['list_price']+'</small><span class="kss-discount text-danger">'+this.dataset['discount_per']+'% OFF</span>');
    }

    var buttn = $(this).closest('.select-size').find("button");
    buttn.removeClass("disabled");
    buttn.prop("disabled", false);
    buttn.addClass("cd-add-cart");
    buttn.text("Add To Cart");
});
