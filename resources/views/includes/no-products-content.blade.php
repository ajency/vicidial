<div class="container mt-3">
  <div class="row">
      <div class="col-12 text-center my-4">
            <img src="/img/empty_troly.png" class="img-fluid lazyload " width="400px" />
            @isset($sectionnotfound)
            	<h2 class="my-4">Sorry, no results found!</h2>
				<a href="#">
	          		<button type="button" class="btn btn-outline-dark btn-lg m-auto d-block">Go back</button>
	        	</a>
            @else
            	<h2 class="mx-4">No products available!</h2>
            	<p>Please check the spelling or try searching something else</p>
				<a href="/shop">
	          		<button type="button" class="btn btn-outline-dark btn-lg m-auto d-block">Back to Shop</button>
	        	</a>
            @endisset
            
      </div>
    </div>
</div>