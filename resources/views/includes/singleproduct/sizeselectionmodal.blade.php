<!-- Mobile size selection -->
<div class="modal fade size-modal" id="size-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title font-weight-bold">Select a size</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		@include('includes.singleproduct.productsizes', ['params' => $params, 'selected_color_id' => $selected_color_id, 'radio_name' => 'kss-sizes-display'])
      </div>
      <div class="modal-footer add-bag-btn">
      	<button id="cd-add-to-cart" class="btn kss-btn kss-btn--big cd-add-to-cart">
			<div class="kss-btn__wrapper d-flex align-items-center justify-content-center"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</div>
		</button>
      </div>
    </div>
  </div>
</div>