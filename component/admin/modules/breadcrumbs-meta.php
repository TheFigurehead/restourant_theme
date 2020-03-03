<blockquote>
  <?php _e('You can set up breadcrumbs for current page here. <br> Otherwise general settings will be used.'); ?>
</blockquote>

<?php
$post_type = get_post_type();
$taxonomies = get_object_taxonomies( $post_type, 'objects' );
$option_value = get_post_meta( get_the_ID(), '_post_breadcrumb_taxonomy', true );
nu_dump($option_value);
?>

<label for="post_breadcrumb_taxonomy"><?=$post_type->label?></label>
<select id="post_breadcrumb_taxonomy" name="post_breadcrumb_taxonomy" value="<?php echo esc_attr( $option_value ); ?>">
  <?php if(!empty($taxonomies)): ?>
    <?php foreach ($taxonomies as $key => $taxonomy): ?>
      <option value="<?=$taxonomy->name?>" <?php selected( $option_value, $taxonomy->name ); ?>><?=$taxonomy->label?> (<?=$taxonomy->name?>)</option>
    <?php endforeach; ?>
  <?php else: ?>
    <option value=""><?php _e('No taxonomy available', 'nu_food'); ?></option>
  <?php endif; ?>
</select>
