<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package nu_food
 */

get_header();
?>
    <div class="container">
        <div class="row">
            <div id="primary" class="content-area col-9">
                <main id="main" class="site-main">

                    <?php
                    while ( have_posts() ) :
                        the_post();

                        get_template_part( 'template-parts/content', get_post_type() );

                        the_post_navigation( array(
                            'next_text' => '<span class="meta-nav" aria-hidden="true">Далее</span> ' .
                                '<span class="screen-reader-text">Следующая запись</span> ' .
                                '<span class="post-title">%title</span>',
                            'prev_text' => '<span class="meta-nav" aria-hidden="true">Назад</span> ' .
                                '<span class="screen-reader-text">Предыдущая запись</span> ' .
                                '<span class="post-title">%title</span>',
                            'screen_reader_text' => 'Навигация'
                        ) );

                        // If comments are open or we have at least one comment, load up the comment template.
//                        if ( comments_open() || get_comments_number() ) :
//                            comments_template();
//                        endif;

                    endwhile; // End of the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->
            <div class="col-3">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php

get_footer();
