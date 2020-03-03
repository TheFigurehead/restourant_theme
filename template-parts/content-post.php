<header class="entry-header teaser-header">
    <?php
    if ( 'post' === get_post_type() ) {
        echo '<div class="entry-meta">';

            //nu_food_posted_on();
            echo nu_food_time_link();

        echo '</div><!-- .entry-meta -->';
    };
    
    the_title( '<h1 class="teaser-title entry-title">', '</h1>' );

    ?>
    <div class="teaser-tags">
        <?php nu_food_tag_list(); ?>
    </div>
</header><!-- .entry-header -->
<?php the_content(); ?>
<p>Written by:
<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
