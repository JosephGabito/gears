<?php
$default_columns = '3-columns'; // 3 Columns.
		
$allowed_columns = array(
		'2-columns',
		'3-columns',
		'4-columns',
		'6-columns'
	);

extract(
	shortcode_atts( array(
		'type' => 'active',
		'max_item' => 10,
		'columns' => $default_columns
	), $atts )
);

$assigned_columns = array(
		'2-columns' => 6,
		'3-columns' => 4,
		'4-columns' => 3,
		'6-columns' => 2
	);

$columns = absint( $assigned_columns[ $columns ] );

// Ensure that columns is scalable.
if ( !in_array( $columns, $allowed_columns ) ) {
	// default to default columns settings, just in case
	$columns = $default_columns;
}

$columns_classes = 'col-md-'.$columns.' col-sm-'.$columns.' col-xs-6';

$params = array(
	'type' => $type,
	'per_page' => $max_item
);

$output = '';


if ( function_exists( 'bp_has_groups' ) ){
	
	if ( bp_has_groups( $params ) ) { ?>

		<div class="gears-shortcode-element gears-bp-groups-grid-wrap">

			<ul class="gears-bp-groups-grid gears-clearfix">

				<?php while( bp_groups() ){ ?>

				<?php bp_the_group(); ?>

					<li class="bp-groups-grid-item <?php echo $columns_classes; ?>">

						<?php $name = bp_get_group_name(); ?>
						
						<?php $permalink = bp_get_group_permalink(); ?>
						
						<?php $last_active = bp_get_group_last_active(); ?>
						
						<?php $members_count = bp_get_group_member_count(); ?>
						
						<?php $modal_content = esc_attr($members_count . ' &middot; ' . __('Active ','gears') . $last_active . ''); 

						?>

						<a title="<?php echo esc_attr($name); ?>" href="<?php echo esc_url($permalink); ?>">

							<span class="groups-name">

								<?php echo esc_html__( $name );?>

									<span class="groups-count">

										<?php echo intval( $members_count ); ?>

										<?php if ( 1 == $members_count ) { ?>

											<?php esc_html_e('Member', 'gears'); ?>

										<?php } else { ?>

											<?php esc_html_e('Members', 'gears'); ?>

										<?php } ?>

									</span>

							</span>

						</a>

						<a title="<?php echo esc_attr($name); ?>" href="<?php echo esc_url($permalink); ?>">
							
							<?php echo bp_get_group_avatar( array(	'type' => 'full' ) ); ?>

						</a>

					</li>

				<?php } ?>

			</ul>
			
			<div class="gears-clearfix"></div>

		</div><!--.gears-shortcode-element-->

<?php } else { ?>
		
		<div class="alert alert-info">
			
			<?php esc_html_e( 'There are no groups to display. Please try again soon.', 'gears' ); ?>

		</div>

	<?php } ?>

<?php

} else {
	echo $this->bp_not_installed;
}

?>
<div class="gears-clearfix"></div>