<?php

$args = array('echo' => false);

?>

<?php if ( ! is_user_logged_in() ) { ?>
	
<div class="gears-login-wrap">

	<div class="gears-login-links">

		<ul>
			
			<li class="current">

				<?php _e('Sign in', 'gears'); ?>

			</li>
			
			<li>

				<a href="<?php echo wp_registration_url(); ?>" title="<?php _e('Create New Account','gears'); ?>">

					<?php _e('Create New Account', 'gears'); ?>

				</a>

			</li>

		</ul>

	</div><!--.gears-login-links-->

	<div class="gears-login well">

		<?php echo wp_login_form( $args ); ?>

	</div><!--.gears-login-->

</div><!--.gears-login-wrap-->
<div class="gears-clearfix"></div>

<?php } ?>