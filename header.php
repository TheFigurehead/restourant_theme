<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
  <title>
    <?php
      global $page, $paged;
      wp_title( '|', true, 'right' );
      bloginfo( 'name' );
      $site_description = get_bloginfo( 'description', 'display' );
      if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";
      if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) echo esc_html( ' | ' . sprintf( __( 'Page %s', 'nu_food' ), max( $paged, $page ) ) );
    ?>
  </title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <?php
    if ( is_singular() && get_option( 'thread_comments' ) )
      wp_enqueue_script( 'comment-reply' );
    wp_head();
  ?>
</head>
<body <?php body_class(); ?>>
  <?=get_option('nu_food_section_select')?>
  <?php // get_template_part('component/front/header/header', get_option('nu_food_section-select')); ?>
  <?php get_template_part('component/front/header/header', 'default'); ?>
  <?php nu_breadcrumbs(); ?>
