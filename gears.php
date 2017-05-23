<?php
/**
 * Plugin Name: Gears
 * Plugin URI: http://themeforest.net/user/dunhakdis
 * Description: Gears empowers BuddyPress to have more features like cover photos, social login, shortcodes, and more!
 * Version: 4.1.3
 * Author: Dunhakdis
 * Author URI: http://themeforest.net/user/dunhakdis
 * License: GPL2
 */

// ============== // ============== // ============== // ============== // ============== // ============== //

/**
 * The namespace
 */
DEFINE('GEARS_APP_NAMESPACE', 'Gears');

/**
 * The current version of the plugin
 */
DEFINE('GEARS_APP_VERSION', '4.1.3');

/**
 * The plug-in absolute path
 */
DEFINE('GEARS_APP_PATH', plugin_dir_path( __FILE__ ));

/**
 * Set to FALSE to disable update debugging
 */
DEFINE('GEARS_IS_UPDATE_DEBUG_MODE', FALSE);

/**
 * Load the translation file
 */
require_once GEARS_APP_PATH . 'locale.php';

/**
 * Require updater file to check the version periodically
 * for changes and updates
 */
require_once GEARS_APP_PATH . 'update-check.php';

/**
 * Require main library file
 */
require_once GEARS_APP_PATH . 'gears-engine.php';

/**
 * Start the app
 */
$Gears = new Gears();

?>
