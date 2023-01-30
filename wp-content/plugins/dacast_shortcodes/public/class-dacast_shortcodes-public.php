<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.dacast.com
 * @since      1.0.0
 *
 * @package    Dacast_shortcodes
 * @subpackage Dacast_shortcodes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dacast_shortcodes
 * @subpackage Dacast_shortcodes/public
 * @author     Arturo Schreiber <arturo.oficina@gmail.com>
 */
class Dacast_shortcodes_Public {

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

	public function form_process_shortcode( $atts, $content = null, $tag = '') {

		if(!isset($_POST['token'])){
			return '';
		}

		$secret = '6LeVIpMeAAAAAEz9yp3_S2Yncx2nAJNv2tXsEA7F';
		$token = $_POST['token'];

		$pardot_form = '';

		switch($_POST['action']){
			case 'contact':
				$pardot_form = 'https://go.pardot.com/l/755753/2022-03-02/21dyp5';
				break;
			case 'book-a-demo':
				$pardot_form = 'http://go.pardot.com/l/755753/2022-03-02/21dyny';
				break;
			case 'newsletter':
				$pardot_form = 'https://go.pardot.com/l/755753/2022-03-02/21dynw';
				break;
			default: 
				header('Location: https://www.dacast.com/');
				return '';
		}
 

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secret, 'response' => $token)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$r = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($r, true);
		
		if($response && isset($response['score']) && (float)$response['score'] > 0.25) {

			$post = $_POST;
			unset($post['token']);
			unset($post['action']);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$pardot_form);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$r = curl_exec($ch);
			curl_close($ch);
		}

		header('Location: https://www.dacast.com/thank-you-for-contacting-us/');

		return '';
	}

	public function add_shortcodes() {
		add_shortcode( 'dacast_form_process', array($this, 'form_process_shortcode') );

		add_shortcode( 'dacast_welcome_section', array($this, 'welcome_shortcode') );

		add_shortcode( 'dacast_mainfeatures', array($this, 'mainfeatures_shortcode') );
		add_shortcode( 'dacast_mainfeatures_content', array($this, 'mainfeatures_content_shortcode') );

		add_shortcode( 'dacast_boxes', array($this, 'boxes_shortcode') );
		add_shortcode( 'dacast_box', array($this, 'box_shortcode') );

		add_shortcode( 'dacast_testimonial', array($this, 'testimonial_shortcode') );

		add_shortcode( 'dacast_cta', array($this, 'cta_shortcode') );

		add_shortcode( 'dacast_popular_features', array($this, 'popular_features_shortcode') );
		add_shortcode( 'dacast_popular_feature', array($this, 'popular_feature_shortcode') );

		add_shortcode( 'dacast_faq', array($this, 'faq_shortcode') );
		add_shortcode( 'dacast_faq_box', array($this, 'faq_box_shortcode') );

		add_shortcode( 'dacast_reasons', array($this, 'reasons_shortcode') );
		add_shortcode( 'dacast_reasons_box', array($this, 'reasons_box_shortcode') );

		add_shortcode( 'dacast_textbox', array($this, 'textbox_shortcode') );
		add_shortcode( 'dacast_button', array($this, 'button_shortcode') );

		add_shortcode( 'dacast_cta_centered', array($this, 'cta_centered_shortcode') );

		add_shortcode( 'dacast_related_link', array($this, 'related_link') );

		add_shortcode( 'dacast_generic_section', array($this, 'generic_shortcode') );
		add_shortcode( 'dacast_generic_img', array($this, 'img_shortcode') );

		add_shortcode( 'dacast_flex_section', array($this, 'flex_shortcode') );
		add_shortcode( 'dacast_flex_box', array($this, 'flex_box_shortcode') );

		add_shortcode( 'dacast_box_figure', array($this, 'box_figure_shortcode') );
		add_shortcode( 'dacast_single_face', array($this, 'single_face') );

		add_shortcode( 'dacast_filled_box', array($this, 'filled_box_shortcode') );


	}

	public function filled_box_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'title_href' => '#',
			'subtitle' => '',
			'href' => '#',
			'href_title' => 'Read more',
			'color' => 'blue'
		), $atts );
		
		$output = '<div class="threeboxes-filled-box '.$fatts['color'].'">';
		$output .= '<h3><a href="'.$fatts['title_href'].'">'.$fatts['title'].'</a></h3>';
		$output .= '<p class="threeboxes-filled-box-subtitle dacast-subheading">'.$fatts['subtitle'].'</p>';
		$output .= '<a class="threeboxes-box-link normal-link dark-violet dacast-link" href="'.$fatts['href'].'">'.$fatts['href_title'].'</a>';
		$output .= '</div>';

		return $output;
	}

	public function single_face( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'img' => '',
			'name' => '',
			'title' => '',
			'linkedin' => '',
		), $atts );
		
		$output = '<div class="face-box divider">';
		if ($fatts['linkedin']) {
			$output .= '<a href="'.$fatts['linkedin'].'" target="_blank" rel="noopener noreferrer">';
		}
		$output .= '<div class="box-image">';
		$output .= '<img src="'.$fatts['img'].'" alt="" width="235" height="235" />';
		$output .= '</div>';
		if ($fatts['linkedin']) {
			$output .= '</a>';
		}

		$output .= '<h4>'.$fatts['name'].'</h4>';
		$output .= '<span>'.$fatts['title'].'</title>';
		if ($fatts['linkedin']) {
			$output .= '<a href="'.$fatts['linkedin'].'" target="_blank" rel="noopener noreferrer">';
			$output .= '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M38.3398 25.9307V35.8254H32.6031V26.5938C32.6031 24.2759 31.7748 22.6929 29.6978 22.6929C28.1127 22.6929 27.171 23.7586 26.7552 24.7905C26.6042 25.1593 26.5652 25.6714 26.5652 26.1887V35.8249H20.8281C20.8281 35.8249 20.9051 20.1897 20.8281 18.5713H26.5657V21.0163C26.5541 21.0355 26.5379 21.0544 26.5276 21.0727H26.5657V21.0163C27.3281 19.8432 28.6877 18.1661 31.7359 18.1661C35.5102 18.1661 38.3398 20.6321 38.3398 25.9307ZM14.8266 10.2544C12.8642 10.2544 11.5803 11.5426 11.5803 13.235C11.5803 14.8916 12.827 16.217 14.7513 16.217H14.7886C16.7895 16.217 18.0336 14.8916 18.0336 13.235C17.9955 11.5426 16.7895 10.2544 14.8266 10.2544ZM11.9213 35.8254H17.6563V18.5713H11.9213V35.8254Z" fill="#707A8A"></path></g><defs><clipPath id="clip0"><rect width="48" height="48" fill="white"></rect></clipPath></defs></svg>';
			$output .= '</a>';
		}

		$output .= '</div>';

		return $output;
	}

	public function box_figure_shortcode( $atts, $content = null, $tag = '') {
		$output = '<div class="boxfigure"><h4>';
		$output .= $content; 
		$output .= '</h4></div>';

		return $output;
	}

	public function flex_box_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'img' => '',
		), $atts );

		$output = '<div class="flex-box">';
		if ($fatts['img']) {
			$output .= '<img class="mainfeatures-image" src="'.$fatts['img'].'" alt="" />';
		}
		$output .= $content; 
		$output .= '</div>';

		return $output;
	}

	public function img_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'src' => '',
			'alt' => '',
		), $atts );

		$output = '<img src="'.$fatts['src'].'" alt="'.$fatts['alt'].'" />';

		return $output;
	}

	public function generic_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'color' => '',
		), $atts );

		$output = '<div class="section shortcode generic '.$fatts['color'].'">';
		$output .= $content; 
		$output .= '</div>';

		return $output;
	}

	public function flex_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'perrow' => '3',
			'color' => '',
		), $atts );

		$fatts['perrow'] = 'flex' . $fatts['perrow'];

		$output = '<div class="section shortcode flex '.$fatts['perrow'].' '.$fatts['color'].' ">';
		$output .= $content; 
		$output .= '</div>';

		return $output;
	}

	public function welcome_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'subtitle' => '',
		), $atts );

		$output = '<div class="section shortcode welcome">';
		$output .= '<div class="container">';
		$output .= '<h1 class="dacast-display01 dacast-display01--medium">'.$fatts['title'].'</h1>';
		$output .= '<p class="subtitle dacast-p1">'.$fatts['subtitle'].'</p>';
		$output .= $content; 
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function mainfeatures_shortcode( $atts, $content = null, $tag = '') {
		$output = '<div class="section shortcode mainfeatures">';
		$output .= '<div class="container">';
		$output .= $content; 
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function mainfeatures_content_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'type' => 'left',
			'title' => '',
			'subtitle' => '',
			'img' => '',
			'href' => '#',
			'href_title' => 'Tell me more',
		), $atts );
		
		$type = ( $fatts['type'] == 'left' ) ? 'left' : 'right';
		$output = '<div class="grid res-padding '.$type.'">';
 		if ($type == 'left') {
			$output .= '<img class="mainfeatures-image" src="'.$fatts['img'].'" alt="" width="580" height="400" />';
		}
		$output .= '<div class="mainfeatures-content">';
		$output .= '<h2 class="dacast dacast-medium">'.$fatts['title'].'</h2>';
		$output .= '<p class="subtitle dacast-p1">'.$fatts['subtitle'].'</p>';
		$output .= $content;
		$output .= '<a class="btn-arrow dacast-link dacast-link--arrow" href="'.$fatts['href'].'">'.$fatts['href_title'].'</a>';
		$output .= '</div>';
		if ($type != 'left') {
			$output .= '<img class="mainfeatures-image" src="'.$fatts['img'].'" alt="" width="580" height="400" />';
		}
		$output .= '</div>';

		return $output;
	}

	public function boxes_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'subtitle' => '',
		), $atts );

		$output = '<div class="section section-padding shortcode threeboxes">';
		$output .= '<div class="container res-padding">';
		$output .= '<div class="heading">';
		$output .= '<h4 class="grey-2 dacast dacast-medium">'.$fatts['title'].'</h2>';
		$output .= '<p class="subtitle dacast-subheading">'.$fatts['subtitle'].'</p>';
		$output .= '<div class="threeboxes-boxes">';
		$output .= $content; 
		$output .= '</div>'; 
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function box_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'subtitle' => '',
			'img' => '',
			'href' => '#',
			'href_title' => 'Read more',
		), $atts );
		
		$output = '<div class="threeboxes-box">';
		$output .= '<img class="threeboxes-box-image" src="'.$fatts['img'].'" alt="" width="80" height="80" />';
		$output .= '<h4 class="grey-2 dacast dacast-medium">'.$fatts['title'].'</h3>';
		$output .= '<p class="threeboxes-box-subtitle dacast-subheading">'.$fatts['subtitle'].'</p>';
		$output .= '<p class="threeboxes-box-description dacast-p2">'.$content.'</p>';
		$output .= '<a class="threeboxes-box-link normal-link dark-violet dacast-link" href="'.$fatts['href'].'">'.$fatts['href_title'].'</a>';
		$output .= '</div>';

		return $output;
	}

	public function testimonial_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'author' => '',
			'position' => '',
		), $atts );

		$output = '<div class="section bg-grey-10 shortcode testimonials">';
		$output .= '<div class="container">';
		$output .= '<img class="stars" src="https://www.dacast.com/wp-content/uploads/2021/06/Stars.png" alt="" width="225" height="48" />';
		$output .= '<h2 class="dacast dacast-medium dacast-medium--small">'.$content.'</h2>'; 
		$output .= '<h4 class="testimonials-meta"><span class="testimonials-author dacast dacast-medium dacast-medium--small">- '.$fatts['author'].',</span> '.$fatts['position'].'</h4>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function cta_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'subtitle' => '',
			'href' => '#',
			'href_title' => '',
		), $atts );
		
		$output = '<div class="section cta-section bg-grey shortcode">';
		$output .= '<h1 class="dacast dacast-medium">'.$fatts['title'].'</h2>';
		$output .= '<p class="subtitle dacast-subheading dacast-subheading--medium">'.$fatts['subtitle'].'</p>';
		$output .= $content;
		if ($fatts['href']) {
			$output .= '<a class="btn btn-blue btn-center dacast-btn dacast-btn--primary" href="'.$fatts['href'].'">'.$fatts['href_title'].'</a>';
		}
		$output .= '</div>';

		return $output;
	}

	public function popular_features_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
		), $atts );

		$output = '<div class="section section-padding-2 shortcode popularfeatures">';
		$output .= '<div class="container res-padding">';
		$output .= '<div class="heading">';
		$output .= '<h2 class="grey-2">'.$fatts['title'].'</h2>';
		$output .= '</div>';
		$output .= '<div class="popularfeatures-boxes">';
		$output .= $content; 
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function popular_feature_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'subtitle' => '',
			'img' => '',
			'href' => '',
			'href_title' => '',
		), $atts );

		$output = '<div class="popularfeatures-box">';
		$output .= '<img class="popularfeatures-box-image" src="'.$fatts['img'].'" alt="" width="80" height="80" />';
		$output .= '<h3>'.$fatts['title'].'</h2>';
		$output .= '<p class="popularfeatures-box-subtitle">'.$fatts['subtitle'].'</p>';
		$output .= '<p class="popularfeatures-box-description">'.$content.'</p>'; 
		$output .= '<a class="popularfeatures-box-link dark-violet dacast-link" href="'.$fatts['href'].'">'.$fatts['href_title'].'</a>';
		$output .= '</div>';

		return $output;
	}

	public function faq_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
		), $atts );

		$output = '<div class="section section-padding-2 shortcode faq">';
		$output .= '<div class="container res-padding">';
		$output .= '<h2 class="text-center">'.$fatts['title'].'</h2>';
		$output .= '<div class="faq-boxes">';
		$output .= $content; 
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function faq_box_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
            'href' => '',
		), $atts );

		$output = '<div class="faq-box">';
        if(isset($fatts['href'])) {
            $output .= '<a href="'.$fatts['href'].'">';
        }
        $output .= '<h3>'.$fatts['title'].'</h3>';
        if(isset($fatts['href'])) {
            $output .= '</a>';
        }
		$output .= $content;
		$output .= '</div>';

		return $output;
	}

	public function reasons_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'subtitle' => '',
		), $atts );

		$output = '<div class="section section-padding-3 text-center shortcode reasons">';
		$output .= '<div class="container res-padding">';
		$output .= '<h2>'.$fatts['title'].'</h2>';
		$output .= '<p class="subtitle">'.$fatts['subtitle'].'</p>';
		$output .= '<div class="reasons-boxes">';
		$output .= $content; 
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function reasons_box_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'title' => '',
			'title_b' => '',
			'href' => '#',
			'href_title' => '',
		), $atts );

		$output = '<div class="reasons-box">';
		$output .= '<h3>'.$fatts['title'].'</h3>';
		$output .= '<div class="reasons-hover">';
		$output .= '<h4>'.$fatts['title_b'].'</h4>';
		$output .= $content; 
		$output .= '</div>';
		$output .= '<a class="btn-arrow dacast-link dacast-link--arrow" href="'.$fatts['href'].'">'.$fatts['href_title'].'</a>';
		$output .= '</div>';

		return $output;
	}

	public function related_link( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'href' => '#',
		), $atts );

		$output = '<div class="related-link">';
		$output .= '<a class="dacast-link" href="'.$fatts['href'].'">'.$content.'</a>';
		$output .= '</div>';

		return $output;
	}

	public function textbox_shortcode( $atts, $content = null, $tag = '') {
		$output = '<p class="textbox">'.$content.'</p>';

 		return $output;
	}

	public function cta_centered_shortcode( $atts, $content = null, $tag = '') {

		$output = '<div class="form-wrapper--sign-up-cta centered" id="signup-CTA">';
		$output .= '<div class="btn-wrapper--sign-up-cta">';
		$output .= '<form name="signup-form" id="signup-form" class="start-free-trial" action="/signup" noValidate >';
		$output .= '<input type="email" placeholder="Email" class="dacast-input dacast-input--sign-up-cta" name="email" />';
		$output .= '</form>';
		$output .= '<button type="submit" form="signup-form" class="dacast-btn dacast-btn--primary dacast-btn-large" id="signup-CTA-btn" >';
		$output .= 'Start Free Trial';
		$output .= '</button>';
		$output .= '</div>';
		$output .= '<p class="dacast-caption error-message" id="sign-up-error"></p>';
		$output .= '<p class="dacast-caption">';
		$output .= 'No credit card required. By clicking Start Free Trial you agree to our';
		$output .= '<a class="dacast-link" href="/terms-of-service/">';
		$output .= 'terms and conditions.';
		$output .= '</a>';
		$output .= '</p>';
		$output .= '</div>';

		return $output;
	}

	public function button_shortcode( $atts, $content = null, $tag = '') {
		$fatts = shortcode_atts( array(
			'type' => 'violet',
			'href' => '#',
		), $atts );
        
		if(false && $content == "Start Free Trial") {
			$output = '<div class="form-wrapper--book-a-demo" id="signup-CTA">';
			$output .= '<div class="btn-wrapper--book-a-demo">';
			$output .= '  <form name="signup-form" id="signup-form" class="start-free-trial" action="/signup">';
			$output .= '	<input';
			$output .= '	  type="email"';
			$output .= '	  placeholder="Email"';
			$output .= '	  class="dacast-input dacast-input--book-a-demo"';
			$output .= '	  name="email" />';
			$output .= '  </form>';
			$output .= '  <button';
			$output .= '	type="submit"';
			$output .= '	form="signup-form"';
			$output .= '	class="dacast-btn dacast-btn--primary dacast-btn-large"';
			$output .= '	id="signup-CTA-btn">Start Free Trial</button>';
			$output .= '</div>';
			$output .= '<p class="dacast-caption error-message">Please provide a valid email</p>';
			$output .= '<p class="dacast-caption">';
			$output .= 'No credit card required. By clicking Start Free Trial you agree to our ';
			$output .= '<a class="dacast-link" href="/terms-of-service/">terms</a> and <a class="dacast-link" href="/terms-of-service/"> conditions</a>';
			$output .= '</p>';
			$output .= '</div>';

			return $output;
		}

        $dacast_type = "primary";

		$output = '<a class="btn btn-'.$fatts['type'].' btn-center dacast-btn dacast-btn--'.$dacast_type.'" href="'.$fatts['href'].'">'.$content.'</a>';

 		return $output;
	}

}
