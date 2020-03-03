<h1><?php _e('Food theme settings', 'gidhome'); ?></h1>
<?php settings_errors(); ?>
<form id="submitForm" method="post" enctype="multipart/form-data" action="options.php" class="sunset-general-form">
	<div>
		<?php settings_fields( 'nu_food_section' ); ?>
	</div>
	<div>
		<?php settings_fields( 'nu_food_section_posts' ); ?>
	</div>
	<div>
		<?php settings_fields( 'nu_food_section_pagination' ); ?>
	</div>
	<?php do_settings_sections( 'nu_food_panel_general' ); ?>
	<?php submit_button( 'Save Changes', 'primary', 'btnSubmit' ); ?>
</form>
