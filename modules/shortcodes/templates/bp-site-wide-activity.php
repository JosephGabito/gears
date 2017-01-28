<?php
extract(
	shortcode_atts(
		array(
			'title' => ''
		), $atts
	)
);

if ( function_exists( 'bp_activity_directory_permalink' ) ) {

	$output = '';

	$params = array(
		'title' => $title
	); ?>

	<div class="gears-shortcode-element gears-bp-activity-stream gears-clearfix">
		
		<div class="buddypress directory">

		<h3>
			
			<?php echo esc_html__( $title ); ?>
			
		</h3>

		<?php bp_get_template_part( 'buddypress/activity/index' ); ?>

		</div>

	</div>

<?php

} else {

	return $this->bp_not_installed;
	
}

?>
<div class="gears-clearfix"></div>