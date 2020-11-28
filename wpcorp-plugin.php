<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           WPCorp_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       WPCorp Plugin
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Chandra Prakash Thapa
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpcorp-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPCorp_Plugin_VERSION', '1.0.0' );

define( 'WPCorp_Plugin_PATH', plugin_dir_path( __FILE__ ));
define( 'WPCorp_Plugin_URL', plugin_dir_url( __FILE__ ));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpcorp-plugin-activator.php
 */
function activate_WPCorp_Plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcorp-plugin-activator.php';
	WPCorp_Plugin_Activator::activate();
	do_action('WPCorp_Plugin_activate');
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpcorp-plugin-deactivator.php
 */
function deactivate_WPCorp_Plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcorp-plugin-deactivator.php';
	WPCorp_Plugin_Deactivator::deactivate();
	do_action('WPCorp_Plugin_deactivate');
}

register_activation_hook( __FILE__, 'activate_WPCorp_Plugin' );
register_deactivation_hook( __FILE__, 'deactivate_WPCorp_Plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpcorp-plugin.php';

/**
 * Initialise CMB2 plugin
 */
require plugin_dir_path( __FILE__ ) . 'admin/cmb2-initialiser.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_WPCorp_Plugin() {

	$plugin = new WPCorp_Plugin();
	$plugin->run();

}
run_WPCorp_Plugin();
