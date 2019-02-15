@extends('layouts.amp')

@section('headjs')
  <?php /* wp_head(); */ ?>
@stop

@section('content')

  <!-- section -->

  <main id="content" role="main" class="">
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
        <header>
          <?php
            if ( has_post_thumbnail() ) {
              isa_amp_featured_img('medium');
            } ?>
          <?php the_title( '<h1 class="mb1 pt2 px3">', '</h1>' );  ?>
          <div class="px3 ">
          <?php
              $categories = get_the_category();
              $separator = ' ';
              $output = '';
              if ( ! empty( $categories ) ) {
                  foreach( $categories as $category ) {
                      $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" class="text-decoration-none"><span class="ampstart-subtitle block px3 pt1 mb2">' . esc_html( $category->name ) . '</span></a>' . $separator;
                  }
                  echo trim( $output, $separator );
              }
          ?>
          </div>
          <!-- <amp-img src="../img/blog/spritzer.jpg" width="1280" height="853" layout="responsive" alt="The final spritzer" class="mb4 mx3"></amp-img> -->
        </header>

        <div class="px3 mb4">
          <?php echo amp_sanitize_post_content();
            wp_reset_postdata();

            $posts = get_post_by_tags(array('tag_1','tag_2','tag_3'));
            print_r($posts);
          ?>

          <hr>
        </div>


        <div class="px3 mb4">

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
            <section class="related-articles">
              <h3 class="mb3" style="color:#7d7d7d;">Read Next</h3>

              <?php while ( $wpex_query->have_posts() ) {
                $wpex_query->the_post(); ?>
                  <div class="kss-posts mb4">
                    <a href="<?php the_permalink(); ?>?amp" class="" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
                      <div class="">
                        <?php
                          if ( has_post_thumbnail() ) {
                           isa_amp_featured_img('medium');
                          } ?>
                      </div>
                    </a>
                    <div class="">
                      <a href="<?php the_permalink(); ?>?amp" class="text-decoration-none" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
                        <h2 class=""><?php the_title(); ?></h2>
                        <p class="mt1 mb1">
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
                      <div>
                        <?php
                            $categories = get_the_category();
                            $separator = ' ';
                            $output = '';
                            if ( ! empty( $categories ) ) {
                                foreach( $categories as $category ) {
                                    $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" class="text-decoration-none"><span class="ampstart-subtitle block px3 pt1 mb2">' . esc_html( $category->name ) . '</span></a>' . $separator;
                                }
                                echo trim( $output, $separator );
                            }
                        ?>
                    </div>
                    </div>
                  </div>
              <?php
              // End loop
                } ?>
            </section>
          <?php  }
          wp_reset_postdata(); ?>
        </div>
      </section>
    </article>
    <!-- /article -->

  <?php endwhile; ?>

  <?php endif; ?>

  </main>
  <!-- /section -->

@stop

@section('footjs')
  <?php /* wp_footer(); */ ?>
@stop