<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.dacast.com
 * @since             1.0.0
 * @package           Dacast_geo_location
 *
 * @wordpress-plugin
 * Plugin Name:       Dacast Geo Location
 * Plugin URI:        www.dacast.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Arturo Schreiber
 * Author URI:        www.dacast.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dacast_geo_location
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
define( 'DACAST_GEO_LOCATION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dacast_geo_location-activator.php
 */
function activate_dacast_geo_location() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dacast_geo_location-activator.php';
	Dacast_geo_location_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dacast_geo_location-deactivator.php
 */
function deactivate_dacast_geo_location() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dacast_geo_location-deactivator.php';
	Dacast_geo_location_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dacast_geo_location' );
register_deactivation_hook( __FILE__, 'deactivate_dacast_geo_location' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dacast_geo_location.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dacast_geo_location() {

	$plugin = new Dacast_geo_location();
	$plugin->run();

}
run_dacast_geo_location();
