<?php
add_action( 'wp_ajax_gears_login_form_submit', 'gears_login_form_submit' );

add_action( 'wp_ajax_nopriv_gears_login_form_submit', 'gears_login_form_submit' );

function gears_login_form_submit() {

	header('Content-Type: application/json');

	$message = array(
			'message' => __( 'error', 'gears' )
		);

	$signon = wp_signon();

	die( json_encode( $signon ) );

	return;
}
