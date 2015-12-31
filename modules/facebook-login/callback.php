<?php
/**
 * Facebook Callback Handler
 *
 * @since 1.0
 */

$fb = new Facebook\Facebook([
  		'app_id' => $this->appID,
  		'app_secret' => $this->appSecret,
  		'default_graph_version' => 'v2.2',
 	]);

$helper = $fb->getRedirectLoginHelper();

try {
	
	$accessToken = $helper->getAccessToken();

} catch( Facebook\Exceptions\FacebookResponseException $e ) {

	// When Graph returns an error
	wp_safe_redirect( wp_login_url().'?error=true&type=fb_error' );

	exit;

} catch( Facebook\Exceptions\FacebookSDKException $e ) {

	// When validation fails or other local issues
	wp_safe_redirect( wp_login_url().'?error=true&type=app_not_live' );

	exit;
}

if ( isset( $accessToken ) ) {

  	// Logged in!
  	$_SESSION['facebook_access_token'] = (string) $accessToken;

  	$fb->setDefaultAccessToken( $accessToken );

  	$user_first_name = '';
  	$user_email = '';
  	$user_last_name = '';
  	$user_id = '';

	try {
	  	
	  	$response = $fb->get('/me?fields=id,name,email,first_name,last_name');
	  	$user = $response->getGraphUser();

	  	if ( !isset( $user['email'] ) ) {

	  		wp_safe_redirect( wp_login_url().'?error=true&type=fb_invalid_email' );

	  		die();
	  	}

	  	$user_email = $user['email'];
	  	$user_id = $user['id'];
	  	$user_name = $user['name'];
	  	$user_first_name = $user['first_name'];
	  	$user_last_name = $user['last_name'];


	} catch( Facebook\Exceptions\FacebookResponseException $e ) {

	  	// When Graph returns an error
	  	echo 'Graph returned an error: ' . $e->getMessage();

	  	exit;

	} catch( Facebook\Exceptions\FacebookSDKException $e ) {

	  	// When validation fails or other local issues
	  	echo 'Facebook SDK returned an error: ' . $e->getMessage();

	  	exit;
	}

	// Register the user.
	if ( empty( $user_email ) ) {

		session_destroy();

		wp_safe_redirect(wp_login_url().'?error=true&type=fb_invalid_email');

		return;
	}

	if ( ! empty( $user_last_name ) || ! empty( $user_first_name ) ) {

		$proposed_username = sanitize_title( sprintf('%s-%s', $user_first_name, $user_last_name ) );

		$user_id_by_email = email_exists( $user_email );

		if ( $user_id_by_email ) {
			
			$user = get_user_by( 'id', $user_id_by_email );

			if ( $user ) {

				wp_set_auth_cookie ( $user->ID );

				// if buddypress is enabled redirect to its profile
				if ( function_exists( 'bp_loggedin_user_domain' ) ) {			
					wp_safe_redirect( bp_core_get_user_domain( $user->ID ) );
				} else {
					// else just redirect to homepage
					wp_safe_redirect( get_bloginfo( 'url' ) );
				}

			} else {

				wp_safe_redirect( home_url() );
				
			}
		} else {

			// Create the user if does not exists

			// Find available username.
			$username = $this->sanitizeUserName( $proposed_username, $index = 1, $copy = $proposed_username );
			
			// Create the user.
			$password = wp_generate_password( $length = 12, $include_standard_special_chars = false );

			$new_userid = wp_create_user( $username, $password, $user_email );

			if ( is_numeric( $new_userid ) ) {

				//email the user his credentials
				wp_new_user_notification( $new_userid, $deprecated = null, $notify = 'both' );

				wp_set_auth_cookie ( $new_userid );

				wp_update_user(
					array(
						'ID' => $new_userid,
						'display_name' => $user_name,
						)
					);
						// update buddypress profile
				if ( function_exists( 'xprofile_set_field_data' ) ) {
					xprofile_set_field_data('Name', $new_userid, $user_name);
				}

				if ( function_exists( 'bp_loggedin_user_domain' ) ) {
					wp_safe_redirect( bp_core_get_user_domain( $new_userid ) );
				} else {
					//else just redirect to back to homepage
					wp_safe_redirect( get_bloginfo( 'url' ) );
				}

			} else {

				session_destroy();
				wp_safe_redirect( wp_login_url() . '?error=true&type=gears_username_or_email_exists');
				
				return;
			}

		}

	} else {

		// User don't have first name and last name of Facebook.
		session_destroy();

		wp_safe_redirect(wp_login_url().'?error=true&type=fb_error');
		
		return;
	}

} else {

	session_destroy();

	wp_safe_redirect(wp_login_url().'?error=true&type=fb_error');
		
	return;

}