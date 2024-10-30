<?php
/*
    Plugin Name: Media Library Unsplash
    Plugin URI: https://wordpress.org/plugins/media-library-unsplash/
    Description: One click image uploads directly to wordpress media library from Unsplash
    Version: 1.0.0
    Requires at least: 5.8
    Requires PHP: 5.6.20
    Author: Touhidul Sadeek
    Author URI: https://tcoderbd.com/
    License: GPLv2 or later
    Text Domain: media-library-unsplash
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Define Path
 * @since 1.0.0
 * @author tCoderBD <touhid@tcoderbd.com>
 * @package MediaLibraryUnsplash
 */
define ( 'TCBDAML_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define ( 'TCBDAML_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'TCBDAML_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Require Files
 * @since 1.0.0
 * @author tCoderBD <touhid@tcoderbd.com>
 * @package MediaLibraryUnsplash
 */
require_once( TCBDAML_PATH . 'inc/enqueue.php');
require_once( TCBDAML_PATH . 'inc/admin.php');