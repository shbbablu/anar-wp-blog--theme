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
                                <?php  echo wp_trim_words(get_the_content(), 30); ?>
                            </p>
                        </div>
                        <div class="blog-post__footer">
                            <a class="blog-post__footer-link" href="<?php the_permalink(); ?>">Read more</a>
                            <div class="blog-post__footer-social">
                                <span>Share:</span>
                                <div class="blog-post__footer-social-icons">
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
                    </div>
                    <?php endwhile; ?>
                    
                <?php 
                
                $pagination = get_the_posts_pagination(
                        array(
                        'mid_size'           => 1,
                        'prev_text'          => ( 'Previous Page' ),
                        'next_text'          => ( 'Next Page' ),
                        'screen_reader_text' => __( ' ' ),
                        'type' => 'list',));
                
                $pagination = str_replace('navigation pagination', 'blog-pagination', $pagination);
                $pagination = str_replace('page-numbers', 'blog-pagination__items', $pagination);
                $pagination = str_replace('<li>', '<li class="blog-pagination__item">', $pagination);
                echo $pagination;
                ?>

            </div>
            <?php get_sidebar(); ?>
        </div>
    </main>


    <?php
get_footer();
