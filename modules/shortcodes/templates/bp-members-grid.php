<?php
$default_columns = "3-columns"; // 3 columns

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

$columns_classes = sprintf( ' col-md-%d col-sm-%d col-xs-6', $columns, $columns );

$params = array(
	'type' => $type,
	'per_page' => $max_item
);

if ( function_exists( 'bp_has_members' ) ) {

	if ( bp_has_members( $params ) ) { ?>
	
	<div class="gears-clearfix gears-shortcode-element bp-members-grid">

		<ul class="ul-bp-members-grid">
			<?php
			while( bp_members() ) {

				bp_the_member();

				$name = bp_get_member_name();

				$permalink = bp_get_member_permalink();

				$last_active = bp_get_member_last_active();

				$status_update = "";

					$members_status_update = bp_get_member_latest_update();

					if ( ! empty( $members_status_update ) ) {

						$status_update = $members_status_update;

					}

					$content = '<p>'.$status_update.'</p><p>'.$last_active.'</p>';
				?>

				<li class="bp-members-grid-item <?php echo $columns_classes; ?>">

					<div class="gears-bp-members-grid">

						<a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $name );?>">

							<span class="members-name">

								<?php echo esc_html( $name );?>
									
							</span>

						</a>

						
						<a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $name );?>">
							
							<?php echo bp_get_member_avatar( array('type' => 'full', 'class' => 'avatar') ); ?>

						</a>

					</div>

				</li>

			<?php } ?>

		</ul>
	
	</div><!--.gears-shortcode-element-->
	<div class="gears-clearfix"></div>
	<?php } ?>
	

<?php 
} else { 
	echo $this->bp_not_installed;
}
?>