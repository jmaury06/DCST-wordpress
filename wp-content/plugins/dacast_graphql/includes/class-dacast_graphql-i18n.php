<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_graphql
 * @subpackage Dacast_graphql/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dacast_graphql
 * @subpackage Dacast_graphql/includes
 * @author     Arturo Schreiber <arturo.schreiber@dacast.com>
 */
class Dacast_graphql_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dacast_graphql',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
