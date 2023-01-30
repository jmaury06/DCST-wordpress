<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              dacast.com
 * @since             1.0.0
 * @package           Dacast_external_resources
 *
 * @wordpress-plugin
 * Plugin Name:       Dacast Exteral Resources
 * Plugin URI:        dacast.com
 * Description:       Custom load of external resources with the right headers.
 * Version:           1.0.0
 * Author:            Aschab
 * Author URI:        dacast.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dacast_external_resources
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'DACAST_EXTERNAL_RESOURCES_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dacast_external_resources-activator.php
 */
function activate_dacast_external_resources() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dacast_external_resources-activator.php';
	Dacast_external_resources_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_dacast_external_resources' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dacast_external_resources-deactivator.php
 */
function deactivate_dacast_external_resources() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dacast_external_resources-deactivator.php';
	Dacast_external_resources_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_dacast_external_resources' );

/**
 * The core plugin class that is used to define
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dacast_external_resources.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dacast_external_resources() {

	$plugin = new Dacast_external_resources();
	$plugin->run();

}
run_dacast_external_resources();
