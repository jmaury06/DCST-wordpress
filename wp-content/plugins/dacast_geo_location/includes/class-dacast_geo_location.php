<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_geo_location
 * @subpackage Dacast_geo_location/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Dacast_geo_location
 * @subpackage Dacast_geo_location/includes
 * @author     Arturo Schreiber <arturo.oficina@gmail.com>
 */
class Dacast_geo_location {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dacast_geo_location_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DACAST_GEO_LOCATION_VERSION' ) ) {
			$this->version = DACAST_GEO_LOCATION_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'dacast_geo_location';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dacast_geo_location_Loader. Orchestrates the hooks of the plugin.
	 * - Dacast_geo_location_Admin. Defines all hooks for the admin area.
	 * - Dacast_geo_location_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dacast_geo_location-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dacast_geo_location-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dacast_geo_location-public.php';

		$this->loader = new Dacast_geo_location_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Dacast_geo_location_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Dacast_geo_location_Public( $this->get_plugin_name(), $this->get_version() );
    $this->loader->add_action( 'parse_request', $plugin_public, 'geoplugin_js' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
  
    // register geolocation_price shortcode
    add_shortcode('geolocation_price', array($this, 'print_price'));
	}

  public function print_price($atts) {
    
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    $pp_atts = shortcode_atts(
        array(
            'type' => 'starter',
        ), $atts, ''
    );
    
    $type = $pp_atts['type'];
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $starter = array('US' => '$39', 'UK' => '£34', 'EU' => '€39');
    $event = array('US' => '$63', 'UK' => '£53', 'EU' => '€59');
    $scale = array('US' => '$188', 'UK' => '£159', 'EU' => '€169');
    $scale_monthly = array('US' => '$250', 'UK' => '£212', 'EU' => '€225');

    switch($type){
      case 'starter':
        $selected = $starter;
        break;
      case 'event':
        $selected = $event;
        break;
      case 'scale':
        $selected = $scale;
        break;
      case 'scale_monthly':
        $selected = $scale_monthly;
        break;
      default:
        $selected = $starter;
        break;
    }
    
    $geoPlugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
    
    if (isset($geoPlugin['geoplugin_countryCode'])) {
      /* United Kingdome */
      if ($geoPlugin['geoplugin_countryCode'] == 'GB') {
        return $selected['UK'];
      }
      
      /* In Europe */
      if ($geoPlugin['geoplugin_inEU'] == 1 ){
        return $selected['EU'];
      }
    }
    
    /* Always fallback to US */
    return $selected['US'];
  }

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Dacast_geo_location_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
