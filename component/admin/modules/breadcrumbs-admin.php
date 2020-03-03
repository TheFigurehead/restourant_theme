<div class="wrap">
  <h1><?php _e( 'Breadcrumbs', 'nu_food' ); ?></h1>
  <form method="post" action="options.php">
    <?php settings_fields( 'breadcrumbs-options' ); ?>
    <?php do_settings_sections( 'breadcrumbs-options' ); ?>
    <?php $post_types = get_post_types( array(
      'hierarchical' => false, 'public' => true
    ), 'objects' );
    foreach ($post_types as $key => $post_type):
      $taxonomies = get_object_taxonomies( $post_type->name, 'objects' );
      $option_value = get_option('select_taxonomy_' . $key);
    ?>
    <div class="">
      <label for="<?php echo 'select_taxonomy_' . $key; ?>"><?=$post_type->label?></label>
      <select id="<?php echo 'select_taxonomy_' . $key; ?>" name="<?php echo 'select_taxonomy_' . $key; ?>" value="<?php echo esc_attr( $option_value ); ?>">
        <?php if(!empty($taxonomies)): ?>
          <?php foreach ($taxonomies as $key => $taxonomy): ?>
            <option value="<?=$taxonomy->name?>" <?php selected( $option_value, $taxonomy->name ); ?>><?=$taxonomy->label?> (<?=$taxonomy->name?>)</option>
          <?php endforeach; ?>
        <?php else: ?>
          <option value=""><?php _e('No taxonomy available', 'nu_food'); ?></option>
        <?php endif; ?>
      </select>
    </div>
    <?php endforeach; ?>
    <?php submit_button(); ?>
  </form>
</div>
