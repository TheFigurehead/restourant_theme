<?php

namespace North\App;

use North\Config\ThemeOptions as ThemeOptions;

class Enqueue{

    public function __construct()
    {
        $this->styles = ThemeOptions::styles();
        $this->scripts = ThemeOptions::scripts();

        add_action('wp_enqueue_scripts', array($this, 'nu_head_enqueue_scripts'));
        add_action('wp_footer', array($this, 'nu_footer_enqueue_scripts'));

        /* Admin page */
//        add_action('admin_enqueue_scripts', array($this, 'nu_admin_enqueue'));
    }


    /* Only Head Scripts */
    public function nu_head_enqueue_scripts()
    {
        /* Front Head Scripts */
        wp_enqueue_script( 'nu-header', get_template_directory_uri() . '/assets/js/nu-header.js', array() , '0.0.1', false );
        wp_enqueue_style( 'nu_style', get_stylesheet_uri(), array(), '0.0.1', 'all' );

        /* Front Head Styles */
        if($front = $this->styles['front']){
          foreach ($front as &$style) {
            wp_enqueue_style($style[0], get_template_directory_uri() . $style[1], $style[2], $style[3], $style[4]);
          }
        }

        /* Script Styles */
        if($front = $this->scripts['front']){
          foreach ($front as &$script) {
            wp_enqueue_script( $script[0], get_template_directory_uri() . $script[1], $script[2], $script[3], true );
          }
        }

    }

    /* Only footer scripts */
    public function nu_footer_enqueue_scripts()
    {
        wp_enqueue_script('nu-footer', get_template_directory_uri() . '/assets/js/nu-footer.js', array() , '0.0.1', true);
    }

    /* Admin enqueue */
    public function nu_admin_enqueue( $hook )
    {


        if($admin = $this->styles['admin'])
      {
        foreach ($admin as &$style) {
          wp_enqueue_style($style[0], get_template_directory_uri() . $style[1], $style[2], $style[3], $style[4]);
        }
      }

      /* Script Styles */
//      if($admin = $this->scripts['admin']){
//        foreach ($front as &$script) {
//          wp_enqueue_script( $script[0], get_template_directory_uri() . $script[1], $script[2], $script[3], true);
//        }
//      }
      // if(){
      //
      // }
        // switch ($hook)
        // {
        //     case 'toplevel_page_nu_food_panel':
        //
        //         /* Theme Option Scripts */
        //         wp_enqueue_script('nu-option-page', get_template_directory_uri() . '/assets/admin/js/nu-option-page.js', array(), '0.0.1', false);
        //
        //         /* Theme Option Styles */
        //         wp_enqueue_style( 'nu-option-page-styles', get_template_directory_uri() . '/assets/admin/css/nu-admin.css', array(), '0.0.1', 'all' );
        //
        //     default:
        //
        //         /* Admin Panel Scripts */
        //         wp_enqueue_script('nu-admin', get_template_directory_uri() . '/assets/admin/js/nu-admin.js', array(), '0.0.1', false);
        //
        //         /* Admin Panel Styles */
        //         wp_enqueue_style( 'nu-admin-styles', get_template_directory_uri() . '/assets/admin/css/admin.css', array(), '0.0.1', 'all' );
        //
        // }

    }

}
