<?php

namespace North\App;

use North\Config\ThemeOptions as ThemeOptions;

class Admin{

    public function __construct()
    {
        add_action( 'admin_menu', array($this,'nu_food_add_admin_page') );
        add_action('admin_init', array($this,'nu_food_custom_settings') );
    }

    public function nu_food_add_admin_page() {

        //Generate Sunset Admin Page
        add_menu_page( 'Food theme options', 'Eat me theme', 'manage_options', 'nu_food_panel', array($this, 'nu_food_panel_general_page'), null, 110 );

        //Generate Sunset Admin Sub Pages
        add_submenu_page( 'nu_food_panel', 'Eat me General', 'General', 'manage_options', 'nu_food_panel', array($this, 'nu_food_panel_general_page') );
        add_submenu_page( 'nu_food_panel', 'Eat me Theme', 'Support', 'manage_options', 'nu_food_panel_theme', array($this, 'nu_food_support_page') );
//        add_submenu_page( 'nu_food_panel', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'nu_food_panel_theme_contact', 'nu_food_contact_form_page' );
//        add_submenu_page( 'nu_food_panel', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'nu_food_panel_css', 'nu_food_settings_page');

    }

    public function nu_food_custom_settings() {
        add_settings_section( 'nu_food_section', __('Header settings', 'nu_food'), null, 'nu_food_panel_general' );
        add_settings_field( 'nu_food_section_select', __('Type of header', 'nu_food'), array($this, 'nu_food_section_select'), 'nu_food_panel_general', 'nu_food_section' );
        register_setting( 'nu_food_section', 'nu_food_section_select', array( 'default' => 'default') );
        add_settings_section( 'nu_food_section_posts', __('Posts settings', 'nu_food'), null, 'nu_food_panel_general' );
        add_settings_field( 'nu_food_section_posts_teaser_length', __('Teaser length (words)', 'nu_food'), array($this, 'nu_food_section_posts_teaser_length'), 'nu_food_panel_general', 'nu_food_section_posts' );
        register_setting( 'nu_food_section_posts', 'nu_food_section_posts_teaser_length', array( 'default' => 25) );
        add_settings_field( 'nu_food_section_posts_read_more', __('Teaser Read more link text', 'nu_food'), array($this, 'nu_food_section_posts_read_more'), 'nu_food_panel_general', 'nu_food_section_posts' );
        register_setting( 'nu_food_section_posts', 'nu_food_section_posts_read_more', array( 'default' => 'Read more &rarr;') );
        add_settings_field( 'nu_food_section_posts_date', __('Type of date showed in post', 'nu_food'), array($this, 'nu_food_section_posts_date'), 'nu_food_panel_general', 'nu_food_section_posts' );
        register_setting( 'nu_food_section_posts', 'nu_food_section_posts_date', array( 'default' => 'created') );
        add_settings_section( 'nu_food_section_pagination', __('Pagination settings', 'nu_food'), null, 'nu_food_panel_general' );
        add_settings_field( 'nu_food_section_pagination_range', __('Quantity of pages before/after current', 'nu_food'), array($this, 'nu_food_section_pagination_range'), 'nu_food_panel_general', 'nu_food_section_pagination' );
        register_setting( 'nu_food_section_pagination', 'nu_food_section_pagination_range', array( 'default' => 2) );
      }

    public function nu_food_section_select() {
      $headers = ThemeOptions::headers();
      if(!empty($headers)){
      ?>
          <select name="nu_food_section_select">
            <?php foreach ($headers as $key => $header): ?>
              <option value="<?php echo $key; ?>" <?php selected(get_option('nu_food_section_select'),$key); ?>><?php echo $header; ?></option>
            <?php endforeach; ?>
          </select>
          <?php
        }
        else{
          echo "No headers specified.";
        }
    }

    public function nu_food_section_posts_date() {
      $options = array(
        'created' => __('Post created', 'nu_food'),
        'updated' => __('Post updated', 'nu_food'),
      );
      ?>
        <select name="nu_food_section_posts_date">
          <?php foreach ($options as $key => $option): ?>
            <option value="<?php echo $key; ?>" <?php selected(get_option('nu_food_section_posts_date'),$key); ?>><?php echo $option; ?></option>
          <?php endforeach; ?>
        </select>
        <?php
    }

    public function nu_food_section_posts_teaser_length(){
      ?>
      <input id="nu_food_section_posts_teaser_length" type="number" name="nu_food_section_posts_teaser_length" value="<?php echo get_option('nu_food_section_posts_teaser_length'); ?>">
      <?php
    }

    public function nu_food_section_posts_read_more(){
      ?>
      <input id="nu_food_section_posts_read_more" type="text" name="nu_food_section_posts_read_more" value="<?php echo get_option('nu_food_section_posts_read_more'); ?>">
      <?php
    }

    public function nu_food_section_pagination_range(){
      ?>
      <input id="nu_food_section_pagination_range" type="text" name="nu_food_section_pagination_range" value="<?php echo get_option('nu_food_section_pagination_range'); ?>">
      <?php
    }

    public function nu_food_panel_general_page(){
        require_once( get_template_directory() . '/component/admin/nu_food-admin.php' );
    }

    public function nu_food_support_page(){
      echo "nu_food_support_page";
    }

    public function nu_food_contact_form_page(){
        echo "nu_food_contact_form_page";
    }

    public function nu_food_settings_page(){
        echo "nu_food_settings_page";
    }

}
