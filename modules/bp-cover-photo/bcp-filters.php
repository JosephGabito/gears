<?php
/**
 * Actions
 */

if (BCP_ENABLE_CUSTOMISE) 
{
	add_action('bp_before_member_header', 'bcp_member_customisation');
}
/**
 * BCP Member Customisation
 * 
 * adds css style via 'bp_before_member_header' action
 * to attach the styling the user has made into
 * his profile
 *
 * @package Gears
 * @since 2.0
 * @author dunhakdis
 */
function bcp_member_customisation()
{

	if ( function_exists('bcp_get_customisation_data') ) 
	{
		
		$customise = bcp_get_customisation_data();
		
		$solid = '';
			// disable gradient
			return;
		?>
		<style scoped id="bcp-customise">
		#item-header-avatar,#item-header-avatar-mobile{
			<?php if($customise->mode == 'gradient'){ ?>
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $customise->color2; ?>',endColorstr='<?php echo $customise->color2; ?>');
				background: -webkit-linear-gradient(<?php echo $customise->color1; ?> 0%,<?php echo $customise->color2; ?> 100%);
				background: -moz-linear-gradient(top,<?php echo $customise->color1; ?>, <?php echo $customise->color2; ?>);
				background: <?php echo $customise->color1; ?>
				<?php } else {
					$solid = '!important';
					} ?>
					background: <?php echo $customise->color1 . $solid; ?>
				}
				#item-header-avatar-mobile,
				#item-header-avatar-mobile #item-name h1 a{
					color: <?php echo $customise->foreground; ?>;
				}
				</style>
		<?php		
	}
	
	return;
}
?>