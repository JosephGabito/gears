<?php
/**
 * Gears shortcode collection
 *
 * @version 2.0
 * @since 2.0
 */

class Gears_Shortcodes{

	var $bp_not_installed = '';

	function __construct(){

		// configure default message for not complete bp installation
		$not_installed_tpl = '<div class="alert alert-warning">%s</div>';
		
		$not_installed_message = __('Sorry, BuddyPress must be enabled for this shortcode to work properly. If you have already installed and activated BuddyPress plugin, please make sure to enable this component inside "Settings" &rarr; "BuddyPress" &rarr; "Components".', 'gears');

		$not_installed_message = sprintf( $not_installed_tpl, $not_installed_message );

		$this->bp_not_installed = $not_installed_message;

		$this->register_scripts();

		// if visual composer is present integrate our modules to it
		if (function_exists('vc_map')) {
			$this->vc_integration();
		}

		$shortcode_list = array(
				'gears_bp_groups_carousel' => 'bp_groups_carousel',
				'gears_bp_groups_carousel_2' => 'bp_groups_carousel_2',
				'gears_bp_groups_grid' => 'bp_groups_grid',
				'gears_bp_groups_list' => 'bp_groups_list',
				'gears_bp_members_carousel' => 'bp_members_carousel',
				'gears_bp_members_carousel_2' => 'bp_members_carousel_2',
				'gears_bp_members_grid' => 'bp_members_grid',
				'gears_bp_members_list' => 'bp_members_list',
				'gears_bp_activity_stream' => 'gears_activity_stream',
				'gears_pricing_table' => 'gears_pricing_table',
				'gears_login' => 'gears_login',
				'gears_row' => 'gears_row',
				'gears_column' => 'gears_column',
				'gears_recent_posts' => 'gears_recent_posts',
				'gears_dropcap' => 'gears_dropcap',
				'gears_team_member' => 'gears_team_member',
				'gears_google_map' => 'gears_google_map'
			);
		
		// Counter Shortcode
		$counter_shortcode = apply_filters( 'gears_counters_enabled', '__return_false', 10, 1 );

		if ( true === $counter_shortcode ) {
			$shortcode_list['gears_counter'] = 'gears_counter';
		}

		// Alerts Shortcode
		$alerts_shortcode = apply_filters( 'gears_alerts_enabled', '__return_false', 10, 1 );

		if ( true === $alerts_shortcode ) {
			$shortcode_list['gears_alert'] = 'gears_alert';
		}

		// Buttons Shortcode
		$buttons_shortcode = apply_filters( 'gears_buttons_enabled', '__return_false', 10, 1 );

		if ( true === $buttons_shortcode ) {
			$shortcode_list['gears_button'] = 'gears_button';

		}
		// register all the shortcodes
		foreach ( $shortcode_list as $shortcode_id => $shortcode_callback ) {

			add_shortcode( $shortcode_id, array( $this, $shortcode_callback ) );

		}

		return $this;
	}

	/**
	 * Enqueue all the scripts here.
	 * 
	 * @return void
	 */
	function register_scripts() {

		add_action( 'wp_enqueue_scripts', array( $this, 'gears_enqueue_shortcode_scripts' ) );

		return;

	}

	/**
	 * Active callback for method 'register_scripts' using 'wp_enqueue_scripts' action.
	 * This is where we should register our scripts and styles.
	 * 
	 * @return void.
	 */
	function gears_enqueue_shortcode_scripts() {

		// Google Map API Script
		$google_map_api_key = apply_filters( 'gears-google-map-api', 'AIzaSyAKwuFxb4PLCdh8yf3v2XIbq000kAXSiaY' );
		$google_map_handle = 'gears-google-map-src';
		$google_map_src = sprintf( 'https://maps.googleapis.com/maps/api/js?key=%s', $google_map_api_key );

		wp_register_script( $google_map_handle, $google_map_src, $deps = array('jquery') , $ver = 1.0, $in_footer = true );

		return;

	}

	function gears_recent_posts( $atts, $content )
	{
		$output = '';

		return $this->get_template_file( $atts, 'recent-posts.php');
	}
	
	/**
	 * Login Shortcode
	 */
	function gears_login($atts, $content)
	{
		
		return $this->get_template_file( $atts, 'login.php');
		
	}

	/**
	 * Adds row to content
	 */
	function gears_row($atts, $content){
		
		// remove all annoying <br> and p
		$content = (do_shortcode($content));
		$content = str_replace("<br />", "\n", $content);
		$content = str_replace("<br>", "\n", $content);
		$content = str_replace("</p>\n<p>", "\n", $content);
		$content = str_replace("<p></p>", "\n", $content);

		return '<div class="row">'.$content.'</div>';
	}

	/**
	 * Adds columns to raw contnet
	 */
	function gears_column($atts, $content){

		$configs = array('size' => 12);
		extract(shortcode_atts($configs, $atts));
		$output = '<div class="col-md-'.$size.'">'.$content.'</div>';

		return $output;
	}

	/**
	 * shows members list
	 */
	function bp_members_carousel($atts)
	{
		return $this->get_template_file( $atts, 'bp-members-carousel.php' );
	}

	function bp_members_carousel_2($atts)
	{

		return $this->get_template_file( $atts, 'bp-members-carousel-2.php' );
	}

	/**
	 * BP Members Grid
	 */
	function bp_members_grid( $atts ) {

		return $this->get_template_file( $atts, 'bp-members-grid.php' );

	}

	/**
	 * BP Members List
	 */
	function bp_members_list($atts) {

		return $this->get_template_file($atts, 'bp-members-list.php');

	}

	/**
	 * BP Groups Carousel
	 */
	function bp_groups_carousel( $atts ) {

		return $this->get_template_file($atts, 'bp-groups-carousel.php');

	}

	/**
	 * BP Groups Carousel
	 */
	function bp_groups_carousel_2( $atts ) {

		return $this->get_template_file( $atts, 'bp-groups-carousel-2.php' );

	}

	/**
	 * BP Groups Grid
	 */

	function bp_groups_grid( $atts  ) {

		return $this->get_template_file( $atts, 'bp-groups-grid.php' );

	} // end function

	/**
	 * BP Groups List
	 */
	function bp_groups_list($atts, $content = "")
	{
		return $this->get_template_file($atts, 'bp-groups-list.php');
	}

	/**
	 * Shows activity stream
	 */
	function gears_activity_stream( $atts ) {
		
		return $this->get_template_file( $atts, 'bp-site-wide-activity.php' );

	}

	/**
	 * Gears Pricing Table
	 */
	function gears_pricing_table( $atts ){

		return $this->get_template_file( $atts, 'pricing-tables.php' );
	}

	function gears_counter( $atts ) {

		return $this->get_template_file( $atts, 'counters.php' );

	}

	/**
	 * Gears Alert
	 */
	function gears_alert( $atts ) {

		return $this->get_template_file( $atts, 'alerts.php' );

	}

	/**
	 * Gears Buttons
	 */
	function gears_button( $atts ) {

		return $this->get_template_file( $atts, 'buttons.php' );

	}

	/**
	 * Gears Dropcap
	 */
	function gears_dropcap( $atts, $content = "" ) {

		return $this->get_template_file( $atts, 'dropcaps.php', $content );

	}

	/**
	 * Gears Team Member
	 */
	function gears_team_member( $atts, $content = null ) {

		return $this->get_template_file( $atts, 'gears-member.php', $content );
	}

	function gears_google_map( $atts, $content = null ) {

		wp_enqueue_script('gears-google-map-src');

		return $this->get_template_file( $atts, 'gears-google-map.php', $content );

	}

	/**
	 * Gears Template File Loader Method
	 */
	function get_template_file( $atts, $file = '', $content = null ) {

		ob_start();

		if ( empty( $file )) {
			return;
		}

		$template = GEARS_APP_PATH.'modules/shortcodes/templates/'.$file;

		if ( file_exists( $template ) ) {

			if ( $theme_template = locate_template( array('gears/shortcodes/'.$file ) ) ) {

	        	$template = $theme_template;

	    	} 

	    	include $template;

    	} else {

	    	echo sprintf( __( 'Gears Error: Unable to find template file in: %1s', 'gears' ), $template );

	    }

    	return ob_get_clean();
	}

	/**
	 * Integrates our shortcode into Visual Composer Screen
	 *
	 * @since 1.0
	 */
	 function vc_integration(){

		require_once GEARS_APP_PATH . '/modules/shortcodes/vc.php';

		$vc_modules = new Gears_Visual_Composer();
		// members carousel
		$vc_modules->load( 'gears_bp_members_carousel' );
		// members carousel 2
		$vc_modules->load( 'gears_bp_members_carousel_2' );
		// members grid
		$vc_modules->load( 'gears_bp_members_grid' );
		// members list
		$vc_modules->load( 'gears_bp_members_list' );
		// groups carousel
		$vc_modules->load( 'gears_bp_groups_carousel' );
		// groups caoursel 2
		$vc_modules->load( 'gears_bp_groups_carousel_2' );
		// groups grid
		$vc_modules->load( 'gears_bp_groups_grid' );
		// groups list
		$vc_modules->load( 'gears_bp_groups_list' );
		// pricing table
		$vc_modules->load( 'gears_pricing_table' );
		// activity stream
		$vc_modules->load( 'gears_bp_activity_stream' );
		// login
		$vc_modules->load( 'gears_login' );
		// recent post
		$vc_modules->load( 'gears_recent_posts' );
		// testimonials
		$vc_modules->load( 'gears_testimonials' );
		// portfolio
		$vc_modules->load( 'gears_portfolio' );
		// Team Member
		$vc_modules->load( 'gears_team_member' );
		// Google Map
		$vc_modules->load( 'gears_google_maps' );
		// Dropcap
		$vc_modules->load( 'gears_counters' );
	 }
}
