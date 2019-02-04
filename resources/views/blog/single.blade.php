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

  <!-- Track views -->
  <?php wpb_set_post_views(get_the_ID()); ?>

    <!-- article -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <section class="single-blog">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="d-flex row layout-2">
                <div class="d-flex flex-column justify-content-center col-lg-7 order-1 order-lg-0">
                  <div>
                    <div class="mt-4 mb-2 d-none d-lg-block">
                      <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb mb-1 bg-transparent p-0">
                          <li class="breadcrumb-item"><a href="/">Home</a></li>
                          <li class="breadcrumb-item"><a href="<?php echo get_home_url(); ?>">Blog</a></li>
                          <li class="breadcrumb-item active"><a><?php echo the_title() ?></a></li>
                        </ol>
                      </nav>
                    </div>

                    <?php
                    if ( is_single() ) :
                      the_title( '<h1 class="single-blog__heading bl-single-heading">', '</h1>' );
                    else :
                      the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                    endif; ?>

                    <p class="bl-single-caption row-spacer">
                      <?php
                      if ( has_excerpt() ) {
                          // This post has excerpt
                        echo wp_strip_all_tags( get_the_excerpt(), true );
                      }
                      ?>
                    </p>
                    <div class="d-flex flex-column flex-sm-row mb-1 mr-2 post-tags pr-2 mt-2">
                      <div class="post-tags mb-1 d-flex">
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
                <div class="col-lg-5 order-0 order-lg-1 bl-single-img-wrapper mb-4 mb-sm-0">
                    <?php
                      if ( has_post_thumbnail() ) {
                        the_post_thumbnail('medium_large', array('class' => 'd-block w-100 img-fluid', 'sizes' => '(min-width:1200px) 470px, (min-width:992px) 380px, 100vw'));
                      }
                      else { ?>
                        <img src="{{CDN::asset('/img/blog/kss_logo_gray.jpg') }}" class="d-block w-100 img-fluid" />
                    <?php } ?>
                  <small class="text-muted mt-2 pl-3 pl-lg-0 d-inline-block">
                    <?php
                      if ( has_post_thumbnail() ) {
                        echo the_post_thumbnail_caption();
                     } ?>
                  </small>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-sm-4 pt-sm-4">
            <div class="col-lg-1 mt-4 d-none d-lg-block">
              <div class="sticky-col">
                <ul class="list-inline single-blog__social">
                  <li>
                    <a href="http://www.facebook.com/share.php?u=<?php echo urlencode(get_the_permalink()) ?>" target="_new"><i class="fab fa-facebook fb s-icon"></i></a>
                  </li>
                  <li>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()). '+'. urlencode(get_the_permalink()) ?>" target="_new"><i class="fab fa-twitter-square twitter s-icon"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-8 px-sm-4">
              <div class="blog-content mt-4 blog-content--spacer">
                <?php the_content();
                  wp_reset_postdata();
                ?>
              </div>
            </div>
            <div class="col-lg-3 mt-4 d-none d-lg-block">
              <div class="">

                <?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
                    <div id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-2' ); ?>
                    </div>
                <?php endif;  ?>

              </div>
            </div>
          </div>

          <!-- More posts -->
          <?php
          // Default arguments
          $args = array(
            'posts_per_page' => 3, // How many items to display
            'post__not_in'   => array( get_the_ID() ), // Exclude current post
            'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
          );

          // Check for current post category and add tax_query to the query arguments
          $cats = wp_get_post_terms( get_the_ID(), 'category' );
          $cats_ids = array();
          foreach( $cats as $wpex_related_cat ) {
            $cats_ids[] = $wpex_related_cat->term_id;
          }
          if ( ! empty( $cats_ids ) ) {
            $args['category__in'] = $cats_ids;
          }

          // Query posts
          $wpex_query = new wp_query( $args );

          // Loop through posts
          if ( $wpex_query->have_posts() ) {?>
            <section class="more-posts mt-sm-4 pt-sm-4">
              <hr class="mt-5">
              <h3 class="include-title">Read Next</h3>

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
          <?php  }
          wp_reset_postdata(); ?>
        </div>
      </section>
    </article>
    <!-- /article -->

  <?php endwhile; ?>

  <?php else: ?>

    <!-- article -->
    <article>

      <h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

    </article>
    <!-- /article -->

  <?php endif; ?>

  </section>
  <!-- /section -->

@stop

@section('footjs')
  <?php wp_footer(); ?>
@stop