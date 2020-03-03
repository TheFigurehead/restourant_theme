<?php
// namespace north;
// require get_template_directory() . '/inc/Init.class.php';

// namespace north;

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

// use north\Init as Init;

$init = new \North\Init();
$init->run();

require get_template_directory() . '/inc/classes/Customizer.class.php';
require get_template_directory() . '/inc/helpers/general.php';
require get_template_directory() . '/inc/helpers/pagination.php';
require get_template_directory() . '/inc/helpers/template-tags.php';
require get_template_directory() . '/inc/helpers/template-functions.php';

function nu_food_setup(){
    /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
    add_theme_support( 'post-thumbnails' );
    //declare WC support
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'nu_food_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nu_food_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'nu_food' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'nu_food' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Blog Sidebar 2', 'nu_food' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'nu_food' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'nu_food_widgets_init' );

function nu_food_sidebar( $sidebar_id ) {

    if ( $sidebar_id ) :

        if ( ! is_active_sidebar( $sidebar_id ) ) {
            return;
        }
        ?>

        <aside id="secondary-<?php echo $sidebar_id; ?>" class="widget-area">
            <?php dynamic_sidebar( $sidebar_id ); ?>
        </aside><!-- #secondary --><?php

    else : return;

    endif; // End is_singular().
}


function nu_admin_blunt_enqueue()
{
    wp_enqueue_script('nu-admin-blunt', get_template_directory_uri() . '/assets/admin/js/nu-admin.js');
}
add_action('admin_enqueue_scripts', 'nu_admin_blunt_enqueue');

function my_enqueue($hook) {
    if ( 'edit.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'my_custom_script', get_template_directory_uri() . '/assets/js/nu-admin.js' );
}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );