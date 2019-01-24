@extends('layouts.default')

@section('headjs')
  <!-- Test -->
  <?php wp_head(); ?>
  <!-- Test end -->
@stop

@section('content')

  <section class="">
    <div class="container">
      <div class="row">
         <div class="col-lg-9">
            <div class="mt-4">
               <div class="text-center text-lg-left">
                  <h1 class="border-header">
                     <?php single_cat_title(); ?>
                  </h1>
               </div>
            </div>
            <div class="blog-col mt-3">
            <?php
            $catname = single_cat_title("", false);
            $allpost = new WP_Query( array( 'category_name' => $catname, 'orderby' => 'post_date', 'order' => 'DESC'  ) );
            while ( $allpost->have_posts() ) : $allpost->the_post(); ?>
               <div class="blog-col__wrapper">
                  <article class="kss-posts">
                     <a href="<?php the_permalink(); ?>" class="d-block">
                        <div class="kss-posts__cover mb-3">
                           <?php the_post_thumbnail('medium', array('class' => 'd-block w-100 img-fluid')); ?>
                        </div>
                        <div class="kss-posts__content">
                           <h1 class="bl-single-heading bl-single-heading--small"><?php the_title() ?></h1>
                           <p class="bl-single-caption bl-single-caption--small">
                              <?php
                              if ( has_excerpt( get_the_ID() ) ) {
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
    </div>
  </section>

@stop

@section('footjs')
  <?php wp_footer(); ?>
@stop