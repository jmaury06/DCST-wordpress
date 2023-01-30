<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_knowledgebase
 * @subpackage Dacast_knowledgebase/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dacast_knowledgebase
 * @subpackage Dacast_knowledgebase/admin
 * @author     Arturo Schreiber <arturo.schreiber@dacast.com>
 */
class Dacast_knowledgebase_Admin {

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
		 * defined in Dacast_knowledgebase_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_knowledgebase_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dacast_knowledgebase-admin.css', array(), $this->version, 'all' );

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
		 * defined in Dacast_knowledgebase_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_knowledgebase_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dacast_knowledgebase-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_knowledgebase() {

		$labels = array(
			'name'              => _x( 'Category', 'taxonomy general name', 'dacast' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'dacast' ),
			'search_items'      => __( 'Search Knowledgebase Category', 'dacast' ),
			'all_items'         => __( 'All Knowledgebase Categories', 'dacast' ),
			'parent_item'       => __( 'Parent Knowledgebase Category', 'dacast' ),
			'parent_item_colon' => __( 'Parent Knowledgebase Category:', 'dacast' ),
			'edit_item'         => __( 'Edit Knowledgebase Category', 'dacast' ),
			'update_item'       => __( 'Update Knowledgebase Category', 'dacast' ),
			'add_new_item'      => __( 'Add New Knowledgebase Category', 'dacast' ),
			'new_item_name'     => __( 'New Knowledgebase Category Name', 'dacast' ),
			'menu_name'         => __( 'Category', 'dacast' ),
		);
	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'knowledgebase_category' ),
			'show_in_graphql' 	=> true,
			'graphql_single_name' => 'articleCategory',
			'graphql_plural_name' => 'articleCategories',
	 );
	
		register_taxonomy( 'knowledgebase_category', array( 'knowledgebase' ), $args );
	
		unset( $args );
		unset( $labels );

		$labels = array(
			'name'                => _x( 'Knowledge Base', 'Post Type General Name', 'dacast' ),
			'singular_name'       => _x( 'Knowledge Base', 'Post Type Singular Name', 'dacast' ),
			'menu_name'           => __( 'Knowledge Base', 'dacast' ),
			'all_items'           => __( 'All Knowledge Base', 'dacast' ),
			'view_item'           => __( 'View Knowledge Base', 'dacast' ),
			'add_new_item'        => __( 'Add New Knowledge Base', 'dacast' ),
			'add_new'             => __( 'Add New', 'dacast' ),
			'edit_item'           => __( 'Edit Knowledge Base', 'dacast' ),
			'update_item'         => __( 'Update Knowledge Base', 'dacast' ),
			'search_items'        => __( 'Search Knowledge Base', 'dacast' ),
			'not_found'           => __( 'Knowledge Base Not Found', 'dacast' ),
			'not_found_in_trash'  => __( 'Knowledge Base Not found in Trash', 'dacast' ),
		);
		 
		$args = array(
			'label'               => __( 'Knowledge Base', 'dacast' ),
			'description'         => __( 'Knowledge Base and Faqs', 'dacast' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			'taxonomies'          => array( 'genres' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'rewrite'             => array( 'slug' => 'support/knowledgebase' ),
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
			'show_in_graphql' => true,
			'graphql_single_name' => 'article',
			'graphql_plural_name' => 'articles',
		);

		register_post_type( 'knowledgebase', $args );

		
	}

	public function add_mce_code() {
		global $pagenow;

		if (!current_user_can ('edit_posts') && !current_user_can ('edit_pages'))
		return;

		if (get_user_option('rich_editing') != 'true')
		return;
	
		if (in_array ($pagenow, array('post.php', 'post-new.php', 'page.php', 'page-new.php'))) {
			add_filter ('mce_external_plugins', array($this, 'wicc_tinymce_addplugin') );
			add_filter ('mce_buttons', array($this, 'wicc_tinymce_registerbutton') );
		}
	}

	public function wicc_tinymce_addplugin ($plugin_array) {
		$plugin_array['wicc'] = plugins_url ('wicc-mce-plugin.php', __FILE__);
		return $plugin_array;
	}
	
	public function wicc_tinymce_registerbutton ($buttons) {
		array_push ($buttons, 'separator', 'wicc');
		return $buttons;
	}

	public function dacast_knowledgebase_actions_menu() {
		add_submenu_page( 
			null, 
			'B',
			'B',
			'manage_options',
			'dacast_knowledgebase_actions',
			array($this, 'dacast_knowledgebase_actions'),
		);
	}

	public function dacast_knowledgebase_actions() {
		if(isset($_GET['knowledgebase_migration'])){
			$this->dacast_knowledgebase_migration();
		}
		if(isset($_GET['knowledgebase_purge'])){
			$this->dacast_knowledgebase_purge();
		}
		if(isset($_GET['knowledgebase_purge_duplicates'])){
			$this->dacast_knowledgebase_duplicate_purge();
		}
		if(isset($_GET['knowledgebase_fix_uris'])){
			$this->knowledgebase_fix_uris();
		}
		if(isset($_GET['knowledgebase_url_list'])){
			$this->knowledgebase_url_list();
		}
	}

	public function knowledgebase_url_list() {
		$args = array(
			'post_type' => array('knowledgebase'),
			'numberposts' => -1
		);
	
		$count = 0;

		$blogs = get_posts($args);	
		foreach ($blogs as $blog) {
			echo "<p>" . $blog->guid . "</p>";
		}
	}

	public function knowledgebase_fix_uris() {
		$key = 'dacast_meta_map';

		$args = array(
			'post_type' => array('knowledgebase'),
			'numberposts' => -1
		);
	
		$count = 0;

		$blogs = get_posts($args);	
		foreach ($blogs as $blog){ 
			$map_to = get_post_meta($blog->ID, $key, true);
			$mapped = get_post($map_to);

			if($blog->post_name != $mapped->post_name) {
				$my_post = array(
					'ID'           => $blog->ID,
					'post_name'   => $mapped->post_name,
				);

				wp_update_post( $my_post );
							  
				$count++;
			}
		}
		var_dump($count);
		echo "done";
	}

	public function dacast_knowledgebase_purge() {

		$key = 'dacast_meta_map';

		$args = array(
			'post_type' => array('knowledgebase'),
			'numberposts' => -1
		);
	
		$blogs = get_posts($args);	

		foreach ($blogs as $blog){ 
			$id = $blog->ID;
			$map_to = get_post_meta($blog->ID, $key, true);
			delete_post_meta($blog->ID, $key);
			delete_post_meta($map_to, $key);
			wp_delete_post($blog->ID, true);
			echo "Deleted: $id";
		}

		$args = array(
			'post_type' => array('epkb_post_type_1'),
			'meta_query' => array(
				array(
				'key' => $key,
				'compare' => 'EXISTS',
				),
			),
			'numberposts' => -1
		);

		$blogs = get_posts($args);
		foreach ($blogs as $blog){ 
			delete_post_meta($blog->ID, $key);
		}
	}
	public function dacast_knowledgebase_duplicate_purge() {

		$key = 'dacast_meta_map';

		$args = array(
			'post_type' => array('knowledgebase'),
			'meta_query' => array(
				array(
				 'key' => $key,
				 'compare' => 'NOT EXISTS',
				 'value' => '',				
				),
			),
			'numberposts' => -1
		);
	
		$blogs = get_posts($args);	

		foreach ($blogs as $blog){ 
			wp_delete_post($blog->ID, true);
			echo "Deleted: $blog->ID";		
		}

		$args = array(
			'post_type' => array('knowledgebase'),
			'numberposts' => -1
		);
	
		if( isset($_GET['offset']) ){
			$args['offset'] = $_GET['offset'];
		}

		$blogs = get_posts($args);	

		foreach ($blogs as $blog){ 
			if(!get_post_status ( $blog->ID )) {
				continue;
			}

			$meta = get_post_meta($blog->ID, $key, true);

			if(!$meta) {
				echo "POST WITHOUT META $blog->ID";
				continue;
			}
			$args2 = array(
				'post_type' => array('knowledgebase'),
				'meta_query' => array(
					array(
						'key' => $key,
						'value' => $meta,
						'compare' => '=',
					)
				)
			);
			$dupes = get_posts($args2);	
			if(count($dupes) > 1) {
				foreach($dupes as $dupe) {
					if($dupe->ID != $blog->ID) {
						wp_delete_post($dupe->ID, true);
						echo "Deleted: $dupe->ID";			
					}
				}
			}	
		}

	}

	public function dacast_knowledgebase_migration() {
		global $sitepress;
		$sitepress->switch_lang($sitepress->get_default_language());

		$key = 'dacast_meta_map';

		$terms = get_terms( array(
			'taxonomy' => 'epkb_post_type_1_category',
			'hide_empty' => false,
			'suppress_filters' => true
		) );


		foreach($terms as $term) {
			$term_map = get_term_meta( $term->term_id, $key, true);

			if($term_map) {
				continue;
			}
			$new_term = wp_insert_term(
				$term->name,
				'knowledgebase_category',
				array(
					'description' => $term->description,
					'slug'        => $term->slug,
				)
			);

			if(!$new_term || is_wp_error($new_term)) {
				var_dump($new_term);
				exit;
			}

			add_term_meta( $term->term_id, $key , $new_term['term_id'] );
			add_term_meta( $new_term['term_id'], $key , $term->term_id );
		}

		$nid = false;

		if(isset($_GET['id'])) {
			$nid = explode(',', $_GET['id']);
		}

		if($nid) {			
			$args = array(
				'post_type' => array('epkb_post_type_1'),
				'post__in' => $nid,
				'numberposts' => -1
			);
		} else {
			$args = array(
				'post_type' => array('epkb_post_type_1'),
				'meta_query' => array(
					array(
					'key' => $key,
					'compare' => 'NOT EXISTS',
					'value' => '',				
					),
				),
				'numberposts' => -1
			);
		}
	
		$blogs = get_posts($args);	

		if(isset($_GET['count'])) {
			var_dump(count($blogs));
			exit;
		}

		foreach ($blogs as $blog){ 
			$id = $blog->ID;
			$sitepress->switch_lang($sitepress->get_default_language());
			if(!$nid && get_post_meta($blog->ID, $key, true)) {
				continue;
			}
			$new = array (
				'post_content' => $blog->post_content,
				'post_title' => $blog->post_title,
				'post_type' => 'knowledgebase',
				'post_status' => $blog->post_status,
				'post_author' => $blog->post_author,
				'post_date' => $blog->post_date,
				'post_date_gmt' => $blog->post_date_gmt,
				'post_modified' => $blog->post_modified,
				'post_modified_gmt' => $blog->post_modified_gmt,
			);

			$args = array(
				'post_type' => array('knowledgebase'),
				'meta_query' => array(
					array(
						'key' => $key,
						'value' => $id,
						'compare' => '=',
					)
				)
			);
			$query = get_posts($args);
			if (!$nid && count($query) > 0) {
				echo "Duplicated: $blog->ID";
				continue;
			}

			$new_id = wp_insert_post($new);

			update_post_meta($id, $key, $new_id);
			update_post_meta($new_id, $key, $id);

			$data = get_post_custom($id);
			foreach ( $data as $name => $values) {
				foreach ($values as $value) {
					if ($name == '$key') {
						continue;
					}
					update_post_meta($new_id, $name, $value);
				}
			}

			update_post_meta($id, $key, $new_id);
			update_post_meta($new_id, $key, $id);

			$term_list = wp_get_post_terms( $id, 'epkb_post_type_1_category' );
			foreach($term_list as $tl) {
				$new_term_id = get_term_meta( $tl->term_id, $key, true);
				if($new_term_id) {
					$tag = array( (int) $new_term_id );
					wp_set_post_terms( $new_id, $tag, 'knowledgebase_category' );
				} else {
					echo "no meta term id";
					var_dump($tl);
					exit;
				}
			}

			echo "Posted $blog->ID as $new_id \n";
		}

	}
}
