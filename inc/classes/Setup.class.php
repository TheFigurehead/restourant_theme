<?php

namespace North\App;

use North\Config\ThemeOptions as ThemeOptions;

class Setup{

    public function __construct()
    {
      add_action( 'init', array(&$this, 'register_menus' ) )  ;
    }

    public function register_menus(){
      add_theme_support( 'menus' );
      register_nav_menu( 'primary', __( 'Primary menu' ) );
    }

}
