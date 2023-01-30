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
 * @package    Dacast_graphql
 * @subpackage Dacast_graphql/includes
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
 * @package    Dacast_graphql
 * @subpackage Dacast_graphql/includes
 * @author     Arturo Schreiber <arturo.schreiber@dacast.com>
 */
class Dacast_graphql {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dacast_graphql_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'DACAST_GRAPHQL_VERSION' ) ) {
			$this->version = DACAST_GRAPHQL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'dacast_graphql';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dacast_graphql_Loader. Orchestrates the hooks of the plugin.
	 * - Dacast_graphql_i18n. Defines internationalization functionality.
	 * - Dacast_graphql_Admin. Defines all hooks for the admin area.
	 * - Dacast_graphql_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dacast_graphql-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dacast_graphql-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dacast_graphql-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dacast_graphql-public.php';

		$this->loader = new Dacast_graphql_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dacast_graphql_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Dacast_graphql_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Dacast_graphql_Admin( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Dacast_graphql_Public( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'parse_request', $plugin_public, 'print_comments' );
		$this->loader->add_action( 'parse_request', $plugin_public, 'process_contact' );
		$this->loader->add_action( 'acf/init', $plugin_public, 'acf_fields' );
		
		add_filter( 'wpml_is_redirected', function( $is_redirect ) {
			if ( is_graphql_request() ) {
				return false;
			}
			return $is_redirect;
		});

        add_filter( 'register_post_type_args', function( $args, $post_type ) {                   
           if ( 'ufaq' === $post_type ) {
               $args['show_in_graphql'] = true;
               $args['graphql_single_name'] = 'faq';
               $args['graphql_plural_name'] = 'faqs';
           }
            return $args;
        }, 10, 2 );

		add_filter( 'register_taxonomy_args', function( $args, $taxonomy ) {
                   
           if ( 'ufaq-category' === $taxonomy ) {
               $args['show_in_graphql'] = true;
               $args['graphql_single_name'] = 'faqCategory';
               $args['graphql_plural_name'] = 'faqCategories';
           }

            return $args;
        }, 10, 2 );
        
		add_action( 'graphql_register_types', function() {
			register_graphql_field( 'ContentNode', 'relatedPost', [
				'type' => ['list_of' => 'post'],
				'description' => __( '5 related posts', 'dacast' ),
				'resolve' => function( \WPGraphQL\Model\Post $post, $args, $context, $info ) {
                   return $this->get_related($post);
				}
			]);
                   
           register_graphql_field( 'ContentNode', 'relatedArticle', [
               'type' => ['list_of' => 'article'],
               'description' => __( '5 related posts', 'dacast' ),
               'resolve' => function( \WPGraphQL\Model\Post $post, $args, $context, $info ) {
                  return $this->get_related($post);
               }
           ]);
                   
		   register_graphql_field( 'ContentNode', 'relatedFaq', [
			   'type' => ['list_of' => 'faq'],
			   'description' => __( '5 related posts', 'dacast' ),
			   'resolve' => function( \WPGraphQL\Model\Post $post, $args, $context, $info ) {
				  return $this->get_related($post);
			   }
		   ]);
                   
		   register_graphql_field( 'ContentNode', 'tableOfContent', [
			   'type' => ['list_of' => 'String'],
			   'description' => __( 'Table of contents', 'dacast' ),
			   'resolve' => function( \WPGraphQL\Model\Post $post, $args, $context, $info ) {
				  return $this->get_table_of_contents($post);
			   }
		   ]);

		  register_graphql_field( 'ContentNode', 'translatedCategoryName', [
			'type' => ['list_of' => 'String'],
			'description' => __( 'All categories, including wpml', 'dacast' ),
			'resolve' => function( \WPGraphQL\Model\Post $post, $args, $context, $info ) {
			   return $this->get_categories_name($post);
			}
		  ]);

		  register_graphql_field( 'ContentNode', 'translatedCategoryUri', [
			'type' => ['list_of' => 'String'],
			'description' => __( 'All categories, including wpml', 'dacast' ),
			'resolve' => function( \WPGraphQL\Model\Post $post, $args, $context, $info ) {
			   return $this->get_categories_uri($post);
			}
		  ]);

		  register_graphql_field( 'User', 'descriptionEs', [
			'type' => 'String',
			'description' => __( 'Author Biography spanish', 'dacast' ),
			'resolve' => function( \WPGraphQL\Model\User $user, $args, $context, $info ) {
			   return $this->get_description($user, 'es');
			}
		  ]);

		  register_graphql_field( 'User', 'descriptionIt', [
			'type' => 'String',
			'description' => __( 'Author Biography Italian', 'dacast' ),
			'resolve' => function( \WPGraphQL\Model\User $user, $args, $context, $info ) {
			   return $this->get_description($user, 'it');
			}
		  ]);
		  
		  register_graphql_field( 'User', 'descriptionFr', [
			'type' => 'String',
			'description' => __( 'Author Biography French', 'dacast' ),
			'resolve' => function( \WPGraphQL\Model\User $user, $args, $context, $info ) {
			   return $this->get_description($user, 'fr');
			}
		  ]);
		  
		  register_graphql_field( 'User', 'descriptionPt', [
			'type' => 'String',
			'description' => __( 'Author Biography Portuguese', 'dacast' ),
			'resolve' => function( \WPGraphQL\Model\User $user, $args, $context, $info ) {
			   return $this->get_description($user, 'pt');
			}
		  ]);
                   
		} );

	}

	public function get_description($user, $language) {
		$description = get_field('description_' . $language, "user_" . $user->databaseId);
		return  $description;
	}

	public function get_table_of_contents($post) {

		$post = get_post($post->databaseId);

		$return = [];

		$content = $post->post_content;

			
		$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->loadHTML($content);
		
		$xpathsearch = new DOMXPath($doc);
		$titles = $xpathsearch->query('//h2');  

		foreach($titles as $title) {
			$return[] = $title->textContent;
		}

		return $return;
	}
	
    public function get_categories_name($post) {

		$tpost = get_post($post->databaseId);

		$return = [];

		$category = "category";
		$post_type = $tpost->post_type;

		switch($post_type) {
			case "epkb_post_type_1":
				$category = "epkb_post_type_1_category";
				break;
			case "ufaq":
				$category = "ufaq-category";
				break;
			default:
				break;
		}


		global $sitepress;

		if	($sitepress) {
			$post_lang = wpml_get_language_information($post->databaseId);

			if($post_lang){
				$sitepress->switch_lang($post_lang['language_code']);
			}
		}

		$categories = wp_get_post_terms($post->databaseId, $category);

		$cat_array = [];

		if(!$categories) {
			return $return;
		}

		foreach($categories as $c) {
			$term = get_term( $c , $category );
			$url = get_term_link($term);
			$return[] = $term->name;
		}

		return $return;
	} 


    public function get_categories_uri($post) {

		$tpost = get_post($post->databaseId);

		$return = [];

		$category = "category";
		$post_type = $tpost->post_type;

		switch($post_type) {
			case "epkb_post_type_1":
				$category = "epkb_post_type_1_category";
				break;
			case "ufaq":
				$category = "ufaq-category";
				break;
			default:
				break;
		}


		global $sitepress;

		if	($sitepress) {
			$post_lang = wpml_get_language_information($post->databaseId);

			if($post_lang){
				$sitepress->switch_lang($post_lang['language_code']);
			}
		}

		$categories = wp_get_post_terms($post->databaseId, $category);

		$cat_array = [];

		if(!$categories) {
			return $return;
		}

		foreach($categories as $c) {
			$term = get_term( $c , $category );
			$url = get_term_link($term);
			$return[] = $url;
		}

		return $return;
	} 

    public function get_related($post) {

		global $sitepress;
        $relatedPosts = [];

		if	($sitepress) {
			$post_lang = wpml_get_language_information($post->databaseId);

			if($post_lang){
				$sitepress->switch_lang($post_lang['language_code']);

				$related_query = new WP_Query(array(
					'post_type' => $post->post_type,
					'category__in' => wp_get_post_categories($post->databaseId),
					'post__not_in' => array($post->databaseId),
					'posts_per_page' => 5,
					'orderby' => 'date',
					'suppress_filter' => true,
				));
					
				$posts = $related_query->posts;

				foreach($posts as $p) {
					$relatedPosts[] = new \WPGraphQL\Model\Post($p);
				}
			} 

			if(count($relatedPosts) > 3) {
				return $relatedPosts;
			}

			$default_lang = $sitepress->get_default_language();
			$sitepress->switch_lang($default_lang);

		}


        $related_query = new WP_Query(array(
            'post_type' => $post->post_type,
            'category__in' => wp_get_post_categories($post->databaseId),
            'post__not_in' => array($post->databaseId),
            'posts_per_page' => 5,
            'orderby' => 'date',
			'suppress_filter' => true,
        ));
            
        $posts = $related_query->posts;

        foreach($posts as $p) {
            $relatedPosts[] = new \WPGraphQL\Model\Post($p);
        }

       return $relatedPosts;
    }
    
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
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
	 * @return    Dacast_graphql_Loader    Orchestrates the hooks of the plugin.
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
