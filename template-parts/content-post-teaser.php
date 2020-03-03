<article id="article_<?php the_ID(); ?>" <?php post_class('teaser'); ?>>

    <header class="entry-header teaser-header">
		<?php
            if ( 'post' === get_post_type() ) {
                echo '<div class="entry-meta">';
                    if ( is_single() ) {
                        nu_food_posted_on();
                    } else {
                       echo nu_food_time_link();

                         //nu_food_edit_link();
                    };
                echo '</div><!-- .entry-meta -->';
            };

            if ( is_single() ) {
                the_title( '<h1 class="teaser-title entry-title">', '</h1>' );
            } elseif ( is_front_page() && is_home() ) {
                the_title( '<h3 class="teaser-title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            } else {
                the_title( '<h2 class="teaser-title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            }
		?>
	</header><!-- .entry-header -->

    <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
        <div class="post-thumbnail teaser-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="teaser-tags">
        <?php
        if ( is_single() ) {
            nu_food_tag_list();
        } else {
            nu_food_tag_list();
        };
        ?>
    </div>

    <div class="entry-summary teaser-content">
        <?php nu_the_excerpt(); ?>
    </div><!-- .entry-summary -->



</article><!-- #post-## -->
