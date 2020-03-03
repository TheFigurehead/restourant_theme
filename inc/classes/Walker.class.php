<?php
namespace North\App;

class Nu_Walker_Nav_Menu extends \Walker_Nav_Menu {
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output
	 * @param object $item Объект элемента меню, подробнее ниже.
	 * @param int $depth Уровень вложенности элемента меню.
	 * @param object $args Параметры функции wp_nav_menu
	 */

//	function start_el(&$output, $item, $depth = 0, $args, $id = 0) {
//		global $wp_query;
//    /*
//      * Some of the parameters of the object $ item
//      * ID - ID of the menu item itself, not the object to which it refers
//      * menu_item_parent - the ID of the parent menu item
//      * classes - array of menu item classes
//      * post_date - upload date
//      * post_modified - last modified date
//      * post_author - ID of the user who added this menu item
//      * title - the title of the menu item
//      * url - link
//      * attr_title - link to HTML attribute
//      * xfn is the rel attribute
//      * target - target attribute
//      * current - equal to 1, if there are current elements
//      * current_item_ancestor - is 1 if the current one is a nested element
//      * current_item_parent - equal to 1 if the current one is a nested element
//      * menu_order - order in the menu
//      * object_id - Menu object ID
//      * Type - the type of the menu object (taxonomy, post, arbitrary)
//      * object - what is the taxonomy / what type of post (page / category / post_tag and so on)
//      * type_label - name of this type with localization (Rubric, Page)
//      * post_parent - ID of the parent post / category
//      * post_title - the title that the post had when it was added to the menu
//      * post_name - the shortcut that the post had when it was added to the menu
//    */
//		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
//
//		/*
//		 * Generate a row with the CSS class of the menu item
//		 */
//		$class_names = $value = '';
//		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
//		$classes[] = 'menu-item-' . $item->ID;
//
//		// joined function turns an array into a string
//		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
//		$class_names = ' class="' . esc_attr( $class_names ) . '"';
//
//		/*
//		 * Generate the item ID
//		 */
//		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
//		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
//
//		/*
//		 * Generate the menu item
//		 */
//		$output .= $indent . '<li' . $id . $value . $class_names .'>';
//
//		// атрибуты элемента, title="", rel="", target="" и href=""
//		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
//		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
//		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
//		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
//
//		// link and surrounding text
//		$item_output = $args->before;
//		$item_output .= '<a'. $attributes .'>';
//		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
//		$item_output .= '</a>';
//		$item_output .= $args->after;
//
// 		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $item->ID );
//	}

        //=======================================//
            //SkyWalk
    //=======================================//

    // add classes to ul sub-menus
    function start_lvl( &$output, $depth ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
//            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // build html
        $output .= "\n" . $indent . '<div class="site-header-nav-list-item-dropdown"><ul class="' . $class_names . '">' . "\n";
    }

    // add main/sub classes to li's and links
    function start_el( &$output, $item, $depth = 0, $args, $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // depth dependent classes
        $depth_classes = array(
//            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth == 0 ? 'site-header-nav-list-item' : '' ),
//            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // build html
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );

        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }


}
