@extends('layouts.default')

@section('headjs')
  <?php wp_head(); ?>
@stop

@section('content')

  <!-- section -->

  <section>
  <?php /*
    $singlepost   = get_post( '.{{$post->ID}}.' );
    setup_postdata($singlepost)
    */
  ?>

  <?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <!-- article -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <section class="single-blog">
        <div class="bl-single-img-wrapper mb-4 mb-sm-0">
            <?php
              if ( has_post_thumbnail() ) {
                the_post_thumbnail('full', array('class' => 'd-block w-100 img-fluid', 'sizes' => '100vw'));
              }
              else { ?>
                <img src="{{CDN::asset('/img/blog/kss_logo_gray.jpg') }}" class="d-block w-100 img-fluid" />
            <?php } ?>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div>
                <div class="mt-4 mb-2 d-none d-lg-block">
                  <nav aria-label="breadcrumb" class="">
                    <ol class="breadcrumb mb-1 bg-transparent p-0">
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active"><a><?php echo the_title() ?></a></li>
                    </ol>
                  </nav>
                </div>

                <?php
                  the_title( '<h1 class="single-blog__heading bl-single-heading">', '</h1>' );
                 ?>

              </div>
            </div>
          </div>
          <div class="row ">
            <div class="col-lg-12">
              <div class="blog-content mt-4">
                <?php the_content();
                  wp_reset_postdata();
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </article>
    <!-- /article -->

  <?php endwhile; ?>

  <?php endif; ?>

  </section>
  <!-- /section -->

@stop

@section('footjs')
  <?php wp_footer(); ?>
@stop