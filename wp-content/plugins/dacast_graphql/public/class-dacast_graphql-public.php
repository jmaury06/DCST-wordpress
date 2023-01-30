<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_graphql
 * @subpackage Dacast_graphql/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dacast_graphql
 * @subpackage Dacast_graphql/public
 * @author     Arturo Schreiber <arturo.schreiber@dacast.com>
 */

use WPGraphQL\AppContext;

class Dacast_graphql_Public {

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
		 * defined in Dacast_graphql_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_graphql_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dacast_graphql-public.css', array(), $this->version, 'all' );

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
		 * defined in Dacast_graphql_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dacast_graphql_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dacast_graphql-public.js', array( 'jquery' ), $this->version, false );

	}

	public function print_comments() {
		if(isset($_GET['print_comments'])) {

			$post_id = (int) $_GET['print_comments'];

			$comments = get_comments(array(
				'post_id' => $post_id,
				'status' => 'approve'
			));

			wp_list_comments( 
				array( 
					'callback' => 'dacast_comment_template',
					'reverse_top_level' => true 
				), $comments);
			exit;
		}
	}

	public function process_contact() {
		if(isset($_GET['process_contact'])) {

			var_dump($_GET);
			var_dump($_POST);
			exit;
		}
	}

	public function acf_fields() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_617faa8aa8cd1',
				'title' => 'Biography Translations',
				'fields' => array(
					array(
						'key' => 'field_617fad60f231e',
						'label' => 'Biography Spanish',
						'name' => 'description_es',
						'type' => 'textarea',
						'instructions' => 'Spanish translation of biography',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_617fb1ac40365',
						'label' => 'Biography French',
						'name' => 'description_fr',
						'type' => 'textarea',
						'instructions' => 'French translation of biography',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_617fb23240366',
						'label' => 'Biography Italian',
						'name' => 'description_it',
						'type' => 'textarea',
						'instructions' => 'Italian translation of biography',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_617fb28740367',
						'label' => 'Biography Portuguese',
						'name' => 'description_pt',
						'type' => 'textarea',
						'instructions' => 'French translation of biography',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'user_form',
							'operator' => '==',
							'value' => 'edit',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => 'Translated Bio',
			));
			
		endif;
	}

}



function dacast_comment_template( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

    header('Access-Control-Allow-Origin: *');

	?>
	<li id="comment_<?php comment_ID(); ?>" class="comment_box">
		<div class="principal">
			<div class="comment">
				<div class="avatar">
					<?php echo get_avatar( $comment, 128 ); ?>
				</div>
			
				<div class="information">
					<h4 class="name"><?php echo get_comment_author_link(); ?></h4>
					<p class="description"><?php comment_text(); ?></p>
					<p class="reply">
						<time datetime="<?php comment_time( 'c' ); ?>" class="pull-left">
							<?php printf( _x( '%1$s', '1: date', 'dacast' ), get_comment_date() ); ?>
						</time>
					</p>
				</div>
			</div>
		</div>
		
	<?php 
}
