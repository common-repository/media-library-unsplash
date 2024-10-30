<?php
/**
 * Load Enqueue Files
 * @since 1.0.0
 * @author tCoderBD <touhid@tcoderbd.com>
 * @package MediaLibraryUnsplash
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function tcbdaml_load_scripts() {	
    $key = get_option('tcbdaml_api_key') ? get_option('tcbdaml_api_key'):'fLP3n0KuOOf57XLLeQ8zoqN4f5PeBEBOZLxMxI8iVcw';

    wp_enqueue_style('tcbdaml', TCBDAML_URL .'assets/css/style.min.css', array(), '1.0.0' );
    wp_enqueue_script( 'tcbdaml', TCBDAML_URL . 'assets/js/bundle.min.js', [ 'jquery' ], '1.0.0', true ); 
    wp_localize_script('tcbdaml', 'tcbdaml_object', array(
        'ajax_url'	=> admin_url('admin-ajax.php'),
        'nonce'		=> wp_create_nonce('tcbdaml_image_upload_nonce'),
        'key'		=> $key
    ));
}
add_action('admin_enqueue_scripts','tcbdaml_load_scripts');