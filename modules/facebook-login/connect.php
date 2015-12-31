<?php
/**
 * The handler for our Facebook Connect API
 *
 * @package  klein
 * @version  2
 */

defined( 'ABSPATH' ) || exit;

if ( version_compare( PHP_VERSION, '5.4.0', '<') ) {

  die( 'Facebook Connect SDK requires PHP 5.4 or higher. 
  		Please contact your hosting provider and kindly 
  		tell them to update the PHP for your hosting. Thank you.' );

}

require_once GEARS_APP_PATH . 'modules/facebook-login/src/Facebook/autoload.php';

if ( isset( $_GET['callback'] ) ) {

	require_once GEARS_APP_PATH . 'modules/facebook-login/callback.php';


} else {

	$fb = new Facebook\Facebook([
  		'app_id' => $this->appID,
  		'app_secret' => $this->appSecret,
  		'default_graph_version' => 'v2.2',
 	]);

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email', 'public_profile']; // optional
	$loginUrl = $helper->getLoginUrl( admin_url( 'admin-ajax.php?action=gears_fb_connect&callback=true' ), $permissions );

	header( "location: ". $loginUrl );
}