<?php

/**
 * Plugin Name:        Post Category FCM Notifications
 *
 * @package           WordPress-Post-FCM-Plugin
 * @author:           Mfornyam Emil
 * @copyright         2019 Mfornyam Emil
 * @license:          GPL v2 or later
 *
 * @wordpress-plugin
 * Plugin Name:       Post Category FCM Notifications
 * Plugin URI:        https://github.com/EmilMfornyam/WordPress-Post-FCM-Plugin
 * Description:       Send FCM notifications on post publish from specific catergories.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      5.2
 * Author:            Mfornyam Emil
 * Author URI:        https://github.com/EmilMfornyam
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       postcategory-fcm-notifications
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define('PCFCM_VERSION', '1.0.0' );
	
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_PCFCM() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-postcategory-fcm-notifications-activator.php';
	PCFCM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_PCFCM() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-postcategory-fcm-notifications-deactivator.php';
	PCFCM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_PCFCM' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_PCFCM' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-postcategory-fcm-notifications.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_PCFCM() {

	$plugin = new Post_Category_FCM_Notifications();
	$plugin->run();

}
run_plugin_PCFCM();
