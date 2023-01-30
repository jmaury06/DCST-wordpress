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
 * @package           Dacast_graphql
 *
 * @wordpress-plugin
 * Plugin Name:       Dacast Graphql
 * Plugin URI:        www.dacast.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Arturo Schreiber
 * Author URI:        www.dacast.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dacast_graphql
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
define( 'DACAST_GRAPHQL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dacast_graphql-activator.php
 */
function activate_dacast_graphql() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dacast_graphql-activator.php';
	Dacast_graphql_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dacast_graphql-deactivator.php
 */
function deactivate_dacast_graphql() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dacast_graphql-deactivator.php';
	Dacast_graphql_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dacast_graphql' );
register_deactivation_hook( __FILE__, 'deactivate_dacast_graphql' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dacast_graphql.php';

define( 'MY_ACF_PATH', WP_PLUGIN_DIR . '/dacast_graphql/acf/' );
define( 'MY_ACF_URL', WP_PLUGIN_URL . '/dacast_graphql/acf/' );
include_once( MY_ACF_PATH . 'acf.php' );
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
    return MY_ACF_URL;
}
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin( $show_admin ) {
    return false;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dacast_graphql() {

	$plugin = new Dacast_graphql();
	$plugin->run();

}
run_dacast_graphql();

