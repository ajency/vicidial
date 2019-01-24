@extends('layouts.default')

@section('headjs')
  <!-- Test -->
  <?php wp_head(); ?>
  <!-- Test end -->
@stop

@section('content')

  <!-- Blog Hero Grid -->
  <section class="blog-hero">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="cover-post hero-post">
            <div class="featured-section">

              <div class="featured-section__col cover-post">
                <?php
                  $args = array(
                        'posts_per_page' => 1,
                        'meta_key' => 'meta-checkbox',
                        'meta_value' => 'yes'
                    );
                    $featured = new WP_Query($args);

                if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); ?>

                <div class="featured-post">
                  <div class="featured-post__cover">
                    <a href="<?php the_permalink(); ?>" class="d-block">
                      <?php the_post_thumbnail('large', array('class' => 'd-block w-100 img-fluid cover-img')); ?>
                    </a>
                  </div>
                  <div class="post-content">
                    <a href="<?php the_permalink(); ?>" class="d-block">
                      <h1 class="featured-post__title">
                        <?php the_title(); ?>
                      </h1>
                      <p class="featured-post__desc">
                        <?php the_excerpt();?>
                      </p>
                    </a>
                    <div class="post-content__links">
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

                <?php

                endwhile; else:
                endif;
                ?>

              </div>

              <div class="d-flex flex-column flex-md-row no-cover-post">
                <?php
                  $args = array(
                        'posts_per_page' => 2,
                        'offset'=> 1,
                        'meta_key' => 'meta-checkbox',
                        'meta_value' => 'yes'
                    );
                    $featured = new WP_Query($args);

                if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); ?>
                <div class="featured-section__col">
                  <div class="featured-post">
                    <div class="featured-post__cover">
                      <a href="<?php the_permalink(); ?>" class="d-block">
                        <?php the_post_thumbnail('large', array('class' => 'd-block w-100 img-fluid cover-img')); ?>
                      </a>
                    </div>
                    <div class="post-content">
                      <a href="<?php the_permalink(); ?>" class="d-block text-black">
                        <h1 class="featured-post__title">
                          <?php the_title(); ?>
                        </h1>
                        <p class="featured-post__desc">
                          <?php the_excerpt();?>
                        </p>
                      </a>
                      <div class="post-content__links">
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

                endwhile; else:
                endif;
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3 column layout -->

  <section class="random-posts mt-4 mb-2 py-4">
     <div class="container">
        <div class="row">
           <div class="col-sm-12">
              <div class="text-center text-lg-left">
                 <h1 class="border-header">
                    Latest Posts
                 </h1>
              </div>
              <div class="latest-posts mt-4 pt-3">
                 <div class="row more-post-grid">
                    <?php
                    $args = array(
                       'numberposts' => 3,
                       'order'=> 'DESC',
                       'orderby' => 'date',
                       'meta_query' => array(
                            array(
                             'key' => '_thumbnail_id',
                             'compare' => 'EXISTS'
                            ),
                        )
                    );
                    $postslist = get_posts( $args );
                    foreach ($postslist as $post) :  setup_postdata($post); ?>
                       <div class="col-sm-4">
                          <div class="kss-posts">
                             <a href="<?php the_permalink(); ?>" class="d-block" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
                                <div class="kss-posts__cover mb-3">
                                   <?php the_post_thumbnail('medium', array('class' => 'd-block w-100 img-fluid')); ?>
                                </div>
                                <div class="kss-posts__content">
                                   <h1 class="bl-single-heading bl-single-heading--small"><?php the_title(); ?></h1>
                                   <p class="bl-single-caption bl-single-caption--small">
                                      <?php
                                      if ( has_excerpt( $post->ID ) ) {
                                          // This post has excerpt
                                         echo wp_strip_all_tags( get_the_excerpt(), true );
                                      } else {
                                          // This post has no excerpt
                                         echo wp_trim_words( get_the_content(), 12 );
                                      }
                                      ?>
                                   </p>
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
                                      <!-- <div class="post-tags d-flex">
                                         <p class="post-tags__title">Tags :</p>
                                         <div class="post-tags__data">
                                            <a href="#"><span>Shoes</span></a><a href="#"><span>Shoes</span></a>
                                         </div>
                                      </div> -->
                                   </div>
                                </div>
                             </a>
                          </div>
                       </div>
                    <?php endforeach; ?>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </section>

  <!-- Section with sidebar -->

  <section class="pt-3">
     <div class="container">
        <hr class="mb-4">
        <div class="row">
           <div class="col-lg-8">
              <div class="mt-4">
                 <div class="text-center text-lg-left">
                    <h1 class="border-header">
                       Trending On KidSuperStore
                    </h1>
                 </div>
              </div>
              <div class="blog-col mt-3">
              <?php
              $popularpost = new WP_Query( array( 'posts_per_page' => 4, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
              while ( $popularpost->have_posts() ) : $popularpost->the_post(); ?>
                 <div class="blog-col__wrapper">
                    <article class="kss-posts">
                       <a href="<?php echo get_home_url(); ?>" class="d-block">
                          <div class="kss-posts__cover mb-3">
                             <?php the_post_thumbnail('medium', array('class' => 'd-block w-100 img-fluid')); ?>
                          </div>
                          <div class="kss-posts__content">
                             <h1 class="bl-single-heading bl-single-heading--small"><?php echo the_title() ?></h1>
                             <p class="bl-single-caption bl-single-caption--small">
                                <?php
                                if ( has_excerpt( $post->ID ) ) {
                                    // This post has excerpt
                                   echo wp_strip_all_tags( get_the_excerpt(), true );
                                } else {
                                    // This post has no excerpt
                                   echo wp_trim_words( get_the_content(), 18 );
                                }
                                ?>
                             </p>
                             <div class="flex-sm-row mb-1 mr-2 post-tags">
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
                       </a>
                    </article>
                 </div>
              <?php endwhile;?>
              </div>
           </div>
           <div class="col-sm-4 mt-4 d-none d-lg-block">
              <div class="blog-sidebar">
                 <div class="newsletter mb-4 d-none">
                    <div class="blog-sidebar__header">
                       Weekly Newsletter
                    </div>
                    <div class="newsletter__content">
                       <p class="newsletter__text">
                          Join <strong>1,000+ subscribers</strong> and get the latest kids fashion resources and articles delivered directly to your inbox.
                       </p>
                       <div class="d-flex">
                          <input type="email" value="" placeholder="email@address.com" class="form-control newsletter__input">
                          <input type="submit" value="Subscribe" name="" class="btn kss-btn kss-btn-small subscribe-btn">
                       </div>
                    </div>
                 </div>
                 <div class="c-popular mb-4">
                    <div class="text-center text-lg-left">
                           <h1 class="border-header">
                             Popular Posts
                           </h1>
                       </div>
                    <ul class="c-popular__lists">
                       <li class="d-flex">
                          <span class="c-popular__index pr-3">01</span>
                          <a href="#" class="kss-anchor">
                          Is affirmative action in India becoming a gimmick?.</a>
                       </li>
                       <li class="d-flex">
                          <span class="c-popular__index pr-3">02</span>
                          <a href="#" class="kss-anchor">Controversial India copper plant to reopen.</a>
                       </li>
                       <li class="d-flex">
                          <span class="c-popular__index pr-3">03</span>
                          <a href="#" class="kss-anchor">The man separating Ronaldo and Messi?.</a>
                       </li>
                       <li class="d-flex">
                          <span class="c-popular__index pr-3">04</span>
                          <a href="#" class="kss-anchor">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
                       </li>
                    </ul>
                 </div>
                 <div class="store-adv">
                    <div class="store-banner position-relative">
                       <p class="store-banner__title">Want to see our clothes in real life?</p>
                       <img class="d-block w-100 img-fluid pb-1"
                            src="<?php echo get_template_directory_uri(); ?>/img/store-banner-mo-small.jpg"
                            alt="Visit our store"
                            title="Visit our store"/>
                       <div class="contentWrapper text-center d-flex align-items-center">
                          <div>
                             <span class="store-banner__caption">Just visit any one of stores near you!</span>
                             <a href="https://www.kidsuperstore.in/stores/" class="btn kss-btn kss-btn--small">Visit our store</a>
                          </div>
                       </div>
                       </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </section>

@stop

@section('footjs')
  <?php wp_footer(); ?>
@stop