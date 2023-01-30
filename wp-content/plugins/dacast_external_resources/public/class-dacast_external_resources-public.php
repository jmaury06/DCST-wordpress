<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_external_resources
 * @subpackage Dacast_external_resources/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dacast_external_resources
 * @subpackage Dacast_external_resources/public
 * @author     Aschab <arturo.schreiber@dacast.com>
 */
class Dacast_external_resources_Public {

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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dacast_external_resources-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name . '-footer', plugin_dir_url( __FILE__ ) . 'js/dacast_external_resources-footer.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-header', plugin_dir_url( __FILE__ ) . 'js/dacast_external_resources-header.js', array( 'jquery' ), $this->version, false );
    }

    /**
     * Add custom headers on case basis.
     *
     * @since    1.0.0
     */
    public function add_custom_headers() {
        $files = array(
            'http-adroll.js' => 'http://a.adroll.com/j/roundtrip.js',
            'https-adroll.js' => 'https://s.adroll.com/j/roundtrip.js',
            'hotjar.js' => 'https://static.hotjar.com/c/hotjar-1350928.js?sv=6',
            'facebook.js' => 'https://connect.facebook.net/en_US/fbevents.js',
            'zendesk.js' => 'https://static.zdassets.com/ekr/snippet.js?key=3a0de42e-c180-4bd1-b691-86cf01057c99',
            'googleanalytics.js' => 'https://www.googletagmanager.com/gtag/js?id=UA-18770221-1',
            'licdn.js' => 'https://snap.licdn.com/li.lms-analytics/insight.min.js',
            'addtoany.js' => 'https://static.addtoany.com/menu/page.js',
            'http-ctk.js' => 'http://trk.cloudamp.net/ctk.js',
            'https-ctk.js' => 'https://1d5ef9e9369608f625a8-878b10192d4a956595449977ade9187d.ssl.cf2.rackcdn.com/ctk.js',
        );

        if (isset($files[$_GET['file']])) {
            switch ($files[$_GET['file']]) {
                case 'http://a.adroll.com/j/roundtrip.js':
                case 'https://s.adroll.com/j/roundtrip.js':
                case 'https://static.hotjar.com/c/hotjar-1350928.js?sv=6':
                case 'https://connect.facebook.net/en_US/fbevents.js':
                case 'https://static.zdassets.com/ekr/snippet.js?key=3a0de42e-c180-4bd1-b691-86cf01057c99':
                case 'https://www.googletagmanager.com/gtag/js?id=UA-18770221-1':
                case 'https://snap.licdn.com/li.lms-analytics/insight.min.js':
                case 'https://static.addtoany.com/menu/page.js':
                case 'http://trk.cloudamp.net/ctk.js':
                case 'https://1d5ef9e9369608f625a8-878b10192d4a956595449977ade9187d.ssl.cf2.rackcdn.com/ctk.js':
                    $expiration = (60 * 60) * 24 * 365 ;
                    header( "Etag: $this->version" );
                    header( 'Content-Type: application/javascript');
                    header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expiration ) . ' GMT' );
                    header( "Cache-Control: public, max-age=$expiration" );
                    break;
                default:
                    $expiration = (60 * 60) * 24 * 30;
                    header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expiration ) . ' GMT' );
                    header( "Cache-Control: public, max-age=$expiration" );
                    break;
            }
            
            echo file_get_contents($files[$_GET['file']]);
            exit;
        }
    }
}
