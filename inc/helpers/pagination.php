<?php

function nu_pagination_args($data){
  $current = ($data['current']) ? $data['current'] : 1;
  $posts_per_page = ($data['posts_per_page']) ? $data['posts_per_page'] : get_option( 'posts_per_page' );
  $range = ($data['range']) ? $data['range'] : 2;
  $quantity = $data['quantity'];

  $total = ceil($quantity / $posts_per_page);

  $args = array();

  if($current > 1){
    $args['prev'] =
      array(
        'link' => get_pagenum_link($current - 1)
      );
  }

  if($total > $current){
    $args['next'] =
      array(
        'link' => get_pagenum_link($current + 1)
      );
  }

  $start_point = ($current - $range >= 1) ? $current - $range : 1;
  $end_point = ($current + $range <= $total) ? $current + $range : $total;

  if($start_point > 1){
    $args['first'] = array(
      'number' => 1,
      'link' => get_pagenum_link(1)
    );
  }

  $args['show_prev_points'] = ($start_point > 2) ? true : false;

  if($end_point < $total){
    $args['last'] = array(
      'number' => $total,
      'link' => get_pagenum_link($total)
    );
  }

  $args['show_next_points'] = ( $total > $end_point + 1) ? true : false;

  for($i = $start_point; $i <= $end_point; $i++){
    $args['pages'][] = array(
      'number' => $i,
      'link' => get_pagenum_link($i),
      'active' => ($i == $current) ? true : false
    );
  }

  return $args;
}
