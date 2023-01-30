<?php
/**
 * Force WP JSON REST API endpoints to always be served over HTTPS
 *
 * @action wp_json_server_before_serve
 *
 * @return void
 */

DEFINE("DACAST_VERSION", "1.1");

function fjarrett_wp_json_force_ssl() {
    if ( is_ssl() ) {
        return;
    }

    $json_url = esc_url_raw( $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    $redirect = set_url_scheme( $json_url, 'https' );

    wp_safe_redirect( $redirect, 301 );

    exit;
}
add_action( 'wp_json_server_before_serve', 'fjarrett_wp_json_force_ssl' );
// Add custom Theme Functions here

// add_action( 'cron_sf', 'cronSf' );
/**
 * Adds a 'Tuts+ Options' submenu to the 'Settings'
 * menu in the WordPress administration menu.
 */
function cronSf() {
    shell_exec('php /code/integration/GoogleAds_SF/sf_leads.php');
}

/*
 * Make sure canonical is always www.dacast.com.
 */
function dacast_correct_canonical($url, $presentation) {
    $parsed = parse_url($url);
    if( isset($parsed['host']) && $parsed['host'] != 'www.dacast.com') {
        $url = str_replace($parsed['host'], 'www.dacast.com', $url);
    }
    return $url;
}

add_filter('wpseo_canonical', 'dacast_correct_canonical', 10, 2);

/**
 * Enqueue scripts and styles.
 */
function datacast_scripts() {
  global $post;
  $exception_posts = array(65849, 65844, 67869);

  if ( in_array($post->ID, $exception_posts) ) {
    wp_enqueue_style('pricing-styles', get_stylesheet_directory_uri() . '/assets/css/pricing-styles.css', array(), DACAST_VERSION);
    wp_enqueue_style('pricing-general-styles', get_stylesheet_directory_uri() . '/assets/css/general.css', array(), DACAST_VERSION);
    wp_enqueue_style('pricing-rc-styles', get_stylesheet_directory_uri() . '/assets/css/rc-styles.css', array(), DACAST_VERSION);
    wp_enqueue_style('pricing-rl-styles', get_stylesheet_directory_uri() . '/assets/css/rl-styles.css', array(), DACAST_VERSION);
    wp_enqueue_script('pricing-main-scripts', get_stylesheet_directory_uri() . '/assets/js/main-pricing.js', array(), DACAST_VERSION, true);
  }

}
add_action( 'wp_enqueue_scripts', 'datacast_scripts' );

add_filter('the_content', 'dacast_wpauto_control', 9);

function dacast_wpauto_control($content) {
  global $post;

  $exception_posts = array(67869,71566,77048,74543,77052,75555,77056,81568,81507,81511,81514,81962,81966,81969,82390,82604,82607,82610,82613,82617,82620,82623,83415,83421,83411,83424,83427,83430,83418,83436,83439,84382,98998,103731,103833,104844,104875,104935,104961,105008,105011,106621,106626,106629,106633,106637,112029,112812,114020,114025,114141,114145,114148);

  if ( in_array($post->ID, $exception_posts) ) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
  }

  return $content;
}
    
function dacast_modify_jquery() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', false, '3.6.0');
  wp_enqueue_script('jquery');
  wp_enqueue_script('nav-main-script', get_stylesheet_directory_uri() . '/assets/js/nav.js', array(), DACAST_VERSION, true);
}
add_action('init', 'dacast_modify_jquery');

function dacast_add_conversion_js() {
  global $post;
  $postid = $post->ID;

  if ($postid == '68066')
  {
    ?>
<!-- Event snippet for Get $250 Off conversion page -->
<script>
jQuery('.conversion_button').on('click', function() {
  gtag('event', 'conversion', {'send_to': 'AW-1001468809/zLryCI7pgPsBEInnxN0D'});
});
</script>
    <?php
  }
}
add_action( 'wp_enqueue_scripts', 'dacast_add_conversion_js', 99);

function dacast_mime_options($mimes){
    $mimes['svg']  = 'image/svg+xml';
    $mimes['webp']  = 'image/webp';
    $mimes['jpeg']  = 'image/jpeg';
    
    return $mimes;
}
add_filter('upload_mimes','dacast_mime_options');


function dacast_wpml_redirect( $is_redirect ) {
  if ( function_exists('is_graphql_request') ) { 
    if( is_graphql_request() ) {
      return false;
    }
  }
  return $is_redirect;
}
add_filter( 'wpml_is_redirected', 'dacast_wpml_redirect' );

function dacast_graphql_endpoint() {
  return 'gatsby_feed';
};
add_filter( 'graphql_endpoint', 'dacast_graphql_endpoint' );

function dacast_enable_strict_transport_security_hsts_header_wordpress() {
    header( 'Strict-Transport-Security: max-age=10886400; includeSubDomains; preload' );
}
add_action( 'send_headers', 'dacast_enable_strict_transport_security_hsts_header_wordpress' );
