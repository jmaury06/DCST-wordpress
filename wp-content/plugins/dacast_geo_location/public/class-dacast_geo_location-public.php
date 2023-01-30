<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_geo_location
 * @subpackage Dacast_geo_location/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dacast_geo_location
 * @subpackage Dacast_geo_location/public
 * @author     Arturo Schreiber <arturo.oficina@gmail.com>
 */
class Dacast_geo_location_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dacast_geo_location_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_geo_location_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dacast_geo_location-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dacast_geo_location_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_geo_location_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dacast_geo_location-public.js', array( 'jquery' ), $this->version, false );

	}

  public function print_geoplugin_script($atts) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $geoPlugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
    $region = "US";
    $country = $geoPlugin['geoplugin_countryCode'];
    if (isset($geoPlugin['geoplugin_countryCode'])) {
      /* United Kingdome */
      if ($geoPlugin['geoplugin_countryCode'] == 'GB') {
        $region = "UK";
      }
      /* In Europe */
      if ($geoPlugin['geoplugin_inEU'] == 1 ){
        $region = "EU";
      }
    }
    ?>
    <script>
    geoplugin_starter = {US: '$39', UK: '£34', EU: '€39'};
    geoplugin_event = {US: '$63', UK: '£53', EU: '€59'};
    geoplugin_scale = {US: '$188', UK: '£159', EU: '€169'};
    geoplugin_scale_monthly = {US: '$250', UK: '£212', EU: '€225'};
    geoplugin_region = '<?php $region; ?>';
    geoplugin_country = '<?php $country; ?>';
    </script>
    <?php
  }

  public function geoplugin_js() {
    if (isset($_GET['file'])) {
      if ($_GET['file'] == 'geoplugin.js') {
        $ip = $_SERVER['REMOTE_ADDR'];
        $geourl = 'http://www.geoplugin.net/php.gp?ip=' . $ip;
        $geoPlugin = unserialize( file_get_contents($geourl) );
        $region = "US";
        $country = $geoPlugin['geoplugin_countryCode'];
        if (isset($geoPlugin['geoplugin_countryCode'])) {
          /* United Kingdome */
          if ($geoPlugin['geoplugin_countryCode'] == 'GB') {
            $region = "UK";
          }
          /* In Europe */
          if ($geoPlugin['geoplugin_inEU'] == 1 ){
            $region = "EU";
          }
        }
        $expiration = 0;
        header( "Etag: $this->version" );
        header( 'Content-Type: application/javascript');
        header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expiration ) . ' GMT' );
        header( "Cache-Control: public, max-age=$expiration" );
        ?>
        geoplugin_region = '<?php echo $region; ?>';
        geoplugin_country = '<?php echo $country; ?>';
        geoplugin_ip = '<?php echo $ip; ?>';
        <?php
        exit;
      }
    }
  }
}
