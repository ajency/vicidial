@extends('layouts.default')

@php
  $delaycss = true;
  $sticky_btn = true;
@endphp

@section('headjs')
	@include('includes.abovethefold.singleproductcss')
@stop

@section('content')

	<div class="container mt-0 mt-md-4">
		<div class="row">
			<div class="col-md-12 d-none d-md-block">
				<!-- Breadcrumbs -->
				@include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb'], 'shop' => true])
			</div>
			<div class="col-sm-12 col-lg-7">
				<!-- Product Images -->
				@include('includes.singleproduct.productimages', ['params' => $params])

				@php
					$selected_color_id = $params['selected_color_id'];
					$parent_id = $params['parent_id'];
				@endphp

				<!-- Product Color-selection Section -->
				@include('includes.singleproduct.productcolorselection', ['params' => $params, 'selected_color_id' => $selected_color_id])
			</div>
			<div class="col-sm-12 col-lg-5">

				<!-- Product Title & Prices Section -->
				@include('includes.singleproduct.producttitle', ['params' => $params, 'selected_color_id' => $selected_color_id])

				<hr class="my-2">

				<div class="d-flex justify-content-between mt-3">
					<label class="">Select Size (Age Group)</label>
					<!-- Product Size Chart -->
					<!-- <a href="#sizeModal" class="font-weight-bold kss-link" data-toggle="modal" data-target="#sizeModal">Size Chart</a>

					<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					    <div class="modal-content">
					    	<div class="modal-header">
				    	        <h5 class="modal-title ml-auto">Size Chart</h5>
				    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				    	          <span aria-hidden="true">&times;</span>
				    	        </button>
					    	</div>
					      	<div class="modal-body">
					      		<img src="/img/size_chart.png" class="img-fluid">
					      	</div>
					    </div>
					  </div>
					</div> -->

				</div>
				<!-- Product Size Selection -->
				@include('includes.singleproduct.productsizes', ['params' => $params, 'selected_color_id' => $selected_color_id, 'radio_name' => 'kss-sizes'])

				<div class="text-danger d-none font-weight-bold position-relative size-select-error" style="top: -15px;">Please select a size</div>

				<div class="row">

					<div class="col-sm-12 col-md-12 col-12 mobile-fixed pb-0 pb-sm-2 add-bag-btn visible shadow-layer">

						<!-- <div class="row"> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pr-1">
								<button class="btn btn-outline-secondary btn-lg btn-block">
									<div class="btn-label-initial"><i class="far fa-heart"></i> Save to Wishlist</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Cart</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							</div> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pl-1"> -->
								@if ($params['show_button'])
								<button id="cd-add-to-cart" class="btn kss-btn kss-btn--big cd-add-to-cart">
									<!-- <div class="kss-btn__wrapper d-flex align-items-center justify-content-center d-md-none">SELECT SIZE</div> -->
									<div class="kss-btn__wrapper d-flex align-items-center justify-content-center"><span class="btn-contents align-items-center"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</span> <div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div></div>
								</button>
								@else
								    <div class="out-of-stock">Currently unavailable</div>
								@endif

							<!-- </div> -->
						<!-- </div> -->
					</div>
				</div>

				<!-- <div class="alert alert-light my-4">
					<div class="d-flex justify-content-between">
						 <label class="text-body">
					 	<i class="fas fa-truck"></i> Check Delivery Options
					 	</label>
						<a class="font-weight-bold kss-link" data-toggle="collapse" href="#kss_pincode" role="button" aria-expanded="false" aria-controls="collapseExample">Add Pincode</a>
					</div>
					<div class="collapse mb-2 mt-4" id="kss_pincode">
					  	<form class="form-inline">
						   	<div class="form-group m-0 w-70">
                           		<input class="form-control form-control-lg" id="city" type="number">
                            	<label class="control-label">Check Pincode</label>
	                      	</div>
						  	<button type="submit" class="btn btn-primary mb-2 mt-2">Check</button>
						</form>
						<h6 class="text-dark mt-2 font-weight-bold">Delivery by 30 Aug, Thursday</h6>
						<br>
					</div>
				 	<p class="text-muted">Tax: Applicable tax on the basis of exact location & discount will be charged at the time of checkout</p>
				</div> -->

				<!-- Details / Additional info / Reviews -->
				@include('includes.singleproduct.productdetails', ['params' => $params])

			</div>
		</div>
		@include('includes.similar-products',["items"=>$similar_data_params])

		<?php
		$tags = $params['metatags'];
		$posts = get_post_by_tags($tags,'3');
		if ( $posts->have_posts() ) {?>
		  	<section class="more-posts mt-sm-4 pt-sm-4">
			    <hr class="mt-5">
			    <h3 class="include-title">Related Articles</h3>

			    <div class="relatedposts">
			      <div class="row more-post-grid">
			          <?php while ( $wpex_query->have_posts() ) {
			            $wpex_query->the_post(); ?>
			            <div class="col-sm-4">
			              <div class="kss-posts">
			                <a href="<?php the_permalink(); ?>" class="d-block" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
			                    <?php
			                      if ( has_post_thumbnail() ) { ?>
			                      <div class="kss-posts__cover mb-3">
			                      <?php
			                        the_post_thumbnail('medium', array('class' => 'd-block w-100 img-fluid', 'sizes' => '(min-width:992px) 370px, 100vw'));
			                      }
			                      else { ?>
			                      <div class="kss-posts__cover no-image mb-3">
			                        <img src="{{CDN::asset('/img/blog/kss_logo_gray.jpg') }}" class="d-block w-100 img-fluid" />
			                    <?php } ?>
			                  </div>
			                </a>
			                  <div class="kss-posts__content">
			                    <a href="<?php the_permalink(); ?>" class="d-block" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
			                      <h1 class="bl-single-heading bl-single-heading--small"><?php the_title(); ?></h1>
			                      <p class="bl-single-caption bl-single-caption--small">
			                        <?php
			                        if ( has_excerpt() ) {
			                            // This post has excerpt
			                          echo wp_strip_all_tags( get_the_excerpt(), true );
			                        } else {
			                            // This post has no excerpt
			                          echo wp_trim_words( get_the_content(), 12 );
			                        }
			                        ?>
			                      </p>
			                    </a>
			                    <div class="flex-sm-row mb-1 mr-2 post-tags">
			                      <div class="post-tags mb-1 d-flex">
			                        <!-- <p class="post-tags__title">Category :</p> -->
			                        <div class="post-tags__data">
			                          <?php
			                              $categories = get_the_category();
			                              $separator = ' ';
			                              $output = '';
			                              if ( ! empty( $categories ) ) {
			                                  foreach( $categories as $category ) {
			                                      $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '"><span>' . esc_html( $category->name ) . '</span></a>' . $separator;
			                                  }
			                                  echo trim( $output, $separator );
			                              }
			                          ?>
			                        </div>
			                      </div>
			                    </div>
			                  </div>
			              </div>
			            </div>
			          <?php
			          // End loop
			            } ?>
			      </div>
			    </div>
		  	</section>
		<?php  } ?>

	</div>

	<!-- Size selection modal -->
	@include('includes.singleproduct.sizeselectionmodal')


@stop

@section('footjs')

	<script type="text/javascript">
	    window.variants = @php echo json_encode($params['variant_group']); @endphp;
	    var selected_color_id = {{$selected_color_id}};
	    var parent_id = {{$parent_id}};
	</script>

	@yield('footjs-title')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
	<script type="text/javascript" src="{{CDN::mix('/js/singleproduct.js') }}"></script>
@stop