$(function(){var s='<div class="btn-label-initial d-flex align-items-center justify-content-center py-1"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</div><div class="btn-label-success py-1"><i class="fas fa-arrow-right"></i> Go to Bag</div><div class="btn-icon py-1"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>',t=$(".add-bag-btn .cd-add-to-cart");if($("input[type=radio][name=kss-sizes]:checked").length>0&&(jQuery("#cd-add-to-cart").prop("disabled",!1),t.html(s)),$("input[type=radio][name=kss-sizes]").change(function(){this.dataset.list_price==this.dataset.sale_price?jQuery("#kss-price").html("₹"+this.dataset.sale_price):jQuery("#kss-price").html("₹"+this.dataset.sale_price+' <small class="kss-original-price text-muted">₹'+this.dataset.list_price+'</small> <span class="kss-discount text-danger">'+this.dataset.discount_per+"% OFF</span>"),replaceURLParameter("size",this.dataset.title),jQuery("#cd-add-to-cart").prop("disabled",!1),t.html(s)}),$(window).width()<767){var a=$(".colorOptions").detach();$(".product-collapse").after(a),$(".colorOptions").removeClass("d-none"),$(".variant-wrapper,.product-color--single").tooltip("disable"),$(".colorOptions__trigger").click()}});