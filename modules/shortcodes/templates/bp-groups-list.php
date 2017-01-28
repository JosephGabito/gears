<?php
/**
 * BP Groups List Template
 *
 * This file renders the groups listing template for
 * gears groups list shortcode. To overwrite this template,
 * create a 'gears' directory inside your theme folder, copy this
 * file, and upload it inside the newly created 'gears' directory
 * 
 * @package    Gears
 * @subpackage Gears\Modules\Shortcodes
 * @version    1.0
 * @since  	   3.5
 */
extract( 
	shortcode_atts( array(
		'type' => 'active',
		'max_item' => 10,
		), $atts ) 
	);

$params = array(
	'type' => $type,
	'per_page' => $max_item
);
?>
<?php $output = ''; ?>
<?php if (function_exists('bp_has_groups')) { ?>
	<?php if (bp_has_groups($params)) { ?>
		<div class="clearfix">
			<ul class="bp-groups-list">
				<?php while (bp_groups()) { ?>
					<?php bp_the_group(); ?>
						<li class="clearfix bp-groups-list-item">
							<div class="group-item">
								<div class="group-avatar">
								<?php 
									$avatar_config = array(
										'type' => 'full', 
										'class' => 'avatar' 
									); 
								?>
								<?php echo bp_get_group_avatar($avatar_config); ?>
								</div>
								<div class="group-details">
									<h5>
										<a href="<?php echo esc_attr(bp_get_group_permalink()); ?>" title="<?php echo esc_attr(bp_get_group_name()); ?>">
											<?php echo esc_attr( bp_get_group_name()); ?>
										</a>
									</h5>
									<div class="meta small">
										<span class="activity">
											<?php echo bp_get_group_type() .'/'.  bp_get_group_member_count(); ?>
										</span>
									</div>
								</div>
							</div><!--.group-item-->
						</li>
				<?php } ?>
			</ul>
	    </div>	
	<?php }else{ ?>
		<div class="alert alert-info">
			<?php echo __( 'There are no groups to display. Please try again soon.', 'gears' ); ?>
		</div>
	<?php } ?>
	
	<?php echo $output ?>

<?php } else { ?>
	<?php echo $this->bp_not_installed; ?>
<?php } ?>