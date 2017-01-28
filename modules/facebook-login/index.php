<?php
/**
 * Facebook login index
 */
defined( 'ABSPATH' ) || exit;

// Start the session if there are no sessions found.
if ( session_id() == '' ) {
	// As required by the Facebook SDK
    session_start();
}

if( !class_exists( 'GearsModulesFacebookLogin' ))
{

class GearsModulesFacebookLogin{
	
	var $facebook = '';
	var $registrant_settings = '';
	var $button_label = '';
	var $redirectUrl = '';
	var $appID = '';
	var $appSecret = '';

	function __construct( $app_id = '', $app_secret = '', $registrant_settings, $button_label = "" ){
		
		$this->button_label = $button_label;
		$this->registrant_settings = $registrant_settings;
		$this->redirectUrl = admin_url('admin-ajax.php?action=gears_fb_connect');
		$this->appID = $app_id;
		$this->appSecret = $app_secret;
		
		//integrate facebook login link to default wordpress login form
		add_action( 'klein_login_form', array( $this, 'integrate' ), 0 );
		add_action( 'gears_login_form', array( $this, 'integrate' ), 0 );
		
		//add return url action that will handle the facebook api callback data
		add_action( 'wp_ajax_gears_fb_connect', array( $this, 'connect' ) );
		add_action( 'wp_ajax_nopriv_gears_fb_connect', array( $this, 'connect' ) );
		
		//add custom error message to login
		add_action( 'login_head', array( $this, 'custom_error_message' ) );

		return;
	}
	

	public function connect() {
		
		require_once GEARS_APP_PATH . 'modules/facebook-login/connect.php';

		die();
	}
	
	public function integrate() {

		$login_url = admin_url('admin-ajax.php?action=gears_fb_connect');

		if ( empty( $this->appID ) ) { ?>
		
			<div class="gears-alert gears-alert-danger mg-bottom-15">
				<?php esc_html_e( 'Facebook App ID is required for Facebook Connect to work.'); ?>
			</div>
		
			<?php return; ?>
		
		<?php } 
		if ( empty( $this->appSecret ) ) { ?>
		
			<div class="gears-alert gears-alert-danger mg-bottom-15">
				<?php esc_html_e( 'Facebook App Secret is required for Facebook Connect to work.'); ?>
			</div>
		
			<?php return; ?>
		
		<?php } ?>

		<a title="<?php echo esc_attr($this->button_label); ?>" class="social-connect fb btn btn-primary" href="<?php echo esc_url($login_url); ?>">
			<i class="fa fa-facebook"></i>
			<?php echo esc_attr($this->button_label); ?>
		</a>
		<?php
	}
	
	public function wp_error_class($error_string = '')
	{
		if (empty($error_string)) return;

		echo '<div id="login_error">';
			echo __($error_string);
		echo '</div>';

		return;
	}

	public function custom_error_message(){
	
		$wp_error = new WP_Error();
		
		if( isset( $_GET['error'] ) and isset( $_GET['type'] ) ){
			if( $_GET['type'] == 'gears_username_or_email_exists' ){
				add_filter( 'login_message', array( $this, 'error_email_exists' ) );
			}
			if( $_GET['type'] == 'fb_error'){
				add_filter( 'login_message', array( $this, 'error_fb_api' ) );
			}
			if( $_GET['type'] == 'app_not_live'){
				add_filter( 'login_message', array( $this, 'error_app_not_live' ) );
			}
			if( $_GET['type'] == 'fb_invalid_email'){
				add_filter( 'login_message', array( $this, 'error_fb_invalid_email' ) );
			}
		}
	}
	
	public function error_fb_invalid_email()
	{
		$errMessage = __('Unable to register your profile. Please make sure you have a valid email address in your Facebook account.', 'gears');
		$this->wp_error_class($errMessage);
		return;
	}

	public function error_app_not_live()
	{
		$errMessage = __('Cannot fetch user data from your Facebook Profile.', 'gears');
		$this->wp_error_class($errMessage);
		return;
	}

	public function error_email_exists(){
		$errMessage = __('The username or email you are trying to connect with your facebook account is already registered.', 'gears');
		$this->wp_error_class($errMessage);
		return;
	}
	
	public function error_fb_api(){
		$errMessage = __('There was an error trying to communicate with the Facebook. Either you did not allowed this website to access your basic information or there was a glitch on their side. Please come back again later.', 'gears');
		$this->wp_error_class($errMessage);
		return;
	}
	
	/**
	  * Creates new username for the user
	  * recurse and increments the user index
	  * if there is duplicate username found
	  * in wp_users table
	  * 
	  * @param  string  $username the proposed username
	  * @param  integer $index    recursive incremental int
	  * @param  string  $copy     original $username reference
	  * @return string            the final username
	  */
	public function sanitizeUserName($username, $index = 1, $copy)
	{
		if ($index > 1) {
			$username = sanitize_title($copy) . '-' . $index;
		} else {
			$username = sanitize_title($username);
		}
		
		// 1. store 'username'
		// 2. check if username exists
		// 3. return username if not found. Otherwise, 
		// 4. increment index and append to username
		// 5. check again if incremented index and appended index to username exists
		
		if (!username_exists($username)) {
			return $username;
		} else {
			$index++;
			return $this->sanitizeUserName($username, $index, $copy);
		}	
	}
} // end class
} // end if
?>