<?php
/**
 * This file declares an action hook for wordpress
 * to know that there is a localisation going on here
 *
 * @since  3.6
 */

add_action('plugins_loaded', 'gears_load_textdomain');

function gears_load_textdomain() {

	if  (load_plugin_textdomain('gears', false, dirname( plugin_basename( __FILE__ )) . '/locale'));

} 
?>
