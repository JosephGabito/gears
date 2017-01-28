<?php
defined( 'ABSPATH' ) || exit;

if (!class_exists('GearsGooglePlusConnect')) 
{
	class GearsGooglePlusConnect 
	{

		protected $clientId = '';
		protected $clientSecret = '';
		protected $redirectUri = '';
		protected $accessToken = false;
		public $buttonLabel = 'Google+';

		public function __construct() 
		{
			// Return if option tree is not defined.
			
			$is_google_connect_enabled = apply_filters( 'gears_g+_api_enabled', $this->ot_theme_option('google_api_enabled', false) );

			if ( ! $is_google_connect_enabled ) {

				return;

			}

			$this->clientId = apply_filters( 'gears_g+_app_id', $this->ot_theme_option( 'google_api_client_id', '' ) );

			$this->clientSecret = apply_filters( 'gears_g+_app_secret', $this->ot_theme_option( 'google_api_client_secret', '' ) );

			$this->redirectUri = apply_filters( 'gears_g+_redirect_url', admin_url( 'admin-ajax.php?action=clientConnectionInit' ) );

			if ( empty( $this->clientId ) ) { return; }

			if ( empty( $this->clientSecret ) ) { return; }

			$this->buttonLabel = apply_filters( 'gears_g+_btn_label', $this->ot_theme_option( 'google_api_button_label', $this->buttonLabel ) );

			add_action( 'klein_login_form', array( $this, 'connectClient' ) , 1 );
 
			add_action( 'gears_login_form', array( $this, 'connectClient' ) , 1 );

			add_action( 'wp_ajax_clientConnectionInit', array( $this, 'clientConnectionInit' ) );

			add_action( 'wp_ajax_nopriv_clientConnectionInit', array( $this, 'clientConnectionInit' ) );

			add_action( 'login_head', array( $this, 'errorLoggingIn' ) );

			return;
		}

		/**
		 * Custom Error Messages
		 * @return void
		 */
		public function errorLoggingIn()
		{
			if( isset( $_GET['error'] ) and isset( $_GET['type'] ) ){
				if( $_GET['type'] == 'gears_username_or_email_exists' ){
					add_filter( 'login_message', array( $this, 'custom_error_message_text' ) );
				}
				
				if( $_GET['type'] == 'gp_error_authentication'){
					add_filter( 'login_message', array( $this, 'errorAuthentication' ) );
				}
			}
		}

		public function ot_theme_option( $option_id, $default = '' ){

			// get the saved options
			$options = get_option( 'option_tree' );

			// look for the saved value
			if ( isset( $options[$option_id] ) && '' != $options[$option_id] ) {
				return $options[$option_id];
			}

			return $default;

		}

		public function errorAuthentication()
		{
			?>
			<div id="login_error">
				<?php 
					_e(
					'There was an error connecting with Google OAuth API. If you are the Administrator of this website, please check the Client ID and Client Secret in your configuration.',
					'gears'
					); 
				?>
			</div>
			<?php
		}
		/**
		 * Initialised auto connection
		 * to Google API
		 * @return void
		 */
		public function clientConnectionInit()
		{
			if ( is_user_logged_in() ) die();

			// autoload google api sources
			require_once GEARS_APP_PATH . '/modules/google-login/autoload.php';

			// unset everything on connect
			if (isset($_SESSION)) {

				unset($_SESSION);

			}
			
			$client = new Google_Client();

			$client->setClientId($this->clientId);
			
			$client->setClientSecret($this->clientSecret);

			$client->setRedirectUri($this->redirectUri);

			// add scope for fetching user email and profile
			$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email',
        						'https://www.googleapis.com/auth/plus.me')); 

			// initialise new google oauth client
			$oauth2 = new Google_Service_Oauth2($client);

			// catch reponse from google api
			if ( isset( $_GET['code'] ) ) {

				// Authenticate the user, $_GET['code'] is used internally:
				try {
					
					$client->authenticate($_GET['code']);
				
				} catch (Exception $e) {

					// something bad happened here...
					wp_safe_redirect(wp_login_url() . '?error=true&type=gp_error_authentication');

					return;
				}


				// assign new access token to client
				$this->accessToken = $client->getAccessToken();

				// fetch user info from google api data
				$user = $oauth2->userinfo->get();
				// assign a dirty username for now
				$username = $user->name;

					// in case he is using Google Business Suite
					if ( empty ( $username ) ) {

						// assign the email as username.
						$parts = explode( "@",  $user->email );
						$username = $parts[0];
					}

				// generate random password for that user
				$password = wp_generate_password(10, false, false);

				// store the email
				$email = $user->email;
			
				// check if email already exists
				$user_email_id = email_exists($user->email);

				if ( $user_email_id ) {

					// login the user if email is found
					$user = get_user_by($field = 'id', $user_email_id);
					if ($user) {
					    wp_set_current_user($user_email_id, $user->user_login );
					    wp_set_auth_cookie($user_email_id );
					}

				} else{

					// otherwise, create new user
					$username = $this->sanitizeUserName( $username, 1, $copy = $username );
					
					$user_id = wp_create_user( $username, $password, $email );

					$last_created_user = get_user_by($field = 'id', $user_id);
					
					if ( $last_created_user ) {

					    wp_set_current_user( $user_id, $last_created_user->user_login );

					    wp_set_auth_cookie( $user_id );

					    // update user info
					    wp_update_user(
					    	array(
					    			'ID' => $user_id,
									'display_name' => $user->name 
								)
					    	);

					    // update buddypress profile
					    if ( function_exists( 'xprofile_set_field_data' ) ) {
					    	
					    	xprofile_set_field_data( 'Name', $user_id,  $user->name );

					    }

					    if ( function_exists( 'bp_loggedin_user_domain' ) ) {

							wp_safe_redirect( bp_core_get_user_domain( $user_id ) );

							die();

						} else {

							// else just redirect to homepage
							wp_safe_redirect( get_bloginfo( 'url' ) );
							
							die();
						}
					}
				}

				wp_redirect(esc_url(home_url()));
			}

			if (isset($this->accessToken) && $this->accessToken) {
			  	$client->setAccessToken($this->accessToken);
			} else {
			  	$authenticationUrl = $client->createAuthUrl();
			  	if (isset($_GET['error'])) {
			  		wp_safe_redirect(home_url());
			  	} else {
			  		header('Location: '. $authenticationUrl);
			  	}
			  	
			}

			die();
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

		/**
		 * Adds 'Connect' link
		 * @return void
		 */
		public function connectClient() 
		{
			?>
			<a class="social-connect gp btn btn-danger" href="<?php echo admin_url(); ?>admin-ajax.php?action=clientConnectionInit">
				<i class="fa fa-google-plus"></i> <?php echo $this->buttonLabel; ?>
			</a>
			<?php
			return;
		}
	}
}
?>