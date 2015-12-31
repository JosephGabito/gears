<?php
/**
 * Gears
 *
 * @since 1.0
 */

// Exit if accessed directly
if (!defined( 'ABSPATH' )) exit;


if (!class_exists('Gears'))
{
	class Gears {
	
		/**
		 * initialize plugin modules, admin styles, and buddypress setup
		 */ 
		function __construct() {
		    
			// modules
			add_action('init', array($this,'load_modules'));

			// front-end stylesheet
			add_action('wp_enqueue_scripts', array($this, 'stylesheet'));
			
			// admin stylesheets	
			add_action('admin_init', array( $this, 'admin_styles' ));
			
			// BuddyPress config
			add_action('bp_init', array($this, 'bp_setup'), 0); 

			return;
		}
		
		/**
		 * Loads the stylehsheet
		 */
		public function stylesheet()
		{
		    
		    wp_enqueue_style( 'gears-stylesheet', plugins_url('assets/style.css', __FILE__), array(), 1 );
		    
    		return $this;
		}
		
		/**
		 * Includes all the files needed to kick-start the modules
		 */
		public function load_modules(){
			
			$coverPhotoEnabled = apply_filters('gears_cover_photo', '__return_true', 10, 1);
			
			if ( $coverPhotoEnabled ) {
				// load bp cover photo
				require_once GEARS_APP_PATH . '/modules/bp-cover-photo/index.php';
			}
			

			// load google plus connect
			require_once GEARS_APP_PATH . '/modules/google-login/index.php';

			// load the shortcodes
			require_once GEARS_APP_PATH . '/modules/shortcodes/library.php'; new Gears_Shortcodes();

			// Google+ Connect
			if (!is_user_logged_in() && get_option('users_can_register')) {

				if (function_exists('curl_version')) {

					$google_connect = new GearsGooglePlusConnect();
					
				}
			}

			// Facebook Connect
			$is_ce_module_facebook_login_enabled = apply_filters('gears_is_fb_enabled', $this->ot_theme_option( 'is_fb_enabled' ));

			if( !is_user_logged_in() && $is_ce_module_facebook_login_enabled && get_option('users_can_register') ){
			
				// if facebook login is enabled
				// require the essential plugin
				// we need to check if there is curl installed/activated in the server
				// added in 2.1.0
				if ( function_exists('curl_version') ) {

					/*
					// Instantiate the module
					new GEARS_MODULES_FACEBOOK_LOGIN(
						$app_id = $this->ot_theme_option( 'application_id', '' ),
						$app_secret = $this->ot_theme_option( 'application_secret', '' ),
						$registrant_settings = $this->ot_theme_option( 'registrant_setting', 'not_unique' ),
						$button_label = $this->ot_theme_option( 'gears_fb_btn_label' , __('Connect w/ Facebook','gears') )
					);*/
					
					require_once GEARS_APP_PATH . '/modules/facebook-login/index.php';

					$app_id = apply_filters( 'gears_fb_app_id', $this->ot_theme_option( 'application_id', '' ) );
					$app_secret = apply_filters( 'gears_fb_app_secret', $this->ot_theme_option( 'application_secret', '' ) );
					$registrant_settings = apply_filters( 'gears_register_settings', $this->ot_theme_option( 'registrant_setting', 'not_unique' ) );
					$button_label = apply_filters ( 'gears_button_label', $this->ot_theme_option( 'gears_fb_btn_label' , __('Connect w/ Facebook','gears') ) );

					new GearsModulesFacebookLogin(
							$app_id,
							$app_secret,
							$registrant_settings,
							$button_label
						);
				}
				
			}
			
			// Login Modal
			$is_ce_module_login_modal = true;
					
		}
		
		/**
		 * admin styling
		 */
		public function admin_styles(){
		
			//register our admin stylesheet
			wp_register_style( 'gears-admin-css', plugins_url('assets/admin.css', __FILE__) );
				wp_enqueue_style( 'gears-admin-css' );
            
		}
		
		/**
		 * option tree helper method
		 */
		public function ot_theme_option( $option_id, $default = '' ){
		
			// get the saved options
			$options = get_option( 'option_tree' );
			
			// look for the saved value
			if ( isset( $options[$option_id] ) && '' != $options[$option_id] ) {
				return $options[$option_id];
			}
			
			return $default;
 
		}
		
		/**
		 * buddypress configs
		 */
		function bp_setup(){
		
			// define avatar thumbnail width and height
			// define buddypress contants
			// that are used in Gears to avoid notices
			if (!defined('BP_AVATAR_FULL_HEIGHT')){ DEFINE( 'BP_AVATAR_THUMB_WIDTH', 100 ); }
			if (!defined('BP_AVATAR_THUMB_HEIGHT')){ DEFINE( 'BP_AVATAR_THUMB_HEIGHT', 100 ); }
			if (!defined('BP_AVATAR_FULL_WIDTH')){ DEFINE( 'BP_AVATAR_FULL_WIDTH', 325 ); }
			if (!defined('BP_AVATAR_FULL_HEIGHT')){ DEFINE( 'BP_AVATAR_FULL_HEIGHT', 325 ); }
			if (!defined('BP_AVATAR_ORIGINAL_MAX_WIDTH')){ DEFINE( 'BP_AVATAR_ORIGINAL_MAX_WIDTH', 1000 ); }
			if (!defined('BP_AVATAR_ORIGINAL_MAX_HEIGHT')){ DEFINE( 'BP_AVATAR_ORIGINAL_MAX_HEIGHT', 1000 ); }

			return;
			
		}
		
	}
} 
?>