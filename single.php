<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package anri
 */

get_header(); ?>

    <main>
        <div class="container">
            <div class="col-md-8  col-lg-9">

                <?php while(have_posts()):the_post(); ?>
                    <div class="blog-post">
                        <div class="blog-post__image">
                            <a href="<?php the_permalink(); ?>">
                                <?php  the_post_thumbnail(); ?>
                            </a>
                        </div>
                        <div class="blog-post__title">
                            <h2><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h2>
                        </div>
                        <div class="blog-post__info">
                            <span>By <a href="<?php the_author_meta('url'); ?>"><?php the_author(); ?></a></span>
                            <span><?php the_time('F d,Y')?></span>
                            <span><a href="#"><?php comments_number(); ?></a></span>
                        </div>
                        <div class="blog-post__content">
                            <p>
                                <?php  echo the_content(); ?>
                            </p>
                        </div>
                        <div class="single-post__footer">
                            <div class="single-post__footer-tags">
                                <h3>Tags:</h3>
                                <div class="single-post__footer-tags-list">
                                    <?php the_tags('', '', ''); ?>
                                </div>
                                <h3>Post View: <?php postview($post->ID, true); ?></h3>
                            </div>
                            <div class="single-post__footer-social">
                                <span>Share:</span>
                                <div class="single-post__footer-social-icons">
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#facebook"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#twitter"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#google"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#pinterest"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#email"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="single-post__author">
                            <div class="single-post__author-avatar">
                                <?php echo get_avatar( get_the_author_meta('user_email') ); ?>
                            </div>
                            <div class="single-post__author-info">
                                <h5>Written by <?php echo get_the_author_meta('user_nicename'); ?></h5>
                                <p>
                                    <?php echo get_the_author_meta('description'); ?>
                                </p>
                                <div class="single-post__author-info-social">
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#facebook"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#twitter"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#google"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#pinterest"></use>
                                        </svg>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#instagram"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php 

                          $previous_post = get_previous_post();
                          $next_post = get_next_post();
                         ?>
                            <div class="single-post__nav">
                                <?php if( !empty($previous_post) ) : ?>
                                    <a class="single-post__nav-previous" href="<?php echo $previous_post->guid; ?>">
                                        <span class="single-post__nav-previous-link">Previous Post</span>
                                        <span><?php echo $previous_post->post_title; ?></span>
                                    </a>
                                    <?php endif; ?>
                                        <?php if( !empty($next_post) ) : ?>
                                            <a class="single-post__nav-next" href="<?php echo $next_post->guid; ?>">
                                                <span class="single-post__nav-next-link">Next Post</span>
                                                <span><?php echo $next_post->post_title; ?></span>
                                            </a>
                                        <?php endif; ?>
                            </div>

                            <div class="single-post__related">

                                <?php 


                            $categories = get_the_terms(get_the_id(), 'category');

                            $cat_ids = array();
                            foreach( $categories as $category ){
                              $cat_ids[] = $category->term_id;
                            }


                            $related = new WP_Query(array(
                              'post_type'       => 'post',
                              'posts_per_page'  => 3,
                              'category__in'    => $cat_ids,
                              'post__not_in'    => array( $post->ID )
                            ));




                            while($related->have_posts()) : $related->the_post();
                           ?>

                                    <div class="single-post__related-item">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail(); ?>
                                                <h6><?php the_title(); ?></h6>
                                        </a>
                                        <span><?php the_time('F d, Y'); ?></span>
                                    </div>
                                    <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                            <?php comments_template(); ?>
                    </div>
                    <?php endwhile; ?>
            </div>



            <?php get_sidebar(); ?>
        </div>


    </main>


    <?php get_footer(); ?>
