<?php
// check if buddypres component is loaded
if ( ! function_exists( 'bp_has_groups' ) ) {

	return __('<div class="alert alert-warning">Oops! BuddyPress Groups Component is not currently enabled.</div>', 'gears');

}

extract(
	shortcode_atts( array(
		'type' => 'active',
		'max_item' => 10,
		'max_slides' => 7,
		'min_slides' => 1,
		'slide_margin' => 0,
		'item_width' => 100
	), $atts )
);

$params = array(
	'type' => $type,
	'per_page' => $max_item
);

$output = '';

if ( function_exists( 'bp_has_groups' ) ) {

	if ( bp_has_groups( $params ) ) { ?>

		<div class="clearfix gears-element bp-groups-carousel-wrap gears-shortcode-element">

			<ul data-slide-margin="<?php echo esc_attr( $slide_margin ); ?>" 
			data-max-slides="<?php echo esc_attr( $max_slides ); ?>"
			data-min-slides="<?php echo esc_attr( $min_slides ); ?>" 
			data-item-width="<?php echo esc_attr( $item_width ); ?>"
			data-slide-margin="<?php echo esc_attr( absint( $slide_margin ) ); ?>"
			
			class="gears-carousel-standard bp-groups-carousel">

				<?php while ( bp_groups() ) { ?>

					<?php 

					bp_the_group(); 

					$permalink = esc_url( bp_get_group_permalink() );
					
					$group_title = esc_attr( bp_get_group_name() );
					
					$member_count = intval( bp_get_group_member_count() );
					
					$last_active = sprintf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() );

					$content = $member_count . ' &middot; ' . $last_active;

					?>

					<li class="carousel-item gears-bp-groups-carousel center">
						
						<a class="group-title" href="<?php echo esc_url( $permalink ); ?>" 
						title="<?php echo esc_attr( $group_title ); ?>">

							<span class="groups-name">

								<?php echo esc_attr( $group_title ); ?>

								<span class="groups-count">
									
									<?php echo intval ( $member_count ) . ' '; 

										if ( 1 == $member_count ) {

											esc_html_e('Member', 'gears');

										} else {

											esc_html_e('Members', 'gears');

										}

									?>

								</span>

							</span>
						</a>

						<a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $group_title ); ?>">

							 <?php echo bp_get_group_avatar( array(	'type' => 'full' ) ); ?>

						</a>

					</li>

				<?php } // end while ?>

			</ul>

		</div>

		<?php } else { ?>

			<div class="alert alert-info">' 
				
				<?php esc_html_e( 'There are no groups to display at this time.', 'gears' ); ?>

			</div>

		<?php } ?>

<?php } else { ?>

	<?php echo $this->bp_not_installed; ?>

<?php } ?>
<div class="gears-clearfix"></div>