<?php
function nu_dump($array){
  echo "<pre style='background-color: #e6e6e6'>";
  var_dump($array);
  echo "</pre>";

}

function nu_get_style_attr( $theme_mod ){
  $styles = get_theme_mod( $theme_mod );
  $code = '';
  foreach ($styles as $key => $style) {
    switch ($key) {
      case "background-image":
        $code .= sprintf('%s:url(%s);', $key, $style);
        break;
      default:
        $code .= sprintf('%s:%s;', $key, $style);
    }
  }
  return $code;
}

function nu_pagination()
{
  global $wp_query;
  $data = array(
    'current' => max(1, get_query_var('paged')),
    'posts_per_page' => $wp_query->query_vars['posts_per_page'],
    'range' => (get_option('nu_food_section_pagination_range')) ? get_option('nu_food_section_pagination_range'): 2,
    'quantity' => $wp_query->found_posts
  );
  $args = nu_pagination_args($data);
  \North\App\Blunt\Blunt::showView('component/front/archive/pagination', $args);
}

function nu_breadcrumbs($data = array(
  'main_text' => 'Home'
)){

  $object = get_queried_object();
  $class;
  if(is_archive() && !is_author()){
    $class = 'Archive';
  }elseif(isset(get_queried_object()->taxonomy)){
    $class = 'Term';
  }elseif(isset($object)){
    $class = get_class($object);
  }else{
    $class = null;
  }

  \North\App\Blunt\Blunt::showView('component/front/modules/breadcrumbs', array('breads' => \North\App\Breadcrumbs::init($object, $class)));
}
