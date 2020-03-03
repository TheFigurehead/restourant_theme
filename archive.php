<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nu_food
 *
 * -menu changed
 * -container
 * -wrap-classes
 * -read more link
 * -svg icons
 */

get_header();
?>

<?php
if(get_taxonomy(get_queried_object()->taxonomy)->object_type[0]){
    $post_type = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];
}
$sidebar_layout = get_theme_mod( $post_type . '_layout' ) ;

?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

            <?php if ( have_posts() ) : ?>

                <div class="container">
                <header class="page-header">
                    <?php
                    //Why is BLACKKKKKKKKK!!!?????????
//                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_title( '<h1>', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                    ?>
                </header><!-- .page-header -->
                <div class="row">
                <?php

                // if( $sidebar_layout == 'Left Side' || $sidebar_layout == 'Both' ): ?>

                    <div class="sidebar-col col-lg-3 <?php echo $post_type ? $post_type : ''; ?>">

                        <?php  //nu_food_sidebar( 'sidebar-1' ) ?>
                        <?php  get_sidebar(); ?>

                    </div><?php

                // endif;

                ?>
                <div class="col-lg-9">
                <div class="row">
                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();

                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        echo '<div class="col-lg-4">';
                            get_template_part( 'template-parts/content', get_post_type() . '-teaser' );
                        echo '</div>';

                    endwhile;
                    ?>
                    </div>
                    </div>
                </div>
                    <?php
                    // the_posts_navigation();

                    // nu_pagination(
                    // 	array
                    // 	(
                    //     'next' => 'Something',
                    //     'prev' => 'New',
                    //     'serg' => 'Cool guy',
                    //     'items' => get_posts(
                    // 			array(
                    // 				'post_type'=>'page',
                    // 				'numberposts' => 5
                    // 			)
                    // 		)
                    //   ));
                    nu_pagination();
                    // echo "lol";

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;
                ?>
                </div>

            </main><!-- #main -->
        </div><!-- #primary -->

        <?php var_dump( $sidebar_layout );?>

        <?php

            if( $sidebar_layout == 'Right Side' || $sidebar_layout == 'Both' ): ?>

                <div class="sidebar-col col-3 <?php echo $post_type ? $post_type : ''; ?>">

                    <?php  nu_food_sidebar( 'sidebar-2' ) ?>

                </div><?php

            endif;
        ?>

<?php

get_footer();
