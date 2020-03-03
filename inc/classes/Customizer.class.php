<?php

require_once get_template_directory() . '/inc/helpers/customizer.php';

$posts = Kirki_Helper::get_posts( array( 'post_type' => 'post' ) );
$post_types = Kirki_Helper::get_post_types();

/**
 * An example file demonstrating how to add all controls.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.12
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * First of all, add the config.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/config.html
 */
Kirki::add_config(
	'nu_food', array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);
/**
 * Add a panel.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/panels.html
 */
Kirki::add_panel(
	'nu_food_header', array(
		'priority'    => 20,
		'title'       => esc_attr__( 'Header', 'nu_food' ),
		'description' => esc_attr__( 'Contains sections for all nu_food controls.', 'nu_food' ),
	)
);

Kirki::add_panel(
	'nu_food_footer', array(
		'priority'    => 140,
		'title'       => esc_attr__( 'Footer', 'nu_food' ),
		'description' => esc_attr__( 'Contains controls of footer block.', 'nu_food' ),
	)
);

Kirki::add_panel(
	'nu_food_archive', array(
		'priority'    => 140,
		'title'       => esc_attr__( 'Archive Settings', 'nu_food' ),
		'description' => esc_attr__( 'Contains controls of archive pages.', 'nu_food' ),
	)
);

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/sections.html
 */
$sections = array(
    'header_walker' => array(
        'title' 			=> esc_attr__( 'Walker', 'nu_food' ),
        'description' => '',
        'panel' 			=> 'nu_food_header',
    ),
    'header_logo' => array(
        'title' 			=> esc_attr__( 'Logo', 'nu_food' ),
        'description' => '',
        'panel' 			=> 'nu_food_header',
    ),
	'header_background' => array(
		'title' 			=> esc_attr__( 'Background', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_header',
	),
	'footer_background' => array(
		'title' 			=> esc_attr__( 'Background', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_footer',
	),
	'footer_logo' => array(
		'title' 			=> esc_attr__( 'Logo', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_footer',
	),
	'footer_social' => array(
		'title' 			=> esc_attr__( 'Socials', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_footer',
	),
    'post_type_select' => array(
        'title' 			=> esc_attr__( 'Sidebars Select', 'nu_food' ),
        'description' => '',
        'panel' 			=> 'nu_food_archive',
    ),
	'archive_layout' => array(
		'title' 			=> esc_attr__( 'Archive Layout', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_archive',
	),

    //test
    'if_post_type_post' => array(
		'title' 			=> esc_attr__( 'Post Type POst', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_archive',
	),
    'custom_css_setting' => array(
		'title' 			=> esc_attr__( 'Post Type css', 'nu_food' ),
		'description' => '',
		'panel' 			=> 'nu_food_archive',
	)
);
foreach ( $sections as $section_id => $section ) {
	$section_args = array(
		'title'       => $section['title'],
		'description' => $section['description'],
		'panel'       => $section['panel'],
	);
	if ( isset( $section[3] ) ) {
		$section_args['type'] = $section[2];
	}
	Kirki::add_section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}
/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function my_config_nu_food_add_field( $args ) {
	Kirki::add_field( 'nu_food', $args );
}

/**
 * Header Control.
 *
 * @todo Triggers change on load.
 */
my_config_nu_food_add_field(
	array(
		'type'        => 'background',
		'settings'    => 'header_background',
		'label'       => esc_attr__( 'Header Background', 'nu_food' ),
		'description' => esc_attr__( 'Header conrols are pretty complex! (but useful if properly used)', 'nu_food' ),
		'section'     => 'header_background_section',
		'default'     => array(
			'background-color'      => 'rgba(20,20,20,.8)',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		),
	)
);
/**
 *  Header Logo Control.
 */
my_config_nu_food_add_field(
    array(
        'type'        => 'image',
        'settings'    => 'header_logo',
        'label'       => esc_attr__( 'Logo Control (URL)', 'nu_food' ),
        'description' => esc_attr__( 'Description Here.', 'nu_food' ),
        'section'     => 'header_logo_section',
        'default'     => '',
        'partial_refresh' => array(
            'header_site_title' => array(
                'selector'        => '.header__logo',
                'render_callback' => function() {
                    return nu_get_custom_logo('header_logo');
                },
            ),
        ),
    )
);

/**
 *  Footer Logo Control.
 */
my_config_nu_food_add_field(
    array(
        'type'        => 'image',
        'settings'    => 'footer_logo',
        'label'       => esc_attr__( 'Logo Control (URL)', 'nu_food' ),
        'description' => esc_attr__( 'Description Here.', 'nu_food' ),
        'section'     => 'footer_logo_section',
        'default'     => '',
        'partial_refresh' => array(
            'footer_site_title' => array(
                'selector'        => '.footer__logo',
                'render_callback' => function() {
                    return nu_get_custom_logo('footer_logo');
                },
            ),
        ),
    )
);

my_config_nu_food_add_field(
	array(
		'type'        => 'background',
		'settings'    => 'footer_background',
		'label'       => esc_attr__( 'Footer Background', 'nu_food' ),
		'description' => esc_attr__( 'Footer conrols are pretty complex! (but useful if properly used)', 'nu_food' ),
		'section'     => 'footer_background_section',
		'default'     => array(
			'background-color'      => 'rgba(20,20,20,.8)',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		),
	)
);

/**
 *  Footer Socials Control.
 */
my_config_nu_food_add_field(
    array(
        'type'        => 'repeater',
        'settings'    => 'footer_social',
        'label'       => esc_attr__( 'Social (URL)', 'nu_food' ),
        'description' => esc_attr__( 'Description Here.', 'nu_food' ),
        'section'     => 'footer_social_section',
        'row_label' => array(
            'type'  => 'field',
            'value' => esc_attr__('your custom value', 'nu_food' ),
            'field' => 'link_icon',
        ),
        'button_label' => esc_attr__('Add new social', 'nu_food' ),
        'fields' => array(

            'link_url' => array(
                'type'        => 'dropdown-pages',
                'label'       => esc_attr__( 'Link URL', 'nu_food' ),
                'description' => esc_attr__( 'This will be the link URL', 'nu_food' ),
                'default'     => '',
            ),
            'link_icon' => array(
                'type'        => 'select',
                'label'       => esc_attr__( 'Font Awesome Control', 'nu_food' ),
                'description' => esc_attr__( 'Description Here.', 'nu_food' ),
                'choices'     => array(
                    'fa-instagram' => esc_attr__( 'Instaagram', 'nu_food' ),
                    'fa-youtube' => esc_attr__( 'Youtube', 'nu_food' ),
                    'fa-facebook' => esc_attr__( 'Facebook', 'nu_food' ),
                    'fa-twitter' => esc_attr__( 'Twitter', 'nu_food' ),
                ),
            ),

        ),
    )
);

/**
 *
 * Archive Settings
 *
 */



/**
 *
 * Walker Menu Callback Setting
 *
 */
function nu_menu_customize_register( $wp_customize ) {

    if ( isset( $wp_customize->selective_refresh ) ) {

        $wp_customize->selective_refresh->add_partial( 'nu_food-menu-text', array(
            'selector'        => '#header__nav_primary_callback',
            'render_callback' => 'nu_prime_menu_callback',
        ) );

    }

    $wp_customize->add_setting('nu_food-menu-text', array(
        'priority'   => 1,
        'default'     => true,
        'transport'   => 'refresh',
    ));

    $wp_customize->add_control( 'nu_food-menu-text', array(
        'label' => __( '', 'nu_food' ),
        'section' => 'nav_menu[2]',
        'settings' => 'nu_food-menu-text',
        'type'  => 'hidden',
    ));

}
add_action( 'customize_register', 'nu_menu_customize_register' );
function nu_prime_menu_callback(){ ?>

    <label hidden><?php echo get_theme_mod('nu_food-menu-text');?></label><?

}



function archive_settings_callback($control){

    var_dump($control);

    if(get_theme_mod('post_type_select') == 'option-'  ){
        return true;
    }else{
        return false;
    }

}

function nu_food_post_type_select() {

    $post_types = get_post_types('','names');

    $post_type_choices = array();

    foreach ( $post_types as $key => $post_type ) {
        $post_type_choices['option-' . $key] = esc_attr__( $post_type , 'textdomain' );

        Kirki::add_field( $post_type . '_field',  array(
            'type'        => 'switch',
            'settings'    => $post_type . '_setting',
            'label'       => esc_attr__( 'Settings if selected post type '. $post_type , 'kirki' ),
            'description' => esc_attr__( 'Description', 'kirki' ),
            'section'     => 'archive_layout_section',
            'default'     => true,
            'choices'     => array(
                'on'  => esc_attr__( 'Enabled', 'kirki' ),
                'off' => esc_attr__( 'Disabled', 'kirki' ),
            ),
            'active_callback'    => array(
                array(
                    'setting'  => 'post_type_select',
                    'operator' => '==',
                    'value'    => 'option-' . $post_type,
                ),
            ) ,
        ));

        Kirki::add_field( $post_type . '_layout_field', array(
                'type'        => 'radio-image',
                'settings'    => $post_type . '_layout',
                'label'       => esc_attr__( 'Layout of ' . $post_type . ' archive', 'nu_food' ),
                'description' => esc_attr__( 'Choose '. $post_type .' layout.', 'nu_food' ),
                'section'     => 'archive_layout_section',
                'default'     => 'None',
                'choices'     => array(
                    'None'   => get_template_directory_uri() . '/assets/images/None.jpg',
                    'Left Side'   => get_template_directory_uri() . '/assets/images/Layout1.jpg',
                    'Right Side' => get_template_directory_uri() . '/assets/images/Layout2.jpg',
                    'Both'  => get_template_directory_uri() . '/assets/images/Layout3.jpg',
                ),
                'active_callback'    => array(
                    array(
                        'setting'  => 'post_type_select',
                        'operator' => '==',
                        'value'    => 'option-' . $post_type,
                    ),
                ) ,
            )
        );

    }

    if ( ! class_exists( 'Kirki' ) ) {
        return;
    }
    Kirki::add_field( 'post_type_select_field', array(
        'type'        => 'select',
        'settings'    => 'post_type_select',
        'label'       => esc_attr__( 'Post Type Select', 'kirki' ),
        'description' => esc_attr__( 'Post type selection.', 'kirki' ),
        'section'     => 'archive_layout_section',
        'multiple'    => 1,
        'default'     => 'option-1',
        'choices'     => $post_type_choices,
        'priority'    => 1,
    ) );
}

add_action( 'init', 'nu_food_post_type_select', 999 );