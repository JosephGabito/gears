<?php
/**
 * 
 */
?>
<?php
$customise = bcp_get_customisation_data();
?>
<div class="customise-settings">
	<form class="form-horizontal" role="role" action="" method="post">
		<div class="form-group">
			<div class="col-sm-3 control-label"><h5><?php _e('Mode', 'gears'); ?></h5></div>
			<div class="col-sm-9">
				<div class="col-sm-3">
					<label for="bp-cover-photo-user-background-gradient">
						<input <?php if($customise->mode === 'gradient'){ echo 'checked'; }?> value="gradient" id="bp-cover-photo-user-background-gradient" type="radio" name="bp-cover-photo-user-background-mode" /> 
						<span class="small"><?php _e('Gradient', 'bp-cover-photo');?></span>
					</label>
				</div>	
				<div class="col-sm-9">
					<label for="bp-cover-photo-user-background-solid">
						<input <?php if($customise->mode === 'solid'){ echo 'checked'; }?> value="solid" id="bp-cover-photo-user-background-solid" type="radio" name="bp-cover-photo-user-background-mode" /> 
						<span class="small"><?php _e('Solid', 'bp-cover-photo');?></span>
						</label>
				</div>
			</div>
		</div>
		<!--gradient color a-->
		<div class="form-group">
			<label for="color-stop-1" class="col-sm-3 control-label"><?php _e('Color 1', 'gears'); ?> </label>
		    <div class="col-sm-9">
		    	
		      	<input name="color-stop-1" data-color="<?php echo $customise->color1; ?>" value="<?php echo $customise->color1; ?>" type="text" class="color-picker form-control" id="color-stop-1" />
		      	<p class="help-block break-row-top">
		      		<?php _e('This color will be used as the background color if the solid option is selected. 
		      		Otherwise, it will be used as the color stop 1 for the gradient option.','gears'); ?>
		      	</p>
		    </div>
 		</div>

 		<!--gradient color b-->
 		<div class="form-group">
			<label for="color-stop-2" class="col-sm-3 control-label"><?php _e('Color 2', 'gears'); ?></label>
		    <div class="col-sm-9">
		      	<input name="color-stop-2" data-color="<?php echo $customise->color2; ?>" value="<?php echo $customise->color2; ?>" type="text" class="color-picker form-control" id="color-stop-2" />
		      	<p class="help-block break-row-top">
		      		<?php _e('This color will serve as the color stop 2 if the gradient option is selected.','gears'); ?>
		      	</p>
		    </div>
 		</div>

 		<!--foreground-->
 		<div class="form-group">
			<label for="foreground" class="col-sm-3 control-label"><?php _e('Foreground', 'gears'); ?></label>
		    <div class="col-sm-9">
		      	<input name="foreground" data-color="<?php echo $customise->foreground; ?>" value="<?php echo $customise->foreground; ?>" type="text" class="color-picker form-control" id="foreground" />
		      	<p class="help-block break-row-top">
		      		<?php _e('The color of the text. Make sure it blends well with the background :).','gears'); ?>
		      	</p>
		    </div>
 		</div>

 		<div class="form-group">
		    <div class="col-sm-9 col-md-push-3">
		    	<?php wp_nonce_field('user-customisation-action', 'user-customisation'); ?>
		    	<input name="user-profile-customisation" type="submit" class="btn btn-success button" value="<?php _e('Save Customisation', 'gears'); ?>"/>
		    	<input name="user-profile-customisation-reset" type="submit" onclick="return confirm('Are you sure you want to reset your customisation?')"class="btn btn-danger button pull-right" value="<?php _e('Reset', 'gears'); ?>"/>
		    	<div class="clear"></div>
		    </div>
 		</div>
	</form>
	
</div>
<script>
jQuery(document).ready(function($){
	
	$.each($('input[data-color]'), function(key, value){
		$(this).css({
			'background': $(this).attr('data-color')
		});
	});

	$('.color-picker').iris({
		palletes: true,
		hide: false,
		border: false,
		change: function(event, ui){
			var text_element = $(event.target);
			var color = ui.color.toString();
			
			text_element.css({
				'background': color
			});
		}
	});
});
</script>