<?php

namespace North\App;

class Breadcrumbs{

  public function __construct(){
    add_action( 'admin_init', array( $this, 'register_breadcrumbs_setting' ) );
    add_action( 'admin_menu', array( $this, 'register_breadcrumbs_menu_page' ) );
    add_action( 'add_meta_boxes', array( $this, 'setPostMeta' ) );
    add_action( 'save_post', array( $this, 'savePostMeta' ) );
    add_filter( 'option_page_capability_breadcrumbs-options', array( $this, 'breadcrumbs_capability' ) );
  }

  public function register_breadcrumbs_menu_page() {
    add_menu_page(
        __( 'Breadcrumbs', 'nu_food' ),
        __( 'Breadcrumbs', 'nu_food' ),
        'manage_options',
        'nu_breadcrumbs',
        array( $this, 'admin_page'),
        plugins_url( 'myplugin/images/icon.png' ),
        6
    );
  }

  public function register_breadcrumbs_setting() {
    $post_types = get_post_types( array(
      'hierarchical' => false
    ) );
    foreach ($post_types as $key => $post_type) {
      switch($post_type){
        case "post":
          $args = array( 'default' => 'category');
          break;
        default:
          $args = array();
      }
      register_setting( 'breadcrumbs-options', 'select_taxonomy_' . $key );
    }
  }

  public function breadcrumbs_capability( $capability ) {
    return 'edit_others_posts';
  }

  public function admin_page(){
    get_template_part('component/admin/modules/breadcrumbs', 'admin');
  }

  public function setPostMeta(){
      $screens = get_post_types( array( 'public' => true ), 'names' );
      add_meta_box( 'breadcrumbs_meta', __('Breadcrumbs', 'gidhome'), array( $this, 'postMetaCallback' ), $screens );
  }

  function postMetaCallback( $post, $meta ){
  	$screens = $meta['args'];

  	// Используем nonce для верификации
  	wp_nonce_field( plugin_basename(__FILE__), 'post_breadcrumb_taxonomy' );

    get_template_part('component/admin/modules/breadcrumbs', 'meta');

  }

  public function savePostMeta( $post_id ) {
  	// Убедимся что поле установлено.
    $field_name = 'post_breadcrumb_taxonomy';
  	if ( ! isset( $_POST[$field_name] ) )
  		return;

  	// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
  	if ( ! wp_verify_nonce( $_POST[$field_name], plugin_basename(__FILE__) ) ){
      return;
    }

  	// если это автосохранение ничего не делаем
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
  		return;

  	// проверяем права юзера
  	if( ! current_user_can( 'edit_post', $post_id ) )
  		return;

  	// Все ОК. Теперь, нужно найти и сохранить данные
  	// Очищаем значение поля input.
  	$taxonomy = sanitize_text_field( $_POST[$field_name] );

  	// Обновляем данные в базе данных.
  	update_post_meta( $post_id, '_post_breadcrumb_taxonomy', $taxonomy );
  }

  public static function init( $object, $class ){

    switch ($class) {
      case "Archive":
          $result = self::typeArchive( $object );
          break;
      case "Term":
          $result = self::typeTerm( $object );
          break;
      case "WP_Post":
          $result = self::typeWP_Post( $object );
          break;
      case "WP_User":
          $result = self::typeWP_User( $object );
          break;
      default:
          $result = self::typeUndefined( $object );
          break;

    }

    return $result;
  }

  private function typeArchive(){
    return "Archive";
  }

  private function typeTerm(){
    return "Term";
  }

  private function typeWP_Post( $object ){
    $list = array();
    $list[]  = self::createPostBreadObject( $object->ID );
    if( is_singular( $object->post_type ) ){
      if( is_post_type_hierarchical( $object->post_type ) ){
        $list = self::generateHierarchicalList( $list, $object->ID );
      }else{
        $option = get_option('select_taxonomy_' . $object->post_type);
        if($option){
          $taxonomy = $option;
        }else{
          $taxonomy_objects = get_object_taxonomies( get_post_type( $object->ID ) );
          $taxonomy = $taxonomy_objects[0]->name;
        }
        $terms = wp_get_post_terms( $object->ID, $taxonomy, array( 'hierarchical' => true ) );
        nu_dump($terms);
        $list = self::generateNonHierarchicalList( $list, $terms, 0 );
      }
      $list[] = self::createPostBreadObject( intval( get_option( 'page_on_front' ) ) );
      return array_reverse( $list );
    }else{
      return "Undefined";
    }
  }

  private function generateHierarchicalList( $list, $id ){
    if($parent_id = wp_get_post_parent_id( $id )){
      $list[] = $this->createPostBreadObject( $parent_id );
      return $this->generateHierarchicalList( $list, $parent_id );
    }else{
      return $list;
    }
  }

  private function generateNonHierarchicalList( $list, $terms, $parent ){
    $current_term = self::returnTermByParent($terms, $parent)[0];
    if($current_term){
      $list[] = $current_term;
      return self::generateNonHierarchicalList( $list, $terms, $current_term->term_id );
    }else{
      return $list;
    }
  }

  private function returnTermByParent($terms, $parent){
    return array_filter($terms, function($element) use ($parent) { return ( $element->parent == $parent);});
  }

  private function typeWP_User( $object ){
    $list = array();
    $list[] = self::createUserBreadObject( $object->ID );
    $list[] = self::createPostBreadObject( intval( get_option( 'page_on_front' ) ) );
    return array_reverse( $list );
  }

  private function typeUndefined(){
    return "Undefined";
  }

  private function createPostBreadObject( $id ){
    return array(
      'link' => get_permalink( $id ),
      'title' => get_the_title( $id ),
      'classes' => 'bread-' . $id
    );
  }

  private function createUserBreadObject( $id ){
    $user_nicename = get_the_author_meta( 'user_nicename', $id );
    return array(
      'link' => get_author_posts_url( get_the_author_meta( 'ID', $id ), $user_nicename ),
      'title' => $user_nicename,
      'classes' => 'bread_author-' . $id
    );
  }

}
