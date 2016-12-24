<?php

$output = '';
		
$default_columns = 3; // 4 columns

$allowed_columns = array(2, 3, 4, 6);

extract(
	shortcode_atts( array(
		'type' => '',
		'max_item' => 10,
		'columns' => $default_columns // allowed 2, 3, 4, 6
	), $atts )
);

$columns = floor( 12 / $columns );


// catch invalid columns
if ( ! in_array( $columns, $allowed_columns ) ) {
	$columns = $default_columns;
}

// available columns are  2, 3, 4, and 6
$columns_classes = sprintf( ' col-md-%d col-sm-%d col-xs-6', $columns, $columns );

$params = array(
	'type' => $type,
	'per_page' => $max_item
);

if ( function_exists( 'bp_has_members' ) ) {

	if ( bp_has_members( $params ) ) { ?>
		
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

	<?php } ?>
	

<?php 
} else { 
	echo $this->bp_not_installed;
}
?>