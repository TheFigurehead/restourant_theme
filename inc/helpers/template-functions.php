<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package woo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function woo_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'woo_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function woo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'woo_pingback_header' );


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * read more link
 *
 * @since Twenty Seventeen 1.0
 *
 * @param
 * @return
 */

function nu_food_excerpt_more($text){
	if ( is_admin() ) {
	  return $link;
	}
	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
	  esc_url( get_permalink( get_the_ID() ) ),
	  /* translators: %s */
	  sprintf( __( $text, 'nu_food' ) )
	);
	return ' &hellip; ' . $link;
}

function nu_the_excerpt($id = 0, $words = 20, $link = ''){
	$id = ($id == 0) ? get_the_ID() : $id ;
	$link = ($link == '') ? nu_food_excerpt_more(get_option('nu_food_section_posts_read_more')) : $link;
	$words = (get_option('nu_food_section_posts_teaser_length')) ? get_option('nu_food_section_posts_teaser_length') : $words;
	echo wp_trim_words( get_the_excerpt($id), $words, $link );
}
