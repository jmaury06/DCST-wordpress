<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_shortcodes
 * @subpackage Dacast_shortcodes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dacast_shortcodes
 * @subpackage Dacast_shortcodes/admin
 * @author     Arturo Schreiber <arturo.oficina@gmail.com>
 */
class Dacast_shortcodes_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dacast_shortcodes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_shortcodes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dacast_shortcodes-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dacast_shortcodes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_shortcodes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dacast_shortcodes-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function dacast_actions_menu() {
		add_submenu_page( 
			null, 
			'A',
			'A',
			'manage_options',
			'dacast_actions',
			array($this, 'dacast_actions'),
		);
	}

	public function dacast_actions() {
		if(isset($_GET['search_and_replace'])){
			$this->dacast_search_and_replace();
		}
		if(isset($_GET['search_and_replace_urls'])){
			$this->dacast_search_and_replace_urls();
		}
		if(isset($_GET['rollback'])){
			$this->rollback();
		}
	}

	public function rollback() {

		$author = 66;
		$key = "dacast_rollback_1";
		$count = 0;
		$id = false;
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}

		$time_start = microtime(true); 

		$args = array(
			'post_type' => array('post', 'ufaq', 'epkb_post_type_1'),
			'numberposts' => -1
		);

		if($id) {
			$args['post__in'] = array($id);
		}

		$blogs = get_posts($args);


		foreach ($blogs as $blog){
			if(!$id && get_post_meta($blog->ID, $key)) {
				$count++;
				continue;
			}

			if(isset($_GET['count'])){
				continue;
			}

			$revisions = wp_get_post_revisions( $blog->ID );
			if(count($revisions) > 2) {
				foreach($revisions as $revision) {
					if($revision->post_author == $author) {
						continue;
					}
					$revert = array(
						'ID' => $blog->ID, // Update current post in query
						'post_content' => $revision->post_content // set content to previous content
					);
					wp_update_post( $revert );
					break;					
				}
				update_post_meta($blog->ID, $key, true);
			}

			$execution_time = (microtime(true) - $time_start)/60;
			if($execution_time > 60) {
				break;
			}
		}

		var_dump($count);
		exit;

	}

	public function dacast_search_and_replace_urls() {
		$id = false;
		$count = 0;
		$count_url = 0;
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}

		$time_start = microtime(true); 
		$key = "dacast_url_update_4";

		$args = array(
			'post_type' => array('post', 'ufaq', 'knowledgebase'),
			'numberposts' => -1
		);

		if($id) {
			$args['post__in'] = array($id);
		}

		$competitors = [
			'https://www.brightcove.com/',
			'https://video.ibm.com/',
			'https://www.jwplayer.com/',
			'https://www.boxcast.com/',
			'https://vimeo.com/',
			'https://www.muvi.com/',
			'https://resi.io/',
			'https://streamshark.io/',
			'https://corp.kaltura.com/',
			'https://streamyard.com/',
			'https://streamlabs.com/',
			'https://www.cincopa.com/',
			'https://restream.io/',
			'https://www.wowza.com/',
			'https://www.panopto.com/',
			'https://www.youtube.com/',
			'https://www.dailymotion.com/',
			'https://facebook.com/',
			'https://www.instagram.com/',
			'https://www.tiktok.com/',
			'https://www.twitch.tv/',
			'https://linkedin.com/',
			'https://castr.io/',
			'https://www.uscreen.tv/',
			'https://www.vidyard.com/',
			'https://livestream.com/',
			'https://zoom.us/'
		];

		$blogs = get_posts($args);

		foreach ($blogs as $blog) {
			$change = false;
			if(!$id && get_post_meta($blog->ID, $key)){
				echo "<br>Already Updated: " . $blog->ID;
				$count++;
				continue;
			}

			if(isset($_GET['count'])){
				continue;
			}

			$content = $blog->post_content;
			$old_content = $content;
			
			$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

			$doc = new DOMDocument('1.0', 'utf-8');
			$doc->loadHTML($content);
			
			foreach($doc->getElementsByTagName('a') as $link) { 
				$url = $link->getAttribute("href");

				foreach($competitors as $c) {
					if (strpos($url,$c) !== false) {
						$count_url++;

						$rel = array(); 

						if ($link->hasAttribute('rel') && ($relAtt = $link->getAttribute('rel')) !== '') {
						   $rel = preg_split('/\s+/', trim($relAtt));
						}

						if (in_array('nofollow', $rel)) {
						  continue;
						}
				  
						$rel[] = 'nofollow';
						$link->setAttribute('rel', implode(' ', $rel));

						$change = true;

						break;
					}
				}
			}

			if($change) {
				$content = $doc->saveHTML();
				$blog->post_content = $content;			
			}

			update_post_meta($blog->ID, $key, true);

			if ($change){
				var_dump(wp_update_post($blog));
				echo "<br>Post Updated: " . $blog->ID;
			}		

			$execution_time = (microtime(true) - $time_start)/60;
			if($execution_time > 60) {
				break;
			}

		}
		var_dump($count_url);
		var_dump($count);
	}

	public function dacast_search_and_replace() {
		$id = false;
		$count = 0;
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}

		$time_start = microtime(true); 
		$key = "dacast_blog_update_6";

		$args = array(
			'post_type' => array('post', 'ufaq', 'epkb_post_type_1'),
			'numberposts' => -1
		);

		if($id) {
			$args['post__in'] = array($id);
		}

		$blogs = get_posts($args);

		foreach ($blogs as $blog){
			$change = false;
			if(!$id && get_post_meta($blog->ID, $key)){
				echo "<br>Already Updated: " . $blog->ID;
				$count++;
				continue;
			}

		
			if(isset($_GET['count'])){
				continue;
			}

			$content = $blog->post_content;
			
			$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

			$doc = new DOMDocument('1.0', 'utf-8');
			$doc->loadHTML($content);
			
			$xpathsearch = new DOMXPath($doc);
			$links = $xpathsearch->query('//a');  

			foreach($links as $link) {
				if (!$link->getAttribute("class")) {
					$change = true;
					$link->setAttribute("class", "dacast-link");
				}

				if (strpos($link->textContent, '[button') !== false) {
					$match = false;
					preg_match('/text="(.*?)"/', $link->textContent, $match);
					if($match && isset($match[1])) {
						$change = true;
						$link->textContent = $match[1];
						$link->nodeValue = $match[1];
						$link->setAttribute("class", "dacast-btn dacast-btn--primary");
						$link->setAttribute("href", "https://www.dacast.com/signup/");
					}
				}
			}


			$body = $doc->getElementsByTagName('body');
			$content = $doc->saveHTML($body->item(0));

			$content_new = preg_replace_callback('/(?=\[button)(.*)text="?(.*?)"(.*)]/', function ($match) {
								return "<a href=\"https://www.dacast.com/signup/\" class=\"dacast-btn dacast-btn--primary\">" . strtolower($match[2]). "</a>";
							}, $content);
		  
			if ($content!=$content_new) {
				$content = $content_new;
				$change = true;
			}

			$blog->post_content = $content;
			update_post_meta($blog->ID, $key, true);
			if ($change){
				var_dump(wp_update_post($blog));
			}
			echo "<br>Post Updated: " . $blog->ID;

			$execution_time = (microtime(true) - $time_start)/60;
			if($execution_time > 60) {
				break;
			}

		}
		var_dump($count);
	}
}
