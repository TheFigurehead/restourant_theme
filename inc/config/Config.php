<?php

namespace North\Config;

class ThemeOptions{

    private static $headers = null;
    private static $styles = null;
    private static $scripts = null;

    public static function headers() {
        if (self::$headers == null) {
           self::$headers = array(
             'default' => 'Default header',
             'fixed' => 'Fixed header',
           );

        }
        return self::$headers;
    }

    public static function styles() {
        if (self::$styles == null) {
           self::$styles = array(
             'front' => array(
               array('nu-styles', '/assets/css/style.css', '0.0.1', array(), 'all'),
             ),
             'admin' => array(
               array('nu-admin-page-styles', '/assets/admin/css/admin.css', '0.0.2', array(), 'all'),
             ),
             // 'options' => array(
             //   'general' => array('nu-admin-page-styles', '/assets/admin/css/admin1.css', '0.0.1', array(), 'all'),
             //   'pages' => array(
             //     'top_level_name' => array('nu-admin-page-styles', '/assets/admin/css/admin2.css', '0.0.1', array(), 'all'),
             //   )
             // )
           );

        }
        return self::$styles;
    }

    public static function scripts() {
        if (self::$scripts == null) {
           self::$scripts = array(
             'front' => array(
               array('nu-scripts', '/assets/js/app.js', '0.0.1', array()),
             ),
             'admin' => array(
               // array('nu-admin-page-scripts', '/assets/admin/css/admin.css', '0.0.1', array(), 'all'),
             ),
             // 'options' => array(
             //   'general' => array('nu-admin-page-scripts', '/assets/admin/css/admin1.css', '0.0.1', array(), 'all'),
             //   'pages' => array(
             //     'top_level_name' => array('nu-admin-page-scripts', '/assets/admin/css/admin2.css', '0.0.1', array(), 'all'),
             //   )
             // )
           );

        }
        return self::$scripts;
    }

}
