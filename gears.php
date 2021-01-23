<?php
/**
 * Plugin Name: Gears
 * Plugin URI: http://themeforest.net/user/dunhakdis
 * Description: Gears empowers BuddyPress to have more features like cover photos, social login, shortcodes, and more!
 * Version: 4.2.3
 * Author: Dunhakdis
 * Author URI: http://themeforest.net/user/dunhakdis
 * License: GPL2
 */

// ============== // ============== // ============== // ============== // ============== // ============== //

/**
 * Define the namespace of our plugin.
 */
define( 'GEARS_APP_NAMESPACE', 'Gears' );

/**
 * Define the current version of Gears.
 */
define( 'GEARS_APP_VERSION', '4.2.3' );

/**
 * The plugin's absolute path.
 */
define( 'GEARS_APP_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Set GEARS_IS_UPDATE_DEBUG_MODE to false to force update from the custom source url.
 */
define( 'GEARS_IS_UPDATE_DEBUG_MODE', true );

/**
 * Load the translation file.
 */
require_once GEARS_APP_PATH . 'locale.php';

/**
 * Require updater file to check the version periodically.
 * This is for required changes and updates.
 */
require_once GEARS_APP_PATH . 'update-check.php';

$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://repo.dunhakdis.com/gears/gears.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'gears'
);

/**
 * Require the main file.
 */
require_once GEARS_APP_PATH . 'gears-engine.php';

/**
 * Start the Gears class.
 */
$gears = new Gears();