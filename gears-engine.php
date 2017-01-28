<?php
/**
 * Gears
 *
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'Gears' ) )
{
	class Gears {

		/**
		 * initialize plugin modules, admin styles, and buddypress setup
		 */
		function __construct() {

			// modules
			add_action('init', array( $this,'load_modules'));

			// front-end stylesheet
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

			// admin stylesheets
			add_action('admin_init', array( $this, 'admin_styles' ));

			// BuddyPress config
			add_action('bp_init', array($this, 'bp_setup'), 0);

			// Loads the Gears Widgets.
			$this->load_widgets_instance();

			return;
		}

		/**
		 * Loads the stylehsheet
		 */
		public function enqueue_scripts()
		{

		    wp_enqueue_style( 'gears-stylesheet', plugins_url('assets/style.css', __FILE__), array(), 1 );

		    wp_enqueue_script( 'gears-vendor-js', plugins_url('assets/vendor.js', __FILE__), array(), '1.0', true );

    		return $this;
		}

		/**
		 * Includes all the files needed to kick-start the modules
		 */
		public function load_modules() {

			// Cover Photo Module
			$coverphoto_module = apply_filters('gears_cover_photo', '__return_true', 10, 1);
			
			// Facebook Connect Module
			$facebook_connect_module = apply_filters( 'gears_is_fb_enabled', 
				$this->ot_theme_option( 'is_fb_enabled' ) );
			
			// Google Connect Module
			$google_connect_module = apply_filters( 'gears_is_g+_enabled', '__return_true', 10, 1);
			
			// Testimonial Module
			$testimonial_module = apply_filters( 'gears_testimonial_enabled', '__return_false', 10, 1 );
			
			// Portfolio Module
			$portfolio_module = apply_filters( 'gears_portfolio_enabled', '__return_false', 10, 1 );

			// Load bp cover photo
			if ( $coverphoto_module ) {
				require_once GEARS_APP_PATH . '/modules/bp-cover-photo/index.php';
			}

			// Load bp cover photo
			if ( true === $testimonial_module ) {
				require_once GEARS_APP_PATH . '/modules/testimonials/testimonials.php';
			}

			// Load Gears Portfolio
			if ( true === $portfolio_module ) {
				require_once GEARS_APP_PATH . '/modules/portfolio/portfolio.php';
			}
			
			if ( $google_connect_module ) {
				// load google plus connect
				require_once GEARS_APP_PATH . '/modules/google-login/index.php';
				
				// Google+ Connect
				if ( ! is_user_logged_in() && get_option( 'users_can_register' ) ) {

					if ( function_exists( 'curl_version' ) ) {

						$google_connect = new GearsGooglePlusConnect();

					} else {
						add_action( 'gears_login_form', array( $this, 'curl_not_installed' ) );
					}
				}
			}

			// Load login form shortcode
			require_once GEARS_APP_PATH . '/modules/login-form/login-form.php'; 

			// load the shortcodes
			require_once GEARS_APP_PATH . '/modules/shortcodes/library.php'; new Gears_Shortcodes();

			if( ! is_user_logged_in() && $facebook_connect_module && get_option('users_can_register') ) {

				// if facebook login is enabled
				// require the essential plugin
				// we need to check if there is curl installed/activated in the server
				// added in 2.1.0
				if ( function_exists('curl_version') ) {

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

				} else {

					add_action( 'gears_login_form', array( $this, 'curl_not_installed' ) );
					
				}

			}

			// Login Modal
			$is_ce_module_login_modal = true;

		}

		public function curl_not_installed() {
			?>
			<div class="gears-alert gears-alert-danger gears-clearfix">
				<?php esc_html_e( 'PHP Curl Extention must be enabled for Social Connect to work properly', 'gears'); ?>
			</div>
			<?php
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

		function load_widgets_instance() {

			require_once GEARS_APP_PATH . '/modules/widgets/widgets.php';

			return;
		}

	}
}
?>
