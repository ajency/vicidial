$(function(){var t='<div class="kss-btn__wrapper d-flex align-items-center justify-content-center"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</div><div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Bag</div><div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>',s=$(".add-bag-btn .cd-add-to-cart");if($("input[type=radio][name=kss-sizes]:checked").length>0&&(jQuery("#cd-add-to-cart").prop("disabled",!1),s.html(t)),$("input[type=radio][name=kss-sizes]").change(function(){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price").html("₹"+this.dataset.sale_price):jQuery("#kss-price").html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small> <span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>"),replaceURLParameter("size",this.dataset.title),jQuery("#cd-add-to-cart").prop("disabled",!1),s.html(t)}),$(window).width()<767){var e=$(".colorOptions").detach();$(".product-collapse").after(e),$(".colorOptions").removeClass("d-none"),$(".variant-wrapper,.product-color--single").tooltip("disable"),$(".colorOptions__trigger").click()}fbq("track","ViewContent",{value:default_price,currency:"INR",content_ids:parent_id+"-"+selected_color_id,content_type:"product_group"})});
