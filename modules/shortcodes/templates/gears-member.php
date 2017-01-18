<?php
/**
 * Gears Members Template File
 *
 * This file renders the template for 'Gears Members Shortcodes'.
 * 
 * @package    Gears
 * @subpackage Gears\Modules\Shortcodes
 * @version    1.0
 * @since  	   4.1.1
 */
extract( 
	shortcode_atts( array(
		'team_member_avatar_url' => '',
		'team_member_website' => '#',
		'team_member_name' => '',
		'team_member_identification' => '',
		), $atts ) 
	);

?>

<div class="gears-shortcode-element gears-clearfix <?php echo esc_attr( $css_class ); ?>">
	<div class="gears-shortcode-element gears-team-element-wrap gears-clearfix">
		<div class="gears-team-element">
			<div class="gears-team-element-item">

				<div class="user-avatar">
				
					<?php if ( function_exists( 'vc_build_link' ) ) { ?>
						<?php $team_member_website = vc_build_link( $team_member_website ); ?>
						<?php $team_member_website = $team_member_website['url']; ?>
					<?php } ?>

					<a href="<?php echo esc_url( $team_member_website ); ?>" title="<?php echo esc_attr( $team_member_name ); ?>">
						
						<?php if ( ! empty( $team_member_avatar_url ) ) { ?>

							<?php // Visual Composer vc_map 'vc_image' ready. ?>
							
							<?php if ( is_numeric( $team_member_avatar_url ) ) { ?>
							
								<?php echo wp_get_attachment_image( absint( $team_member_avatar_url ), array( '350', '350'), "", array( "class" => "gears-user-avatar" ) ); ?>
							
							<?php } else { ?>
							
								<img class="gears-user-avatar" src="<?php echo esc_url( $team_member_avatar_url ); ?>" alt="<?php echo esc_attr( $team_member_name ); ?>">
							
							<?php } ?>

						<?php } ?>	
					</a>
				</div>
				<div class="user-details">
					<div class="user-details-name">
						<?php if ( ! empty( $team_member_name ) ) { ?>
							<h3>
								<a href="<?php echo esc_url( $team_member_website ); ?>" title="<?php echo esc_attr( $team_member_name ); ?>">
									<?php echo esc_html( $team_member_name ); ?>
								</a>
							</h3>
						<?php } ?>
					</div>
					<div class="user-details-title">
						<span class="user-details-title-scope">
							<?php echo esc_html($team_member_identification); ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>